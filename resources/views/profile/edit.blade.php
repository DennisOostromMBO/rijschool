<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profiel - Rijschool Vierkante Wielen</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/rijschool-styles.css', 'resources/css/dark-mode.css'])
    @else
        <link rel="stylesheet" href="{{ asset('css/rijschool-styles.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    @endif
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
        .nav-item {
            transition: all 0.3s ease;
        }
        .nav-item:hover {
            transform: translateY(-2px);
        }
        .card {
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px 0 rgba(0,0,0,0.07);
            border: 1px solid #e5e7eb;
            margin-bottom: 2rem;
        }
        .card-body {
            padding: 2rem;
        }
        .dark .card {
            background: #1e293b;
            border-color: #334155;
        }
        .dark input,
        .dark select,
        .dark textarea {
            color: #e0e7ef;
            background: #0f172a;
            border-color: #334155;
        }
        .dark .card-body {
            color: #e0e7ef;
        }
        .dark .btn, .dark button, .dark input[type=submit] {
            color: #fff;
        }
        .dark .btn:hover, .dark button:hover, .dark input[type=submit]:hover {
            background: #1d4ed8;
        }
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            z-index: 50;
        }
        body, .min-h-screen {
            padding-top: 4rem !important;
        }
    </style>
</head>
<body class="antialiased bg-light-bg dark:bg-dark-bg">
    <!-- Custom Navbar -->
    <x-navbar>
        <x-slot:desktopMenu>
            <a href="{{ url('/home') }}" class="nav-item border-transparent text-gray-900 dark:text-gray-100 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
            <a href="{{ url('/packages') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Pakketten</a>
            <a href="{{ url('/instructors') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Instructeurs</a>
            <a href="{{ url('/cars') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Auto's</a>
            <a href="{{ url('/lessons') }}" class="nav-item border-transparent text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Rijlessen</a>
        </x-slot:desktopMenu>
        <x-slot:mobileMenu>
            <a href="{{ url('/home') }}" class="bg-blue-50 dark:bg-slate-800 border-blue-500 text-blue-700 dark:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
            <a href="{{ url('/packages') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Pakketten</a>
            <a href="{{ url('/instructors') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Instructeurs</a>
            <a href="{{ url('/cars') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Auto's</a>
            <a href="{{ url('/lessons') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Rijlessen</a>
            <x-notification-bell mobile="true" />
            @if(Auth::user() && Auth::user()->roles->pluck('name')->contains('Admin'))
            <a href="{{ route('accounts.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Accounts</a>
            @endif
        </x-slot:mobileMenu>
    </x-navbar>
    <div class="py-16 bg-gray-100 dark:bg-slate-900 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-extrabold text-blue-600 dark:text-gray-100 mb-10 text-center">Uw Profiel</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="card shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="card-body">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-blue-300 mb-6">Persoonlijke Informatie</h3>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="card-body">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-blue-300 mb-6">Wachtwoord Bijwerken</h3>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-blue-300 mb-6">Account Beheren</h3>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
