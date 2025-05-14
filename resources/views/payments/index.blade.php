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
