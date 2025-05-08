<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Student;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// Import the PDF facade from Laravel DomPDF
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['student.user']);

        // Apply filters if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $invoices = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $students = Student::with('user')->get();
        return view('invoices.create', compact('students'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'description' => ['required', 'string'],
            'registration_id' => ['nullable', 'exists:registrations,id'],
            'notes' => ['nullable', 'string'],
        ]);

        // Generate invoice number
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(($lastInvoice ? ($lastInvoice->id + 1) : 1), 4, '0', STR_PAD_LEFT);

        // Create the invoice
        $invoice = Invoice::create([
            'student_id' => $validated['student_id'],
            'invoice_number' => $invoiceNumber,
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'status' => 'pending',
            'description' => $validated['description'],
            'registration_id' => $validated['registration_id'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['student.user', 'registration.package']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        $students = Student::with('user')->get();
        $registrations = $invoice->student_id ?
            Registration::where('student_id', $invoice->student_id)->with('package')->get() :
            collect();

        return view('invoices.edit', compact('invoice', 'students', 'registrations'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,paid,cancelled,overdue'],
            'description' => ['required', 'string'],
            'registration_id' => ['nullable', 'exists:registrations,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // Only allow deletion of pending invoices
        if ($invoice->status !== 'pending') {
            return redirect()->route('invoices.index')
                ->with('error', 'Cannot delete invoices that are not in pending status.');
        }

        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Send the invoice to the student.
     */
    public function send(Invoice $invoice)
    {
        // In a real app, you would send an email with the invoice PDF
        // For now, just mark it as sent

        $invoice->update([
            'sent_at' => now(),
            'status' => $invoice->status === 'draft' ? 'pending' : $invoice->status,
        ]);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice sent to student successfully.');
    }

    /**
     * Download the invoice as PDF.
     */
    public function download(Invoice $invoice)
    {
        $invoice->load(['student.user', 'registration.package']);

        // In a real app, you would generate a PDF file
        // For now, we'll simulate this with a view

        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Get invoices for a specific student.
     */
    public function studentInvoices(Student $student)
    {
        $invoices = Invoice::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('invoices.student', compact('student', 'invoices'));
    }

    /**
     * Get all unpaid invoices.
     */
    public function unpaid()
    {
        $invoices = Invoice::where('status', 'pending')
            ->orWhere('status', 'overdue')
            ->with('student.user')
            ->orderBy('due_date')
            ->paginate(15);

        return view('invoices.unpaid', compact('invoices'));
    }
}
