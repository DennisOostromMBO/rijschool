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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index(Request $request)
    {
        // Retrieve search inputs
        $searchStudent = $request->input('student_name');
        $searchStatus = $request->input('status');
        $searchInvoiceNumber = $request->input('factuurnummer');

        // Call the stored procedure via the model
        $invoices = collect(Invoice::getInvoicesFromSP());

        // Filter the collection based on search inputs
        if ($searchStudent) {
            $invoices = $invoices->filter(function ($invoice) use ($searchStudent) {
                return stripos($invoice->student_name, $searchStudent) !== false;
            });
        }

        if ($searchStatus) {
            $invoices = $invoices->filter(function ($invoice) use ($searchStatus) {
                return stripos($invoice->invoice_status, $searchStatus) !== false;
            });
        }

        if ($searchInvoiceNumber) {
            $invoices = $invoices->filter(function ($invoice) use ($searchInvoiceNumber) {
                return stripos($invoice->invoice_number, $searchInvoiceNumber) !== false;
            });
        }

        // Manually paginate the collection
        $currentPage = $request->get('page', 1);
        $perPage = 10;
        $paginatedInvoices = new LengthAwarePaginator(
            $invoices->forPage($currentPage, $perPage),
            $invoices->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('invoices.index', ['invoices' => $paginatedInvoices]);
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $registrations = \App\Models\Registration::with('student.user')->get();
        return view('invoices.create', compact('registrations'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => ['required', 'exists:registrations,id'],
            'invoice_number' => ['required', 'string', 'max:255'],
            'invoice_date' => ['required', 'date'],
            'amount_excl_vat' => ['required', 'numeric', 'min:0'],
            'vat' => ['required', 'numeric', 'min:0'],
            'amount_incl_vat' => ['required', 'numeric', 'min:0'],
            'invoice_status' => ['required', 'in:Pending,Paid,Overdue'],
            'remark' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = 1;

        \App\Models\Invoice::createInvoiceWithSP($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show($id)
    {
        // Call the stored procedure and filter the result for the specific invoice
        $invoices = collect(Invoice::getInvoicesFromSP());
        $invoice = $invoices->firstWhere('id', $id);

        if (!$invoice) {
            abort(404, 'Factuur niet gevonden.');
        }

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
