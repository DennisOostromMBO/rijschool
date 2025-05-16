<?php
// Empty file - will contain invoice management functionality
?>


<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Factuur Overzicht') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Factuur Overzicht</h1>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                <h5 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Totaal deze maand</h5>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">€{{ number_format($invoices->where('invoice_status', 'Paid')->sum('amount_incl_vat'), 2) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                <h5 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Openstaand</h5>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">€{{ number_format($invoices->where('invoice_status', 'Pending')->sum('amount_incl_vat'), 2) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                <h5 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Betaald</h5>
                @php
                    $paidInvoices = $invoices->filter(function ($invoice) {
                        return $invoice->invoice_status === 'Paid';
                    });

                    $totalPaid = $paidInvoices->sum('amount_incl_vat');
                @endphp

                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    €{{ number_format($totalPaid, 2) }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                <h5 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Facturen</h5>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $invoices->count() }}</p>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('invoices.index') }}" class="mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Search by Student Name -->
                <div>
                    <label for="student_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student Naam</label>
                    <input type="text" name="student_name" id="student_name" value="{{ request('student_name') }}" placeholder="Zoek op student" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <!-- Search by Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Alle</option>
                        <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Betaald</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>In Behandeling</option>
                        <option value="Overdue" {{ request('status') == 'Overdue' ? 'selected' : '' }}>Te Laat</option>
                    </select>
                </div>

                <!-- Search by Invoice Number -->
                <div>
                    <label for="factuurnummer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Factuurnummer</label>
                    <input type="text" name="factuurnummer" id="factuurnummer" value="{{ request('factuurnummer') }}" placeholder="Zoek op factuurnummer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow">
                    Zoeken
                </button>
                <a href="{{ route('invoices.index') }}" class="ml-4 text-gray-500 hover:underline">Reset</a>
            </div>
        </form>

        <!-- Recent Invoices Table (desktop only) -->
        <div class="overflow-hidden shadow rounded-lg hidden sm:block mb-6">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Factuurnummer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Datum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bedrag</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ $invoice->invoice_number }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ $invoice->student_name ?? 'Onbekend' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $invoice->invoice_status === 'Paid' ? 'bg-green-100 text-green-800' : ($invoice->invoice_status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($invoice->invoice_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                €{{ number_format($invoice->amount_incl_vat, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="text-blue-500 hover:underline">Bekijken</a>
                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="text-yellow-500 hover:underline ml-4">Bewerken</a>
                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-4" onclick="return confirm('Weet je zeker dat je deze factuur wilt verwijderen?')">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Geen facturen gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (desktop only) -->
        <div class="mt-6 hidden sm:block">
            {{ $invoices->links('pagination::tailwind') }}
        </div>

        {{-- Mobile version, only visible on small screens --}}
        <div class="block sm:hidden px-2 py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Factuur Overzicht</h1>
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 flex flex-col items-center">
                    <span class="text-gray-500 text-sm">Totaal deze maand</span>
                    <span class="text-xl font-bold text-gray-900 dark:text-gray-100">€{{ number_format($invoices->where('invoice_status', 'Paid')->sum('amount_incl_vat'), 2) }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 flex flex-col items-center">
                    <span class="text-gray-500 text-sm">Openstaand</span>
                    <span class="text-xl font-bold text-gray-900 dark:text-gray-100">€{{ number_format($invoices->where('invoice_status', 'Pending')->sum('amount_incl_vat'), 2) }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 flex flex-col items-center">
                    <span class="text-gray-500 text-sm">Facturen</span>
                    <span class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $invoices->total() }}</span>
                </div>
                <a href="{{ route('invoices.create') }}" class="bg-black text-white rounded-xl p-4 flex items-center justify-center font-semibold hover:bg-gray-900 transition">
                    Nieuwe Factuur
                </a>
            </div>

            <div class="flex items-center mb-2">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex-1">Recente Facturen</h2>
                <form method="GET" action="{{ route('invoices.index') }}" class="flex-1 flex justify-end">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Zoeken..." class="w-full max-w-xs rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                </form>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @forelse($invoices as $invoice)
                    <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 flex flex-col items-center shadow">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-2
                            {{ $invoice->invoice_status === 'Paid' ? 'bg-green-100 text-green-800' : ($invoice->invoice_status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($invoice->invoice_status) }}
                        </span>
                        <div class="text-xs text-gray-500">Factuurnummer</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $invoice->invoice_number }}</div>
                        <div class="text-xs text-gray-500">Student</div>
                        <div class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $invoice->student_name ?? 'Onbekend' }}</div>
                        <div class="text-xs text-gray-500">Datum</div>
                        <div class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-500">Bedrag</div>
                        <div class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">€{{ number_format($invoice->amount_incl_vat, 2) }}</div>
                        <div class="flex gap-3 mt-2">
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="text-blue-500 hover:underline text-sm font-semibold">Bekijken</a>
                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="text-yellow-500 hover:underline text-sm font-semibold">Bewerken</a>
                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-sm font-semibold" onclick="return confirm('Weet je zeker dat je deze factuur wilt verwijderen?')">Verwijderen</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-4">Geen facturen gevonden.</div>
                @endforelse
            </div>

            <div class="text-sm text-gray-500 mt-4">
                Toont {{ $invoices->count() }} van {{ $invoices->total() }} facturen
            </div>
            <div class="mt-2">
                {{ $invoices->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-layouts.app>
