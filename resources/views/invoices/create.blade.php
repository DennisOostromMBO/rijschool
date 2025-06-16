<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nieuwe Factuur
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <form method="POST" action="{{ route('invoices.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Factuurnummer</label>
                    <input type="text" name="invoice_number" class="w-full border rounded-lg px-4 py-2" placeholder="Specificeer factuurnummer" value="{{ old('invoice_number') }}" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Factuurdatum</label>
                    <input type="date" name="invoice_date" class="w-full border rounded-lg px-4 py-2" value="{{ old('invoice_date') }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Student</label>
                    <select name="registration_id" class="w-full border rounded-lg px-4 py-2" required>
                        <option value="">Selecteer student</option>
                        @foreach(\App\Models\Registration::with('student.user')->get() as $registration)
                            <option value="{{ $registration->id }}" {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                                {{ $registration->student->user->name ?? 'Onbekend' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Status</label>
                    <select name="invoice_status" class="w-full border rounded-lg px-4 py-2" required>
                        <option value="Pending" {{ old('invoice_status') == 'Pending' ? 'selected' : '' }}>In Behandeling</option>
                        <option value="Paid" {{ old('invoice_status') == 'Paid' ? 'selected' : '' }}>Betaald</option>
                        <option value="Overdue" {{ old('invoice_status') == 'Overdue' ? 'selected' : '' }}>Te Laat</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Bedrag excl. BTW</label>
                    <input type="number" step="0.01" name="amount_excl_vat" id="amount_excl_vat" class="w-full border rounded-lg px-4 py-2" value="{{ old('amount_excl_vat') }}" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">BTW (%)</label>
                    <input type="number" name="vat" id="vat" class="w-full border rounded-lg px-4 py-2 bg-gray-100" value="21" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Bedrag incl. BTW</label>
                    <input type="number" step="0.01" name="amount_incl_vat" id="amount_incl_vat" class="w-full border rounded-lg px-4 py-2 bg-gray-100" value="{{ old('amount_incl_vat') }}" readonly required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Opmerking</label>
                <textarea name="remark" class="w-full border rounded-lg px-4 py-2" rows="3" placeholder="Opmerking (optioneel)">{{ old('remark') }}</textarea>
            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('invoices.index') }}" class="bg-white border border-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                    Annuleer
                </a>
                <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-gray-900 transition">
                    Factuur Aanmaken
                </button>
            </div>
        </form>
    </div>

    <script>
        // Calculate amount incl. VAT automatically
        document.addEventListener('DOMContentLoaded', function () {
            function calculateInclVat() {
                const excl = parseFloat(document.getElementById('amount_excl_vat').value) || 0;
                const vat = parseFloat(document.getElementById('vat').value) || 0;
                const incl = excl + (excl * vat / 100);
                document.getElementById('amount_incl_vat').value = incl.toFixed(2);
            }
            document.getElementById('amount_excl_vat').addEventListener('input', calculateInclVat);
            // Initial calculation
            calculateInclVat();
        });
    </script>
</x-layouts.app>
