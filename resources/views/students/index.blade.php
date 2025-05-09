<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leerlingen</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-7xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Overzicht Leerlingen</h1>
            <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 inline-flex items-center">
                ➕ Voeg Leerling Toe
            </a>
        </div>

        <!-- Geen gegevens beschikbaar -->
        @if (empty($students))
            <div class="text-center text-red-500 font-semibold">
                <p>Momenteel geen leerlinggegevens beschikbaar.</p>
            </div>
        @else
            <!-- Tabel voor grotere schermen -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-gray-800 text-sm font-medium">
                            <th class="py-2 px-4 border">Naam</th>
                            <th class="py-2 px-4 border">Geboortedatum</th>
                            <th class="py-2 px-4 border">Relatienummer</th>
                            <th class="py-2 px-4 border">Adres</th>
                            <th class="py-2 px-4 border">Mobiel</th>
                            <th class="py-2 px-4 border">E-mail</th>
                            <th class="py-2 px-4 border">Bewerken</th>
                            <th class="py-2 px-4 border">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border">{{ $student->full_name }}</td>
                                <td class="py-2 px-4 border">{{ $student->birth_date }}</td>
                                <td class="py-2 px-4 border">{{ $student->relation_number }}</td>
                                <td class="py-2 px-4 border">{{ $student->full_address }}</td>
                                <td class="py-2 px-4 border">{{ $student->mobile }}</td>
                                <td class="py-2 px-4 border">{{ $student->email }}</td>
                                <td class="py-2 px-4 border text-center">
                                    <button class="text-blue-500 hover:text-blue-700">✏️</button>
                                </td>
                                <td class="py-2 px-4 border text-center">
                                    <button class="text-red-500 hover:text-red-700">🗑️</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Kaartenweergave voor kleine schermen -->
            <div class="block md:hidden grid gap-4">
                @foreach ($students as $student)
                    <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-200">
                        <div class="mb-2">
                            <span class="font-semibold">Naam:</span> {{ $student->full_name }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold">Geboortedatum:</span> {{ $student->birth_date }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold">Relatienummer:</span> {{ $student->relation_number }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold">Adres:</span> {{ $student->full_address }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold">Mobiel:</span> {{ $student->mobile }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold">E-mail:</span> {{ $student->email }}
                        </div>
                        <div class="flex justify-end gap-2 mt-4">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 text-sm">Bewerken</button>
                            <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 text-sm">Verwijderen</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
