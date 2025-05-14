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

        <div class="overflow-hidden shadow rounded-lg">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Betalingsnummer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Betaler</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Betalingsdatum</th>
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
                                {{ $payment->payment_number }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ $payment->payer_name ?? 'Onbekend' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ $payment->invoice_id }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($payment->invoice_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $payment->payment_status === 'Completed' ? 'bg-green-100 text-green-800' : ($payment->payment_status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                €{{ number_format($payment->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Geen betalingen gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
