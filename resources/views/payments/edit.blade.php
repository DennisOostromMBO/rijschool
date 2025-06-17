<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Betaling Bewerken
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <form method="POST" action="{{ route('payments.update', $payment->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-2">Factuur</label>
                <input type="text" class="w-full border rounded-lg px-4 py-2 bg-gray-100" value="{{ $payment->invoice->invoice_number ?? 'Onbekend' }}" readonly>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Bedrag</label>
                <input type="number" step="0.01" class="w-full border rounded-lg px-4 py-2 bg-gray-100" value="{{ $payment->amount }}" readonly>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Betaalmethode</label>
                <select name="payment_method" class="w-full border rounded-lg px-4 py-2 @error('payment_method') border-red-500 @enderror" required>
                    <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Contant</option>
                    <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Overschrijving</option>
                    <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Creditcard</option>
                    <option value="ideal" {{ old('payment_method', $payment->payment_method) == 'ideal' ? 'selected' : '' }}>iDEAL</option>
                    <option value="paypal" {{ old('payment_method', $payment->payment_method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                </select>
                @error('payment_method')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Betaaldatum</label>
                <input type="date" name="payment_date" class="w-full border rounded-lg px-4 py-2 @error('payment_date') border-red-500 @enderror" value="{{ old('payment_date', $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '') }}" required>
                @error('payment_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Referentie</label>
                <input type="text" name="reference_number" class="w-full border rounded-lg px-4 py-2 @error('reference_number') border-red-500 @enderror" value="{{ old('reference_number', $payment->reference_number) }}">
                @error('reference_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Status</label>
                <select name="status" class="w-full border rounded-lg px-4 py-2 @error('status') border-red-500 @enderror" required>
                    <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>Betaald</option>
                    <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>In Behandeling</option>
                    <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Mislukt</option>
                    <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>Terugbetaald</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Opmerking</label>
                <textarea name="notes" class="w-full border rounded-lg px-4 py-2 @error('notes') border-red-500 @enderror" rows="3">{{ old('notes', $payment->notes) }}</textarea>
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
