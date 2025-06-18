@extends('layouts.app')

<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Betalingen Overzicht') }}
        </h2>
    </x-slot>
@section('title', 'Betalingen Overzicht')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Betalingen Overzicht') }}
            </h2>
        </x-slot>

        {{-- Desktop versie --}}
        <div class="hidden sm:block">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Betalingen Overzicht</h1>

            <!-- Add button for creating a new payment -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('payments.create') }}" class="bg-black text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-gray-900 transition">
                    Nieuwe Betaling
                </a>
            </div>

            <!-- Statistiek-kaarten -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <h5 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Betaald</h5>
                    <p class="text-2xl font-bold text-green-600">{{ $paidCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <h5 class="text-lg font-semibold text-gray-600 dark:text-gray-400">In Behandeling / Niet Betaald</h5>
                    <p class="text-2xl font-bold text-yellow-600">{{ $inProgressCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <h5 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Totaal betalingen</h5>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $payments->total() }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <h5 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Totaal bedrag</h5>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        €{{ number_format($payments->sum(fn($p) => $p->invoice->amount_incl_vat ?? 0), 2) }}
                    </p>
                </div>
            </div>

            <!-- Zoekformulier -->
            <form method="GET" action="{{ route('payments.index') }}" class="mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="payer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Betaler Naam</label>
                        <input type="text" name="payer_name" id="payer_name" value="{{ request('payer_name') }}" placeholder="Zoek op betaler" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Alle</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Betaald</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>In Behandeling</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Mislukt</option>
                        </select>
                    </div>
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

            <!-- Tabel met betalingen -->
            <div class="overflow-hidden shadow rounded-lg">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Betaler</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Factuurnummer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Factuurdatum</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bedrag</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acties</th>
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
                                        {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($payment->status ?? 'Onbekend') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                    €{{ number_format($payment->invoice->amount_incl_vat ?? 0, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                    <div class="relative inline-block text-left">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1 bg-white dark:bg-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 focus:outline-none" id="menu-button-{{ $payment->id }}" aria-expanded="true" aria-haspopup="true" onclick="document.getElementById('dropdown-{{ $payment->id }}').classList.toggle('hidden')">
                                            Acties
                                            <svg class="-mr-1 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l3-3 3 3m0 6l-3 3-3-3"/>
                                            </svg>
                                        </button>
                                        <div id="dropdown-{{ $payment->id }}" class="origin-top-right absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 hidden z-10">
                                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="menu-button-{{ $payment->id }}">
                                                <a href="{{ route('payments.edit', $payment->id) }}" class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600" role="menuitem">
                                                    Update
                                                </a>
                                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze betaling wilt verwijderen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600" role="menuitem">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        // Close dropdowns when clicking outside
                                        document.addEventListener('click', function(event) {
                                            var dropdown = document.getElementById('dropdown-{{ $payment->id }}');
                                            var button = document.getElementById('menu-button-{{ $payment->id }}');
                                            if (dropdown && !dropdown.contains(event.target) && !button.contains(event.target)) {
                                                dropdown.classList.add('hidden');
                                            }
                                        });
                                    </script>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Geen betalingen gevonden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginatie -->
            <div class="mt-6">
                {{ $payments->links('pagination::tailwind') }}
            </div>
        </div>

        {{-- Mobiele versie --}}
        <div class="block sm:hidden px-2 py-4 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ showFilter: false }">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Betalingen Overzicht</h1>
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 flex flex-col items-center">
                    <span class="text-gray-500 text-sm">Betaald</span>
                    <span class="text-xl font-bold text-green-600">{{ $paidCount }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 flex flex-col items-center">
                    <span class="text-gray-500 text-sm">In Behandeling / Niet Betaald</span>
                    <span class="text-xl font-bold text-yellow-600">{{ $inProgressCount }}</span>
                </div>
            </div>

            <div class="flex items-center mb-2">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex-1">Recente Betalingen</h2>
                <button @click="showFilter = true" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-blue-600 transition">
                    Filter
                </button>
            </div>

            <!-- Filter Modal -->
            <div x-show="showFilter" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-11/12 max-w-sm relative">
                    <button @click="showFilter = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-2xl">&times;</button>
                    <form method="GET" action="{{ route('payments.index') }}">
                        <div class="mb-4">
                            <label for="payer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Betaler Naam</label>
                            <input type="text" name="payer_name" id="payer_name" value="{{ request('payer_name') }}" placeholder="Zoek op betaler" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Alle</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Betaald</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>In Behandeling</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Mislukt</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="invoice_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Factuurnummer</label>
                            <input type="text" name="invoice_number" id="invoice_number" value="{{ request('invoice_number') }}" placeholder="Zoek op factuurnummer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payment Cubes -->
            <div class="grid grid-cols-1 gap-4">
                @forelse($payments as $payment)
                    <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 flex flex-col items-center shadow">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-2
                            {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($payment->status ?? 'Onbekend') }}
                        </span>
                        <div class="text-xs text-gray-500">Betaler</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $payment->invoice->registration->student->user->full_name ?? 'Onbekend' }}
                        </div>
                        <div class="text-xs text-gray-500">Factuurnummer</div>
                        <div class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            {{ $payment->invoice->invoice_number ?? 'Onbekend' }}
                        </div>
                        <div class="text-xs text-gray-500">Factuurdatum</div>
                        <div class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            {{ $payment->invoice->invoice_date ? \Carbon\Carbon::parse($payment->invoice->invoice_date)->format('d M Y') : 'Onbekend' }}
                        </div>
                        <div class="text-xs text-gray-500">Bedrag</div>
                        <div class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            €{{ number_format($payment->invoice->amount_incl_vat ?? 0, 2) }}
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-4">Geen betalingen gevonden.</div>
                @endforelse
            </div>

            <div class="text-sm text-gray-500 mt-4">
                Toont {{ $payments->count() }} van {{ $payments->total() }} betalingen
            </div>
            <div class="mt-2">
                {{ $payments->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
