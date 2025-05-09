<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Factuur Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Factuur Details</h1>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-4">Factuur Informatie</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Factuurnummer</dt>
                    <dd class="text-sm text-gray-800 dark:text-gray-200">{{ $invoice->invoice_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Datum</dt>
                    <dd class="text-sm text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="text-sm text-gray-800 dark:text-gray-200">{{ ucfirst($invoice->invoice_status) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bedrag (incl. BTW)</dt>
                    <dd class="text-sm text-gray-800 dark:text-gray-200">€{{ number_format($invoice->amount_incl_vat, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Student</dt>
                    <dd class="text-sm text-gray-800 dark:text-gray-200">{{ $invoice->student_name ?? 'Onbekend' }}</dd>
                </div>
            </dl>
        </div>

        <div class="mt-6">
            <a href="{{ route('invoices.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow">
                Terug naar overzicht
            </a>
        </div>
    </div>
</x-layouts.app>