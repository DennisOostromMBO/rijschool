<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Factuur Bewerken
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Factuurnummer</label>
                    <input type="text" name="invoice_number" class="w-full border rounded-lg px-4 py-2 @error('invoice_number') border-red-500 @enderror" value="{{ old('invoice_number', $invoice->invoice_number) }}" required readonly>
                    @error('invoice_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Factuurdatum</label>
                    <input type="date" name="invoice_date" class="w-full border rounded-lg px-4 py-2 @error('invoice_date') border-red-500 @enderror" value="{{ old('invoice_date', $invoice->invoice_date) }}" required>
                    @error('invoice_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Student/Inschrijving</label>
                    @php
                        // Support both stdClass (from SP) and Eloquent model
                        $regId = isset($invoice->registration_id) ? $invoice->registration_id : (isset($invoice->registration_ID) ? $invoice->registration_ID : null);
                        $selectedRegistration = $registrations->first(function($reg) use ($regId) {
                            return (string)$reg->id === (string)$regId;
                        });
                        $studentName = $selectedRegistration && $selectedRegistration->student && $selectedRegistration->student->user
                            ? $selectedRegistration->student->user->full_name
                            : 'Onbekend';
                    @endphp
                    <input type="text" class="w-full border rounded-lg px-4 py-2 bg-gray-100" value="{{ $studentName }}" readonly>
                    <input type="hidden" name="registration_id" value="{{ old('registration_id', $regId) }}">
                    @error('registration_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Status</label>
                    <select name="invoice_status" class="w-full border rounded-lg px-4 py-2 @error('invoice_status') border-red-500 @enderror" required>
                        <option value="Pending" {{ old('invoice_status', $invoice->invoice_status) == 'Pending' ? 'selected' : '' }}>In Behandeling</option>
                        <option value="Paid" {{ old('invoice_status', $invoice->invoice_status) == 'Paid' ? 'selected' : '' }}>Betaald</option>
                        <option value="Overdue" {{ old('invoice_status', $invoice->invoice_status) == 'Overdue' ? 'selected' : '' }}>Te Laat</option>
                    </select>
                    @error('invoice_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Bedrag excl. BTW</label>
                    <input type="number" step="0.01" name="amount_excl_vat" class="w-full border rounded-lg px-4 py-2 @error('amount_excl_vat') border-red-500 @enderror" value="{{ old('amount_excl_vat', $invoice->amount_excl_vat) }}" required>
                    @error('amount_excl_vat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">BTW (%)</label>
                    <input type="number" name="vat" class="w-full border rounded-lg px-4 py-2 bg-gray-100 @error('vat') border-red-500 @enderror" value="{{ old('vat', $invoice->vat) }}" required>
                    @error('vat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Bedrag incl. BTW</label>
                    <input type="number" step="0.01" name="amount_incl_vat" class="w-full border rounded-lg px-4 py-2 bg-gray-100 @error('amount_incl_vat') border-red-500 @enderror" value="{{ old('amount_incl_vat', $invoice->amount_incl_vat) }}" required>
                    @error('amount_incl_vat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Opmerking</label>
                <textarea name="remark" class="w-full border rounded-lg px-4 py-2 @error('remark') border-red-500 @enderror" rows="3" placeholder="Opmerking (optioneel)">{{ old('remark', isset($invoice->remark) ? $invoice->remark : '') }}</textarea>
                @error('remark')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('invoices.index') }}" class="bg-white border border-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                    Annuleer
                </a>
                <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-gray-900 transition">
                    Factuur Opslaan
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
