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
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">INV-</span>
                        <input type="text" name="invoice_number" id="invoice_number" class="w-full border rounded-r-lg px-4 py-2" placeholder="Bijv. 00123" value="{{ old('invoice_number') ? ltrim(strtoupper(old('invoice_number')), 'INV-') : '' }}" required>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Factuurdatum</label>
                    <input type="text" name="invoice_date" id="invoice_date" class="w-full border rounded-lg px-4 py-2" placeholder="dd/mm/jjjj" value="{{ old('invoice_date') ? \Carbon\Carbon::parse(old('invoice_date'))->format('d/m/Y') : '' }}" required maxlength="10" autocomplete="off">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Student</label>
                    <select name="registration_id" id="registration_id" class="w-full border rounded-lg px-4 py-2" required>
                        <option value="">Selecteer student</option>
                        @foreach($registrations as $registration)
                            <option value="{{ $registration->id }}"
                                data-student="{{ $registration->student && $registration->student->user ? $registration->student->user->full_name : 'Onbekend' }}"
                                {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                                {{ $registration->student && $registration->student->user ? $registration->student->user->full_name : 'Onbekend' }}
                            </option>
                        @endforeach
                    </select>
                    <div id="student_name_display" class="mt-2 text-gray-600 hidden"></div>
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

            // Student name display logic
            function showStudentName() {
                var select = document.getElementById('registration_id');
                var selected = select.options[select.selectedIndex];
                var name = selected.getAttribute('data-student') || '';
                var display = document.getElementById('student_name_display');
                if (name && select.value) {
                    display.textContent = 'Geselecteerde student: ' + name;
                    display.classList.remove('hidden');
                } else {
                    display.textContent = '';
                    display.classList.add('hidden');
                }
            }
            document.getElementById('registration_id').addEventListener('change', showStudentName);
            // Initial display on page load
            showStudentName();

            // Ensure invoice_number is prefixed with INV- on submit
            document.querySelector('form').addEventListener('submit', function(e) {
                var input = document.getElementById('invoice_number');
                if (input.value && !input.value.toUpperCase().startsWith('INV-')) {
                    input.value = 'INV-' + input.value.replace(/^INV-/i, '');
                }
            });
        });

        // Date input mask and correction for dd/mm/yyyy
        document.addEventListener('DOMContentLoaded', function () {
            // Mask for dd/mm/yyyy
            var dateInput = document.getElementById('invoice_date');
            dateInput.addEventListener('input', function(e) {
                let v = dateInput.value.replace(/\D/g, '').slice(0,8);

                // Day
                let day = v.slice(0,2);
                if (v.length >= 1) {
                    if (parseInt(v[0]) > 3) {
                        // If first digit > 3, auto-correct to 0X
                        day = '0' + v[0];
                        v = '0' + v;
                    } else if (v.length === 1) {
                        // Wait for second digit
                        dateInput.value = v;
                        return;
                    }
                }
                if (v.length >= 2) {
                    day = v.slice(0,2);
                    if (parseInt(day) === 0 || parseInt(day) > 31) {
                        day = '01';
                    }
                }

                // Month
                let month = '';
                if (v.length >= 3) {
                    month = v.slice(2,4);
                    if (parseInt(v[2]) > 1) {
                        // If first digit of month > 1, auto-correct to 0X
                        month = '0' + v[2];
                        v = v.slice(0,2) + '0' + v.slice(2);
                    } else if (v.length === 3) {
                        // Wait for second digit
                        dateInput.value = day + '/' + v[2];
                        return;
                    }
                }
                if (v.length >= 4) {
                    month = v.slice(2,4);
                    if (parseInt(month) === 0 || parseInt(month) > 12) {
                        month = '01';
                    }
                }

                // Year
                let year = '';
                if (v.length > 4) {
                    year = v.slice(4,8);
                }

                let result = day;
                if (month) result += '/' + month;
                if (year) result += '/' + year;
                dateInput.value = result;
            });

            // On form submit, convert dd/mm/yyyy to yyyy-mm-dd
            document.querySelector('form').addEventListener('submit', function(e) {
                var dateInput = document.getElementById('invoice_date');
                if (dateInput.value.match(/^\d{2}\/\d{2}\/\d{4}$/)) {
                    var parts = dateInput.value.split('/');
                    dateInput.value = parts[2] + '-' + parts[1] + '-' + parts[0];
                }
            });
        });
    </script>
</x-layouts.app>
