@props(['darkMode' => true])

<nav class="bg-white dark:bg-slate-900 shadow-md fixed w-full z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $title ?? 'Rijschool Vierkante Wielen' }}</span>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <!-- Desktop Navigation -->
                    {{ $desktopMenu ?? '' }}
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Authentication Dropdown -->
                @auth
                <div class="ml-3 relative" x-data="{ open: false }" @click.away="open = false">
                    <div>
                        <button @click="open = !open" class="flex items-center text-sm font-normal text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none transition duration-150 ease-in-out">
                            <span class="mr-1">Hallo, {{ Auth::user()->full_name }}</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <!-- Dropdown menu, show/hide based on menu state -->
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
                         role="menu"
                         aria-orientation="vertical"
                         aria-labelledby="user-menu"
                         style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">Profiel</a>
                        <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">Instellingen</a>
                        @if(Auth::user()->roles->pluck('name')->contains('Admin'))
                            <a href="{{ route('accounts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">Accounts beheren</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                Uitloggen
                            </button>
                        </form>
                    </div>
                </div>
                @else
                    <!-- Authentication Links for guests -->
                    <a href="{{ route('login') }}" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">Inloggen</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Registreren</a>
                    @endif
                @endauth

                @if($darkMode)
                <div class="flex items-center ml-3">
                    <button id="theme-toggle" class="p-2 rounded-md text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white">
                        <span id="theme-toggle-icon" class="sr-only">Toggle theme</span>
                        <svg id="light-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg id="dark-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>
                @endif
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" id="mobile-menu-button">
                    <span class="sr-only">Open menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            {{ $mobileMenu ?? '' }}
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
            @auth
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                            {{ substr(Auth::user()->first_name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ Auth::user()->username }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Profiel
                    </a>
                    <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Instellingen
                    </a>
                    @if(Auth::user()->roles->pluck('name')->contains('Admin'))
                        <a href="{{ route('accounts.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Accounts beheren
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Uitloggen
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Inloggen
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Registreren
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endPushOnce

@if($darkMode)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('theme-toggle');
        const lightIcon = document.getElementById('light-icon');
        const darkIcon = document.getElementById('dark-icon');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        // Check local storage for theme preference
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            document.documentElement.classList.add('dark');
            lightIcon.classList.remove('hidden');
            darkIcon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            lightIcon.classList.add('hidden');
            darkIcon.classList.remove('hidden');
        }

        // Toggle theme
        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            const isDarkMode = document.documentElement.classList.contains('dark');
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
            lightIcon.classList.toggle('hidden');
            darkIcon.classList.toggle('hidden');
        });

        // Mobile menu toggle
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // When the user scrolls down, add a shadow to the navbar
        window.addEventListener('scroll', function() {
            const header = document.querySelector('nav');
            if (window.scrollY > 10) {
                header.classList.add('shadow-md');
            } else {
                header.classList.remove('shadow-md');
            }
        });
    });
</script>
@endif
