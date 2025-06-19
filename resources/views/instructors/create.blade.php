@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-8">
    <div class="space-y-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Nieuwe Instructeur Toevoegen</h1>
        
        @if(session('error'))
            <div class="bg-red-100 p-4 rounded-lg text-red-700" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @error('email')
            <div class="bg-red-100 p-4 rounded-lg text-red-700" role="alert">
                {{ $message }}
            </div>
        @enderror
    </div>

    <form method="POST" action="{{ route('instructors.store') }}" class="space-y-6">
        @csrf
        <!-- Persoonlijke informatie -->
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Persoonlijke Informatie</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex flex-col h-[85px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voornaam</label>
                    <div class="mt-1">
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                            class="block w-full rounded-md @error('first_name') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col h-[85px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tussenvoegsel</label>
                    <div class="mt-1">
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                            class="block w-full rounded-md @error('middle_name') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    @error('middle_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col h-[85px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Achternaam</label>
                    <div class="mt-1">
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                            class="block w-full rounded-md @error('last_name') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col h-[85px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Geboortedatum</label>
                <div class="mt-1">
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                        class="block w-full rounded-md @error('birth_date') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                @error('birth_date')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Adresgegevens -->
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Adresgegevens</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2 flex flex-col h-[85px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Straatnaam</label>
                    <div class="mt-1">
                        <input type="text" name="street_name" value="{{ old('street_name') }}" required
                            class="block w-full rounded-md @error('street_name') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    @error('street_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col h-[85px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Huisnummer</label>
                    <div class="mt-1">
                        <input type="text" name="house_number" value="{{ old('house_number') }}" required
                            class="block w-full rounded-md @error('house_number') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    @error('house_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col h-[85px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toevoeging</label>
                    <div class="mt-1">
                        <input type="text" name="addition" value="{{ old('addition') }}"
                            class="block w-full rounded-md @error('addition') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    @error('addition')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col h-[85px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postcode</label>
                    <div class="mt-1">
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                            class="block w-full rounded-md @error('postal_code') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col h-[85px]">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stad</label>
                    <div class="mt-1">
                        <input type="text" name="city" value="{{ old('city') }}" required
                            class="block w-full rounded-md @error('city') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    @error('city')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contactgegevens -->
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Contactgegevens</h2>
            
            <div class="flex flex-col h-[85px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mailadres</label>
                <div class="mt-1">
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="block w-full rounded-md @error('email') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('instructors.index') }}" 
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                Annuleren
            </a>
            <button type="submit" 
                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                Toevoegen
            </button>
        </div>
    </form>
</div>
@endsection
