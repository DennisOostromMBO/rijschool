<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index(Request $request)
    {
        $payments = Payment::with(['invoice.registration.student.user'])->paginate(15);
        $paidCount = Payment::where('status', 'completed')->count();
        $inProgressCount = Payment::whereIn('status', ['pending', 'not paid'])->count();

        return view('payments.index', compact('payments', 'paidCount', 'inProgressCount'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        // Use invoice_status instead of status
        $invoices = \App\Models\Invoice::where('invoice_status', 'Pending')
            ->orWhere('invoice_status', 'Overdue')
            ->with('student.user')
            ->get();

        $students = \App\Models\Student::with('user')->get();

        return view('payments.create', compact('invoices', 'students'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => ['required', 'exists:invoices,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:open,paid,cancelled'],
            'remark' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Prevent duplicate payment for the same invoice
        $existingPayment = \App\Models\Payment::where('invoice_id', $validated['invoice_id'])->first();
        if ($existingPayment) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['invoice_id' => 'Er bestaat al een betaling voor deze factuur.']);
        }

        // Create the payment using Eloquent
        \App\Models\Payment::create([
            'invoice_id' => $validated['invoice_id'],
            'date' => $validated['date'],
            'status' => $validated['status'],
            'remark' => $validated['remark'] ?? null,
            'is_active' => $validated['is_active'] ?? 1,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load(['invoice', 'student.user']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment)
    {
        $payment->load(['invoice', 'student.user']);

        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'in:cash,bank_transfer,credit_card,ideal,paypal'],
            'payment_date' => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:completed,pending,failed,refunded'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $payment) {
            // Update payment
            $payment->update($validated);

            // Recalculate invoice status
            $invoice = $payment->invoice;

            if ($validated['status'] !== 'completed' && $invoice->status === 'paid') {
                // If payment is no longer completed, check if invoice should revert to pending
                $totalPaid = Payment::where('invoice_id', $invoice->id)
                    ->where('status', 'completed')
                    ->sum('amount');

                if ($totalPaid < $invoice->amount) {
                    $invoice->update(['status' => 'pending', 'paid_at' => null]);
                }
            } elseif ($validated['status'] === 'completed' && $invoice->status !== 'paid') {
                // If payment is now completed, check if invoice should be marked as paid
                $totalPaid = Payment::where('invoice_id', $invoice->id)
                    ->where('status', 'completed')
                    ->sum('amount');

                if ($totalPaid >= $invoice->amount) {
                    $invoice->update(['status' => 'paid', 'paid_at' => now()]);
                }
            }
        });

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        // Only allow deletion of recent payments (within 24 hours)
        $paymentTime = strtotime($payment->created_at);
        $currentTime = time();
        $hoursDiff = ($currentTime - $paymentTime) / 3600;

        if ($hoursDiff > 24) {
            return redirect()->route('payments.index')
                ->with('error', 'Cannot delete payments older than 24 hours.');
        }

        DB::transaction(function () use ($payment) {
            $invoice = $payment->invoice;

            // Delete the payment
            $payment->delete();

            // Update invoice status if needed
            if ($invoice->status === 'paid') {
                $totalPaid = Payment::where('invoice_id', $invoice->id)
                    ->where('status', 'completed')
                    ->sum('amount');

                if ($totalPaid < $invoice->amount) {
                    $invoice->update(['status' => 'pending', 'paid_at' => null]);
                }
            }
        });

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    /**
     * Process a payment (e.g., card payment).
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => ['required', 'exists:invoices,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'in:credit_card,ideal,paypal'],
        ]);

        $invoice = Invoice::with('student')->findOrFail($validated['invoice_id']);

        // In a real app, you would integrate with a payment processor here
        // For now, we'll simulate a successful payment

        // Redirect to success page
        return redirect()->route('payments.success', [
            'invoice_id' => $invoice->id,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
        ]);
    }

    /**
     * Display payment success page.
     */
    public function success(Request $request)
    {
        $invoiceId = $request->query('invoice_id');
        $amount = $request->query('amount');
        $paymentMethod = $request->query('payment_method');

        if (!$invoiceId || !$amount || !$paymentMethod) {
            return redirect()->route('invoices.index');
        }

        $invoice = Invoice::with('student.user')->findOrFail($invoiceId);

        // Create the payment record
        DB::transaction(function () use ($invoice, $amount, $paymentMethod) {
            $payment = Payment::create([
                'student_id' => $invoice->student_id,
                'invoice_id' => $invoice->id,
                'amount' => $amount,
                'payment_method' => $paymentMethod,
                'payment_date' => now(),
                'reference_number' => 'ONLINE-' . time(),
                'status' => 'completed',
            ]);

            // Update invoice status if payment covers full amount
            $totalPaid = Payment::where('invoice_id', $invoice->id)
                ->where('status', 'completed')
                ->sum('amount');

            if ($totalPaid >= $invoice->amount) {
                $invoice->update(['status' => 'paid', 'paid_at' => now()]);
            }
        });

        return view('payments.success', compact('invoice', 'amount', 'paymentMethod'));
    }

    /**
     * Display payment failed page.
     */
    public function failed(Request $request)
    {
        $invoiceId = $request->query('invoice_id');

        if (!$invoiceId) {
            return redirect()->route('invoices.index');
        }

        $invoice = Invoice::with('student.user')->findOrFail($invoiceId);

        return view('payments.failed', compact('invoice'));
    }

    /**
     * Get payments for a specific student.
     */
    public function studentPayments(Student $student)
    {
        $payments = Payment::where('student_id', $student->id)
            ->with('invoice')
            ->orderBy('payment_date', 'desc')
            ->paginate(15);

        return view('payments.student', compact('student', 'payments'));
    }

    /**
     * Display payment reports.
     */
    public function reports(Request $request)
    {
        $period = $request->query('period', 'month');
        $startDate = null;
        $endDate = null;

        switch ($period) {
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'quarter':
                $startDate = now()->startOfQuarter();
                $endDate = now()->endOfQuarter();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            case 'custom':
                $startDate = $request->query('start_date') ?
                    \Carbon\Carbon::parse($request->query('start_date')) :
                    now()->subMonth();
                $endDate = $request->query('end_date') ?
                    \Carbon\Carbon::parse($request->query('end_date')) :
                    now();
                break;
            default:
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
        }

        // Defensive: if for some reason $startDate or $endDate is still null, set to now
        if (!$startDate) $startDate = now()->startOfMonth();
        if (!$endDate) $endDate = now()->endOfMonth();

        // Get total payments
        $totalPayments = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount');

        $paymentsByMethod = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select('payment_method', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        $dailyPayments = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(DB::raw('DATE(payment_date) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('payments.reports', compact(
            'period', 'startDate', 'endDate', 'totalPayments',
            'paymentsByMethod', 'dailyPayments'
        ));
    }
}


