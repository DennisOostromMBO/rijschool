<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nieuwe Betaling
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf

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
                <label class="block font-semibold mb-2">Bedrag</label>
                <input type="number" step="0.01" name="amount" class="w-full border rounded-lg px-4 py-2 @error('amount') border-red-500 @enderror" value="{{ old('amount') }}" required>
                @error('amount')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Betaalmethode</label>
                <select name="payment_method" class="w-full border rounded-lg px-4 py-2 @error('payment_method') border-red-500 @enderror" required>
                    <option value="">Selecteer methode</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Contant</option>
                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Overschrijving</option>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Creditcard</option>
                    <option value="ideal" {{ old('payment_method') == 'ideal' ? 'selected' : '' }}>iDEAL</option>
                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                </select>
                @error('payment_method')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Betaaldatum</label>
                <input type="date" name="payment_date" class="w-full border rounded-lg px-4 py-2 @error('payment_date') border-red-500 @enderror" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                @error('payment_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Referentie</label>
                <input type="text" name="reference_number" class="w-full border rounded-lg px-4 py-2 @error('reference_number') border-red-500 @enderror" value="{{ old('reference_number') }}">
                @error('reference_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Opmerking</label>
                <textarea name="notes" class="w-full border rounded-lg px-4 py-2 @error('notes') border-red-500 @enderror" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
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
</x-layouts.app>
