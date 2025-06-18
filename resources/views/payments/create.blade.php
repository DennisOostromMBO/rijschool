@extends('layouts.app')

@section('title', 'Nieuwe Betaling')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
            Nieuwe Betaling
        </h2>
        @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf

            <input type="hidden" name="is_active" value="1" />

            <div class="mb-4">
                <label class="block font-semibold mb-2">Factuur</label>
                <select name="invoice_id" class="w-full border rounded-lg px-4 py-2 @error('invoice_id') border-red-500 @enderror" required>
                    <option value="">Selecteer factuur</option>
                    @foreach($invoices as $invoice)
                        <option value="{{ $invoice->id }}" {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>
                            {{ $invoice->invoice_number }} - {{ $invoice->student->user->full_name ?? 'Onbekend' }} (€{{ number_format($invoice->amount_incl_vat, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('invoice_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Status</label>
                <select name="status" class="w-full border rounded-lg px-4 py-2 @error('status') border-red-500 @enderror" required>
                    <option value="">Selecteer status</option>
                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Betaald</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Betaaldatum</label>
                <input type="date" name="date" class="w-full border rounded-lg px-4 py-2 @error('date') border-red-500 @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Opmerking</label>
                <textarea name="remark" class="w-full border rounded-lg px-4 py-2 @error('remark') border-red-500 @enderror" rows="3">{{ old('remark') }}</textarea>
                @error('remark')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('payments.index') }}" class="bg-white border border-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                    Annuleer
                </a>
                <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-gray-900 transition">
                    Betaling Opslaan
                </button>
            </div>
        </form>
    </div>
@endsection

