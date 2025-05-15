<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Rijschool Vierkante Wielen')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/rijschool-styles.css'])
        @else
            <link rel="stylesheet" href="{{ asset('css/rijschool-styles.css') }}">
        @endif

        <!-- Additional Custom Styles -->
        <style>
            :root {
                --primary-color: #3b82f6;
                --secondary-color: #1e40af;
                --accent-color: #f59e0b;
                --light-bg: #f8fafc;
                --dark-bg: #1e293b;
            }

            body {
                font-family: 'Montserrat', sans-serif;
            }
        </style>
        @stack('scripts')
    </head>
    <body class="antialiased bg-light-bg dark:bg-dark-bg">
        <!-- Navigation -->
        <x-navbar>
            <x-slot:desktopMenu>
                <a href="{{ url('/') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>

                <a href="{{ url('/packages') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Pakketten</a>

                <a href="{{ url('/instructors') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Instructeurs</a>

                <a href="{{ url('/cars') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Auto's</a>

                <a href="{{ url('/lessons') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Rijlessen</a>

                @if(Auth::user() && Auth::user()->roles->pluck('name')->contains('Admin'))
                <a href="{{ route('accounts.index') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Accounts</a>
                @endif
            </x-slot:desktopMenu>

            <x-slot:mobileMenu>
                <a href="{{ url('/') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                <a href="{{ url('/packages') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Pakketten</a>
                <a href="{{ url('/instructors') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Instructeurs</a>
                <a href="{{ url('/cars') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Auto's</a>
                <a href="{{ url('/lessons') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Rijlessen</a>
                @if(Auth::user() && Auth::user()->roles->pluck('name')->contains('Admin'))
                <a href="{{ route('accounts.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Accounts</a>
                @endif
            </x-slot:mobileMenu>
        </x-navbar>

        <!-- Page content -->
        <div class="pt-16">
            <!-- Flash Messages -->
            @if(session('success') || session('error') || session('warning') || session('info'))
                <div class="container mx-auto px-4 mt-6">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    @if(session('warning'))
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                            <p>{{ session('warning') }}</p>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                            <p>{{ session('info') }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Main Content -->
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <h3 class="text-xl font-bold mb-4">Rijschool Vierkante Wielen</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Professionele rijopleidingen voor leerlingen van alle leeftijden en vaardigheden.</p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Snelle Links</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ url('/home') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Home</a></li>
                            <li><a href="{{ url('/packages') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Lespakketten</a></li>
                            <li><a href="{{ url('/instructors') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Onze Instructeurs</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Rijlesstraat 123, Amsterdam, Nederland</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>+31 20 123 4567</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-8 text-center text-gray-500 dark:text-gray-400">
                    <p>&copy; {{ date('Y') }} Rijschool Vierkante Wielen. Alle rechten voorbehouden.</p>
                </div>
            </div>
        </footer>

        @yield('scripts')
    </body>
</html>
