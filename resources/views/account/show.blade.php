@extends('layouts.app')

@section('title', 'Account Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden">
        <!-- Header met titel -->
        <div class="bg-blue-600 dark:bg-blue-800 text-white p-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Account Details</h1>
            <a href="{{ route('accounts.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Terug naar overzicht
            </a>
        </div>

        <!-- User details -->
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Linker kolom - Persoonlijke informatie -->
                <div class="flex-1 bg-gray-50 dark:bg-slate-700 p-5 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">Persoonlijke Informatie</h2>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Volledige naam</p>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Gebruikersnaam</p>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $user->username }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">E-mail</p>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $user->email ?? 'Niet ingesteld' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Telefoonnummer</p>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $user->phone ?? 'Niet ingesteld' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Rechter kolom - Account informatie -->
                <div class="flex-1 bg-gray-50 dark:bg-slate-700 p-5 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">Account Informatie</h2>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Account rollen</p>
                            <div class="mt-1 flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                    @php
                                        $roleColors = [
                                            'Admin' => 'bg-purple-600 dark:bg-purple-700',
                                            'Instructeur' => 'bg-green-600 dark:bg-green-700',
                                            'Student' => 'bg-orange-600 dark:bg-orange-700',
                                            // Fallback
                                            'default' => 'bg-blue-600 dark:bg-blue-700'
                                        ];
                                        $bgColor = $roleColors[$role->name] ?? $roleColors['default'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgColor }} text-white">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Account aangemaakt op</p>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('d-m-Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Laatste update</p>
                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $user->updated_at->format('d-m-Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acties -->
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('accounts.edit', $user) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Bewerk account
                </a>

                <form action="{{ route('accounts.destroy', $user) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="return confirm('Weet je zeker dat je dit account wilt verwijderen?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 100-2h-3.382l-.724-1.447A1 1 0011 2H9zM7 8a1 1 012 0v6a1 1 11-2 0V8zm5-1a1 1 00-1 1v6a1 1 102 0V8a1 1 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Verwijder account
                    </button>
                </form>
            </div>

            <!-- Extra secties kunnen hier worden toegevoegd indien nodig -->
        </div>
    </div>
</div>
@endsection
