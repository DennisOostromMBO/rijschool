@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Nieuwe Instructeur Toevoegen</h1>
    </div>

    <form class="space-y-6">
        <!-- Persoonlijke informatie -->
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Persoonlijke Informatie</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voornaam</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tussenvoegsel</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Achternaam</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Geboortedatum</label>
                <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
        </div>

        <!-- Adresgegevens -->
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Adresgegevens</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Straatnaam</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Huisnummer</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toevoeging</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postcode</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stad</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
            </div>
        </div>

        <!-- Contactgegevens -->
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Contactgegevens</h2>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mailadres</label>
                <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('instructors.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Annuleren</a>
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Toevoegen</button>
        </div>
    </form>
</div>
@endsection
