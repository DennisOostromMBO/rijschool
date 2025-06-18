@extends('layouts.app')
@section('title', 'Notificaties Overzicht')
@section('content')
<div class="container mx-auto px-4 py-6 w-full">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-visible">
        <!-- Header & Actions -->
        <div class="bg-white dark:bg-slate-800 p-4 flex justify-between items-center border-b dark:border-slate-700">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Notificaties</h1>
            <div class="flex space-x-2">
                @if(auth()->user()->isAdmin() || auth()->user()->isInstructor())
                <a href="{{ route('notifications.create') }}" class="text-white dark:text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Nieuwe Notificatie
                </a>
                @endif

                @if(auth()->user()->isInstructor())
                <a href="{{ route('notifications.instructor-students') }}" class="text-white dark:text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                    Mijn Studenten
                </a>
                @endif

                <button id="help-button" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Help
                </button>
            </div>
        </div>

        <!-- Help Panel -->
        <div id="help-info" class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-4 rounded-r hidden">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Gebruiksaanwijzing - Notificaties Overzicht</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-100">
                        <p class="font-semibold mb-1">Op deze pagina kunt u alle notificaties beheren:</p>
                        <ol class="list-decimal list-inside mt-1 pl-2 space-y-2">
                            <li><span class="font-semibold">Zoeken:</span> Vul een bericht in het zoekvak in en klik op de blauwe 'Zoeken' knop.</li>
                            <li><span class="font-semibold">Filteren op type:</span> Selecteer een type notificatie in het dropdown menu om alleen die notificaties te zien.</li>
                            <li><span class="font-semibold">Sorteren:</span> Klik op een kolomheader ('Datum') om te sorteren. Klik nogmaals om de sorteervolgorde om te draaien.</li>
                            <li><span class="font-semibold">Aantal resultaten:</span> Kies hoeveel notificaties u per pagina wilt zien via 'Items per pagina'.</li>
                            <li><span class="font-semibold">Acties:</span>
                                <ul class="list-disc list-inside pl-4 mt-1">
                                    <li><span class="text-blue-600 dark:text-blue-400">👁️ Bekijken</span> - Toont gedetailleerde informatie over een notificatie</li>
                                    <li><span class="text-amber-600 dark:text-amber-400">✏️ Bewerken</span> - Wijzig notificatie gegevens zoals bericht of type</li>
                                    <li><span class="text-green-600 dark:text-green-400">📤 Verzenden</span> - Verstuur een notificatie naar de ontvangers</li>
                                    <li><span class="text-red-600 dark:text-red-400">🗑️ Verwijderen</span> - Verwijdert een notificatie (let op: deze actie kan niet ongedaan worden gemaakt!)</li>
                                </ul>
                            </li>
                            <li><span class="font-semibold">Types:</span> Notificaties worden weergegeven met gekleurde labels:
                                <ul class="list-disc list-inside pl-4 mt-1">
                                    <li><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-600 text-white">Ziekmelding</span> - Ziekmeldingen van studenten of instructeurs</li>
                                    <li><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-600 text-white">Leswijziging</span> - Wijzigingen in lestijden of datums</li>
                                    <li><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-600 text-white">Lesannulering</span> - Geannuleerde lessen</li>
                                    <li><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-600 text-white">Ophaaladres</span> - Wijzigingen in ophaaladressen</li>
                                    <li><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-purple-600 text-white">Lesdoel</span> - Wijzigingen in lesdoelen</li>
                                    <li><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-600 text-white">Lestoewijzing</span> - Nieuwe lessen toegewezen</li>
                                </ul>
                            </li>
                        </ol>
                        <p class="mt-3 italic">Klik op de <span class="font-semibold">Help</span> knop rechtsboven als u deze instructies opnieuw wilt bekijken.</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('help-info').style.display='none'" class="ml-auto text-blue-500 hover:text-blue-700 dark:hover:text-blue-300">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Geavanceerde zoek- en filtersectie -->
        <div class="p-4 bg-gray-50 dark:bg-slate-700 border-b dark:border-slate-600">
            <form method="GET" action="{{ route('notifications.index') }}" class="space-y-3">
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Zoekbalk -->
                    <div class="flex-grow">
                        <label for="search" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Zoeken</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Zoek op bericht..." class="pl-10 w-full rounded-md border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tip: U kunt zoeken op (deel van) het bericht</p>
                    </div>

                    <!-- Type filter -->
                    <div class="w-full sm:w-auto">
                        <label for="type" class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Filter op type</label>
                        <select name="notification_type" id="type" class="rounded-md border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                            <option value="">Alle types</option>
                            <option value="Sick" {{ request('notification_type') == 'Sick' ? 'selected' : '' }}>Ziekmelding</option>
                            <option value="LessonChange" {{ request('notification_type') == 'LessonChange' ? 'selected' : '' }}>Leswijziging</option>
                            <option value="LessonCancellation" {{ request('notification_type') == 'LessonCancellation' ? 'selected' : '' }}>Lesannulering</option>
                            <option value="PickupAddressChange" {{ request('notification_type') == 'PickupAddressChange' ? 'selected' : '' }}>Ophaaladres wijziging</option>
                            <option value="LessonGoalChange" {{ request('notification_type') == 'LessonGoalChange' ? 'selected' : '' }}>Lesdoel wijziging</option>
                            <option value="LessonAssignment" {{ request('notification_type') == 'LessonAssignment' ? 'selected' : '' }}>Lestoewijzing</option>
                        </select>
                    </div>

                    <!-- Doelgroep filter -->
                    <div class="w-full sm:w-auto">
                        <label for="target" class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Filter op doelgroep</label>
                        <select name="target_group" id="target" class="rounded-md border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                            <option value="">Alle doelgroepen</option>
                            <option value="Student" {{ request('target_group') == 'Student' ? 'selected' : '' }}>Studenten</option>
                            <option value="Instructor" {{ request('target_group') == 'Instructor' ? 'selected' : '' }}>Instructeurs</option>
                            <option value="Both" {{ request('target_group') == 'Both' ? 'selected' : '' }}>Beide</option>
                        </select>
                    </div>

                    <!-- Items per pagina -->
                    <div class="w-full sm:w-auto">
                        <label for="per_page" class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Items per pagina</label>
                        <select name="per_page" id="per_page" class="rounded-md border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                            @foreach([10, 25, 50, 100] as $perPageOption)
                                <option value="{{ $perPageOption }}" {{ request('per_page', 10) == $perPageOption ? 'selected' : '' }}>{{ $perPageOption }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Actieknoppen -->
                <div class="flex flex-wrap justify-between items-center mt-3">
                    <div class="flex flex-wrap gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            Zoeken
                        </button>

                        @if(request('search') || request('notification_type') || request('target_group') || request('per_page') || request('sort_by'))
                            <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 text-gray-700 dark:text-gray-200 rounded-md text-sm font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Reset filters
                            </a>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 sm:mt-0">
                        Toon <span class="font-medium">{{ $notifications->firstItem() ?? 0 }}</span> - <span class="font-medium">{{ $notifications->lastItem() ?? 0 }}</span> van <span class="font-medium">{{ $notifications->total() }}</span> notificaties
                    </p>
                </div>
            </form>
        </div>

        @if(auth()->user()->isStudent())
        <!-- Button to mark all notifications as read -->
        <div class="flex justify-end p-4 bg-gray-50 dark:bg-slate-700 border-b dark:border-slate-600">
            <form action="{{ route('notifications.mark-all-as-read') }}" method="POST" class="inline-block mark-all-read-form">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Markeer alles als gelezen
                </button>
            </form>
        </div>
        @endif

        <!-- Tabel met notificaties -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-600">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        @if(auth()->user()->isStudent())
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Titel
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Bericht
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('notifications.index', array_merge(request()->query(), ['sort_by' => 'date', 'sort_direction' => request('sort_by') === 'date' && request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center">
                                    Datum
                                    @if(request('sort_by') === 'date')
                                        <span class="ml-1 text-gray-400">{{ request('sort_direction') === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ml-1 text-gray-400 opacity-0 group-hover:opacity-100">↓</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Acties
                            </th>
                        @else
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Titel
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Bericht
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="{{ route('notifications.index', array_merge(request()->query(), ['sort_by' => 'date', 'sort_direction' => request('sort_by') === 'date' && request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center">
                                    Datum
                                    @if(request('sort_by') === 'date')
                                        <span class="ml-1 text-gray-400">
                                            @if(request('sort_direction') === 'asc')
                                                ↑
                                            @else
                                                ↓
                                            @endif
                                        </span>
                                    @else
                                        <span class="ml-1 text-gray-400 opacity-0 group-hover:opacity-100">↓</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Voor
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Acties
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-600">
                    @forelse($notifications as $notification)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $notification->title ?? 'Geen titel' }}</div>
                                @if($notification->recipient_id)
                                    <div class="text-xs text-blue-600 dark:text-blue-300 mt-1 font-medium">
                                        Persoonlijk bericht voor: {{ $notification->recipient->first_name }} {{ $notification->recipient->last_name }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ \Illuminate\Support\Str::limit($notification->message, 50) }}</div>
                                @if($notification->remark)
                                    <div class="text-xs text-gray-600 dark:text-gray-300 italic mt-1">{{ \Illuminate\Support\Str::limit($notification->remark, 30) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeColors = [
                                        'Sick' => 'bg-red-600 dark:bg-red-600 border border-red-400 dark:border-red-500',
                                        'LessonChange' => 'bg-amber-600 dark:bg-amber-600 border border-amber-400 dark:border-amber-500',
                                        'LessonCancellation' => 'bg-red-600 dark:bg-red-600 border border-red-400 dark:border-red-500',
                                        'PickupAddressChange' => 'bg-blue-600 dark:bg-blue-600 border border-blue-400 dark:border-blue-500',
                                        'LessonGoalChange' => 'bg-purple-600 dark:bg-purple-600 border border-purple-400 dark:border-purple-500',
                                        'LessonAssignment' => 'bg-green-600 dark:bg-green-600 border border-green-400 dark:border-green-500',
                                        // Fallback
                                        'default' => 'bg-gray-600 dark:bg-gray-600 border border-gray-400 dark:border-gray-500'
                                    ];
                                    $typeLabels = [
                                        'Sick' => 'Ziekmelding',
                                        'LessonChange' => 'Leswijziging',
                                        'LessonCancellation' => 'Lesannulering',
                                        'PickupAddressChange' => 'Ophaaladres',
                                        'LessonGoalChange' => 'Lesdoel',
                                        'LessonAssignment' => 'Lestoewijzing',
                                        // Fallback
                                        'default' => 'Onbekend'
                                    ];
                                    $bgColor = $typeColors[$notification->notification_type] ?? $typeColors['default'];
                                    $label = $typeLabels[$notification->notification_type] ?? $typeLabels['default'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgColor }} text-white">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-200 font-medium">
                                {{ $notification->date ? $notification->date->format('d-m-Y') : 'N/A' }}
                            </td>

                            @if(auth()->user()->isStudent())
                            <!-- Actions column for students -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @if(!$notification->is_read &&
                                    (($notification->target_group == 'Student' || $notification->target_group == 'Both') ||
                                        $notification->recipient_id == auth()->id()))
                                    <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST" class="inline mark-as-read-form">
                                        @csrf
                                        <button type="submit" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 relative group">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">Markeer als gelezen</span>
                                        </button>
                                    </form>
                                    @endif

                                    @if($notification->is_read)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Gelezen {{ $notification->read_at ? $notification->read_at->format('d-m-Y H:i') : '' }}
                                    </span>
                                    @endif

                                    @if(!$notification->is_sent && ($notification->target_group == 'Student' || $notification->target_group == 'Both'))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-800/30 text-blue-800 dark:text-blue-200">
                                        Nieuw
                                    </span>
                                    @endif
                                </div>
                            </td>
                            @else
                            <!-- "Voor" column for non-students -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-200">
                                @if($notification->target_group == 'Student')
                                    <span class="rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-200">
                                        Studenten
                                    </span>
                                @elseif($notification->target_group == 'Instructor')
                                    <span class="rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-800/30 dark:text-purple-200">
                                        Instructeurs
                                    </span>
                                @elseif($notification->target_group == 'Both')
                                    <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-800/30 dark:text-blue-200">
                                        Beide
                                    </span>
                                @endif
                            </td>

                            <!-- Status column for non-students -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-200">
                                @if($notification->is_sent)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-200">
                                        Verzonden
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-800/30 text-red-800 dark:text-red-200">
                                        Concept
                                    </span>
                                @endif
                            </td>

                            <!-- Actions column for non-students -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('notifications.show', $notification) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>

                                    @if(auth()->user()->isAdmin() || (auth()->user()->isInstructor() && $notification->user_id == auth()->id()))
                                        <a href="{{ route('notifications.edit', $notification) }}" class="text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline" onsubmit="return confirm('Weet u zeker dat u deze notificatie wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 ml-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>

                                        @if(!$notification->is_sent)
                                            <form action="{{ route('notifications.send', $notification) }}" method="POST" class="inline" onsubmit="return confirm('Weet u zeker dat u deze notificatie wilt verzenden?');">
                                                @csrf
                                                <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 ml-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isStudent() ? '5' : '7' }}" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <p class="text-lg font-medium">Geen notificaties gevonden</p>
                                    <p class="text-base mt-1">Probeer andere zoekfilters of maak nieuwe notificaties aan</p>
                                    @if(request('search') || request('notification_type') || request('target_group'))
                                        <a href="{{ route('notifications.index') }}" class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition">Alle notificaties tonen</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginering -->
        <div class="px-4 py-3 bg-gray-50 dark:bg-slate-700 border-t dark:border-slate-600">
            @if($notifications->hasPages())
                <div class="flex flex-col items-center">
                    <div class="flex gap-2 flex-wrap justify-center items-center mb-2">
                        <a href="{{ $notifications->appends(request()->query())->url(1) }}" class="relative inline-flex items-center px-4 py-2 {{ $notifications->onFirstPage() ? 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-gray-500 cursor-default' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700' }} border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Eerste
                        </a>

                        <a href="{{ $notifications->appends(request()->query())->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 {{ $notifications->onFirstPage() ? 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-gray-500 cursor-default' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700' }} border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Vorige
                        </a>

                        <span class="relative inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Pagina {{ $notifications->currentPage() }} van {{ $notifications->lastPage() }}
                        </span>

                        <a href="{{ $notifications->appends(request()->query())->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 {{ $notifications->hasMorePages() ? 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700' : 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-gray-500 cursor-default' }} border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Volgende
                        </a>

                        <a href="{{ $notifications->appends(request()->query())->url($notifications->lastPage()) }}" class="relative inline-flex items-center px-4 py-2 {{ $notifications->hasMorePages() ? 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700' : 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-gray-500 cursor-default' }} border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Laatste
                        </a>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Toon <span class="font-medium">{{ $notifications->firstItem() ?? 0 }}</span> tot <span class="font-medium">{{ $notifications->lastItem() ?? 0 }}</span> van <span class="font-medium">{{ $notifications->total() }}</span> resultaten
                    </p>
                </div>
            @else
                <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                    Geen resultaten om te pagineren
                </p>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript voor de hulpinfo-sectie -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const helpInfo = document.getElementById('help-info');
        const helpButton = document.getElementById('help-button');

        // Toon of verberg de hulpinfo op basis van eerder gedrag
        if (helpInfo && localStorage.getItem('notificationsHelpDismissed')) {
            helpInfo.style.display = 'none';
        }

        // Help-knop functionaliteit: toon de hulpsectie weer
        helpButton.addEventListener('click', function() {
            helpInfo.style.display = 'block';
            // Optioneel: scroll naar de hulpinfo
            helpInfo.scrollIntoView({ behavior: 'smooth' });
        });

        // Sluitknop
        const closeButton = helpInfo?.querySelector('button');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                helpInfo.style.display = 'none';
                localStorage.setItem('notificationsHelpDismissed', 'true');
            });
        }
    });
</script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set up CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Function to handle the mark as read AJAX request
        function markAsRead(form, isMarkAll = false) {
            const formData = new FormData(form);
            const url = form.getAttribute('action');

            console.log('Sending mark-as-read request to:', url);
            console.log('Form data:', Object.fromEntries(formData.entries()));

            return fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (!data.success) {
                    throw new Error(data.message || 'Er is iets misgegaan');
                }
                return data;
            })
            .catch(error => {
                console.error('Error details:', error);
                throw error;
            });
        }

        // Function to show success message
        function showSuccessMessage(message) {
            const successAlert = document.createElement('div');
            successAlert.classList.add(
                'fixed', 'bottom-5', 'right-5', 'bg-green-500',
                'text-white', 'px-4', 'py-2', 'rounded', 'shadow-lg',
                'z-50', 'transition-opacity', 'duration-500'
            );
            successAlert.textContent = message;
            document.body.appendChild(successAlert);

            setTimeout(() => {
                successAlert.classList.add('opacity-0');
                setTimeout(() => successAlert.remove(), 500);
            }, 3000);
        }

        // Handle the mark-as-read functionality
        document.querySelectorAll('.mark-as-read-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const notificationRow = form.closest('tr');

                markAsRead(form)
                    .then(data => {
                        // Update UI
                        form.remove();

                        // Check if we're in student view (5th column is 'Acties' not 'Status')
                        const isStudentView = document.querySelector('th:nth-child(5)').textContent.trim() === 'Acties';

                        if (isStudentView) {
                            // Just add a visual indication that it's read
                            notificationRow.classList.add('opacity-70');

                            // And disable the mark-as-read button (should be already removed by form.remove())
                            const actionsCell = notificationRow.querySelector('td:last-child');
                            if (actionsCell) {
                                const successIcon = document.createElement('span');
                                successIcon.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                `;
                                actionsCell.appendChild(successIcon);
                            }
                        } else {
                            // For admin/instructor view with Status column
                            const statusColumn = notificationRow.querySelector('td:nth-child(6)'); // Status column is 6th for admin/instructor
                            if (statusColumn) {
                                const statusWrapper = statusColumn.querySelector('div') || statusColumn;
                                const readBadge = document.createElement('span');
                                readBadge.classList.add(
                                    'inline-flex', 'items-center', 'px-2.5', 'py-0.5',
                                    'rounded-full', 'text-xs', 'font-medium',
                                    'bg-green-100', 'dark:bg-green-800/30',
                                    'text-green-800', 'dark:text-green-200'
                                );

                                const now = new Date();
                                readBadge.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Gelezen ${now.toLocaleDateString('nl-NL')} ${now.toLocaleTimeString('nl-NL')}
                                `;

                                statusWrapper.appendChild(readBadge);
                            }
                        }

                        // Remove new badge if exists
                        const newBadge = notificationRow.querySelector('.bg-blue-100');
                        if (newBadge) {
                            newBadge.remove();
                        }

                        showSuccessMessage(data.message);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Create a more detailed error message
                        const errorMessage = error.message || 'Er is een fout opgetreden bij het markeren als gelezen';
                        alert(errorMessage + '. Probeer het opnieuw of neem contact op met de beheerder.');
                    });
            });
        });

        // Handle mark-all-as-read functionality
        const markAllAsReadForm = document.querySelector('.mark-all-read-form');
        if (markAllAsReadForm) {
            markAllAsReadForm.addEventListener('submit', function(e) {
                e.preventDefault();

                markAsRead(markAllAsReadForm, true)
                    .then(data => {
                        // Show success message first
                        showSuccessMessage(data.message);

                        // Check if we're in student view
                        const isStudentView = document.querySelector('th:nth-child(5)').textContent.trim() === 'Acties';

                        if (isStudentView) {
                            // For students, visually mark all unread notifications as read
                            const markAsReadForms = document.querySelectorAll('.mark-as-read-form');
                            markAsReadForms.forEach(form => {
                                const notificationRow = form.closest('tr');
                                if (notificationRow) {
                                    notificationRow.classList.add('opacity-70');
                                    form.remove();

                                    // Add success icon to actions cell
                                    const actionsCell = notificationRow.querySelector('td:last-child');
                                    if (actionsCell) {
                                        const successIcon = document.createElement('span');
                                        successIcon.innerHTML = `
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        `;
                                        actionsCell.appendChild(successIcon);
                                    }
                                }
                            });
                        } else {
                            // For admin/instructor, reload the page
                            setTimeout(() => window.location.reload(), 500);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const errorMessage = error.message || 'Er is een fout opgetreden bij het markeren van alle notificaties als gelezen';
                        alert(errorMessage + '. Probeer het opnieuw of neem contact op met de beheerder.');
                    });
            });
        }
    });

    // Help button functionality to show/hide the help panel
    document.getElementById('help-button').addEventListener('click', function() {
        const helpInfo = document.getElementById('help-info');
        if (helpInfo.classList.contains('hidden')) {
            helpInfo.classList.remove('hidden');
        } else {
            helpInfo.classList.add('hidden');
        }
    });
</script>
@endpush

@push('styles')
<style>
    .notification-read {
        opacity: 0.7;
        transition: opacity 0.3s ease-in-out;
    }

    .notification-unread {
        opacity: 1;
        transition: opacity 0.3s ease-in-out;
    }

    .mark-as-read-success {
        animation: fadeInOut 3s ease-in-out;
    }

    .opacity-70 {
        opacity: 0.7;
    }

    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(20px); }
        10% { opacity: 1; transform: translateY(0); }
        90% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-20px); }
    }
</style>
@endpush
@endsection
