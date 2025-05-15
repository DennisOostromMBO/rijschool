<?php
// Empty file - will contain payment processing and history functionality
?>

{{-- filepath: c:\Users\danie\OneDrive\Documenten\school mappen\Leerjaar 2\Project\Periode 4\rijschool\resources\views\payments\index.blade.php --}}
<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Betalingen Overzicht') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Betalingen Overzicht</h1>

        <!-- Summary Section -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Betaald</h2>
                <p class="text-2xl font-bold text-green-600">{{ $paidCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">In Behandeling / Niet Betaald</h2>
                <p class="text-2xl font-bold text-yellow-600">{{ $inProgressCount }}</p>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('payments.index') }}" class="mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Search by Payer Name -->
                <div>
                    <label for="payer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Betaler Naam</label>
                    <input type="text" name="payer_name" id="payer_name" value="{{ request('payer_name') }}" placeholder="Zoek op betaler" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <!-- Search by Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Alle</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Betaald</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>In Behandeling</option>
                        <option value="Failed" {{ request('status') == 'Failed' ? 'selected' : '' }}>Mislukt</option>
                    </select>
                </div>

                <!-- Search by Invoice Number -->
                <div>
                    <label for="invoice_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Factuurnummer</label>
                    <input type="text" name="invoice_number" id="invoice_number" value="{{ request('invoice_number') }}" placeholder="Zoek op factuurnummer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow">
                    Zoeken
                </button>
                <a href="{{ route('payments.index') }}" class="ml-4 text-gray-500 hover:underline">Reset</a>
            </div>
        </form>

        <!-- Payments Table -->
        <div class="overflow-hidden shadow rounded-lg">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Betaler</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Factuurnummer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Factuurdatum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bedrag</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($payments as $payment)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ $payment->invoice->registration->student->user->full_name ?? 'Onbekend' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ $payment->invoice->invoice_number ?? 'Onbekend' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ $payment->invoice->invoice_date ? \Carbon\Carbon::parse($payment->invoice->invoice_date)->format('d M Y') : 'Onbekend' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $payment->status === 'Completed' ? 'bg-green-100 text-green-800' : ($payment->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($payment->status ?? 'Onbekend') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                €{{ number_format($payment->invoice->amount_incl_vat ?? 0, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Geen betalingen gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $payments->links('pagination::tailwind') }}
        </div>
    </div>
</x-layouts.app>
