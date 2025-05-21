@extends('layouts.app')

@section('title', 'Nieuw Account Aanmaken')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden">
        <!-- Header met titel -->
        <div class="bg-blue-600 dark:bg-blue-800 text-white p-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Nieuw Account Aanmaken</h1>
            <a href="{{ route('accounts.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Terug naar overzicht
            </a>
        </div>

        <!-- Form -->
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                    <p class="font-bold">Er zijn fouten gevonden:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('accounts.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Persoonlijke Informatie -->
                    <div class="bg-gray-50 dark:bg-slate-700 p-5 rounded-lg space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2">Persoonlijke Informatie</h2>

                        <!-- Voornaam -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Voornaam</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                class="w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>

                        <!-- Achternaam -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Achternaam</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                class="w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-mailadres</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>

                        <!-- Telefoon -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefoonnummer</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>
                    </div>

                    <!-- Account Informatie -->
                    <div class="bg-gray-50 dark:bg-slate-700 p-5 rounded-lg space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2">Account Informatie</h2>

                        <!-- Gebruikersnaam -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gebruikersnaam</label>
                            <input type="text" name="username" id="username" value="{{ old('username') }}"
                                class="w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>

                        <!-- Rollen -->
                        <div>
                            <label for="roles" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rollen</label>
                            <div class="space-y-2">
                                @foreach($roles as $role)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="roles[]" id="role-{{ $role->id }}" value="{{ $role->id }}"
                                            class="rounded border-gray-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500"
                                            {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                        <label for="role-{{ $role->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Wachtwoord -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Wachtwoord</label>
                            <input type="password" name="password" id="password"
                                class="w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>

                        <!-- Wachtwoord bevestiging -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bevestig wachtwoord</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>
                    </div>
                </div>

                <!-- Acties -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('accounts.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 dark:bg-slate-600 dark:hover:bg-slate-700 text-gray-800 dark:text-white rounded-md text-sm font-medium transition">
                        Annuleren
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition">
                        Account aanmaken
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
