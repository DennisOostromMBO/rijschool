@extends('layouts.app')

@section('title', 'Account Overzicht')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Informatieve sectie voor nieuwe gebruikers -->
    <div id="help-info" class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-4 rounded-r">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Hulp bij het gebruik van deze pagina</h3>
                <div class="mt-2 text-sm text-blue-700 dark:text-blue-200">
                    <p>Op deze pagina kunt u alle gebruikersaccounts beheren. U kunt:</p>
                    <ul class="list-disc list-inside mt-1 pl-2">
                        <li>Zoeken op naam of gebruikersnaam met het zoekvak</li>
                        <li>Filteren op specifieke rollen met het rolfilter</li>
                        <li>Sorteren door op de kolomkoppen te klikken</li>
                        <li>Het aantal items per pagina aanpassen</li>
                    </ul>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('help-info').style.display='none'" class="ml-auto text-blue-500 hover:text-blue-700 dark:hover:text-blue-300">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden">
        <!-- Header met titel -->
        <div class="bg-blue-600 dark:bg-blue-800 text-white p-4">
            <h1 class="text-2xl font-semibold">Account Overzicht</h1>
        </div>

        <!-- Geavanceerde zoek- en filtersectie -->
        <div class="p-4 bg-gray-50 dark:bg-slate-700 border-b dark:border-slate-600">
            <form method="GET" action="{{ route('accounts.index') }}" class="space-y-3">
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
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Zoek op naam of gebruikersnaam..." class="pl-10 w-full rounded-md border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tip: U kunt zoeken op voor- of achternaam of gebruikersnaam</p>
                    </div>

                    <!-- Rol filter -->
                    <div class="w-full sm:w-auto">
                        <label for="role" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Filter op rol</label>
                        <select name="role" id="role" class="rounded-md border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                            <option value="">Alle rollen</option>
                            @foreach($roles as $roleName)
                                <option value="{{ $roleName }}" {{ request('role') == $roleName ? 'selected' : '' }}>{{ $roleName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Items per pagina -->
                    <div class="w-full sm:w-auto">
                        <label for="per_page" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Items per pagina</label>
                        <select name="per_page" id="per_page" class="rounded-md border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-30">
                            @foreach([10, 25, 50, 100] as $perPageOption)
                                <option value="{{ $perPageOption }}" {{ request('per_page') == $perPageOption ? 'selected' : '' }}>{{ $perPageOption }}</option>
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

                        @if(request('search') || request('role') || request('per_page') || request('sort_by'))
                            <a href="{{ route('accounts.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 text-gray-700 dark:text-gray-200 rounded-md text-sm font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Reset filters
                            </a>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 sm:mt-0">
                        Toon <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span> - <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span> van <span class="font-medium">{{ $users->total() }}</span> accounts
                    </p>
                </div>
            </form>
        </div>

        <!-- Tabel met accounts -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-600">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <a href="{{ route('accounts.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_direction' => request('sort_by') === 'id' && request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center">
                                #
                                @if(request('sort_by') === 'id')
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
                            <a href="{{ route('accounts.index', array_merge(request()->query(), ['sort_by' => 'first_name', 'sort_direction' => request('sort_by') === 'first_name' && request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center">
                                Naam
                                @if(request('sort_by') === 'first_name')
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
                            <a href="{{ route('accounts.index', array_merge(request()->query(), ['sort_by' => 'username', 'sort_direction' => request('sort_by') === 'username' && request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center">
                                Gebruikersnaam
                                @if(request('sort_by') === 'username')
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
                            Rollen
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aangemaakt
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Acties
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-600">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $user->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-600 dark:bg-blue-700 text-white mr-1">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('accounts.show', $user) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 relative group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">Bekijk alle details van deze gebruiker</span>
                                    </a>
                                    <a href="{{ route('accounts.edit', $user) }}" class="text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 relative group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">Wijzig gebruikersgegevens</span>
                                    </a>
                                    <form action="{{ route('accounts.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 relative group"
                                            onclick="return confirm('Weet je zeker dat je dit account wilt verwijderen?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">Verwijder deze gebruiker permanent</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-lg font-medium">Geen accounts gevonden</p>
                                    <p class="text-base mt-1">Probeer andere zoekfilters of voeg nieuwe accounts toe</p>
                                    @if(request('search') || request('role'))
                                        <a href="{{ route('accounts.index') }}" class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition">Alle accounts tonen</a>
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
            @if($users->hasPages())
                <div class="flex flex-col items-center">
                    <div class="flex gap-2 flex-wrap justify-center items-center mb-2">
                        <a href="{{ $users->appends(request()->query())->url(1) }}" class="relative inline-flex items-center px-4 py-2 {{ $users->onFirstPage() ? 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-gray-500 cursor-default' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700' }} border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Eerste
                        </a>

                        <a href="{{ $users->appends(request()->query())->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 {{ $users->onFirstPage() ? 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-gray-500 cursor-default' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700' }} border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Vorige
                        </a>

                        <span class="relative inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Pagina {{ $users->currentPage() }} van {{ $users->lastPage() }}
                        </span>

                        <a href="{{ $users->appends(request()->query())->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 {{ $users->hasMorePages() ? 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700' : 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-gray-500 cursor-default' }} border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Volgende
                        </a>

                        <a href="{{ $users->appends(request()->query())->url($users->lastPage()) }}" class="relative inline-flex items-center px-4 py-2 {{ $users->hasMorePages() ? 'bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700' : 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-gray-500 cursor-default' }} border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-md">
                            Laatste
                        </a>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Toon <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span> tot <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span> van <span class="font-medium">{{ $users->total() }}</span> resultaten
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
    // Controleer of de gebruiker de hulpsectie al heeft gesloten
    document.addEventListener('DOMContentLoaded', function() {
        const helpInfo = document.getElementById('help-info');
        if (helpInfo && localStorage.getItem('accountHelpDismissed')) {
            helpInfo.style.display = 'none';
        }

        // Voeg event listener toe om de sluiting op te slaan
        const closeButton = helpInfo?.querySelector('button');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                localStorage.setItem('accountHelpDismissed', 'true');
            });
        }
    });
</script>
@endsection
