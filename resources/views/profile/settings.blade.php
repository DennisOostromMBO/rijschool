<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instellingen - Rijschool Vierkante Wielen</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/rijschool-styles.css'])
    @else
        <link rel="stylesheet" href="{{ asset('css/rijschool-styles.css') }}">
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
        .dark label,
        .dark .font-semibold,
        .dark .font-medium,
        .dark .text-gray-700,
        .dark .text-gray-800,
        .dark .text-gray-900 {
            color: #60a5fa !important;
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
        .dark .text-sm, .dark .text-base {
            color: #60a5fa !important;
        }
        .dark .text-blue-600, .dark .text-blue-400 {
            color: #60a5fa !important;
        }
        .dark .btn, .dark button, .dark input[type=submit] {
            background: #2563eb;
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
        </x-slot:mobileMenu>
    </x-navbar>
    <div class="py-16 bg-gray-100 dark:bg-slate-900 min-h-screen">
        <div class="max-w-3xl mx-auto space-y-8">
            <h2 class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mb-8 text-center">Instellingen</h2>
            <div class="card">
                <div class="card-body">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Application Settings') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Manage your application preferences and settings.') }}
                            </p>
                        </header>
                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                            <div>
                                <x-input-label for="theme_preference" :value="__('Theme Preference')" />
                                <select id="theme_preference" name="theme_preference" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="system">System Default</option>
                                    <option value="light">Light Mode</option>
                                    <option value="dark">Dark Mode</option>
                                </select>
                                <x-input-error :messages="$errors->get('theme_preference')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="notifications_enabled" :value="__('Email Notifications')" />
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="notifications_enabled" name="notifications_enabled" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Enable email notifications</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('notifications_enabled')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="language" :value="__('Language')" />
                                <select id="language" name="language" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="en">English</option>
                                    <option value="nl">Dutch</option>
                                    <option value="de">German</option>
                                    <option value="fr">French</option>
                                </select>
                                <x-input-error :messages="$errors->get('language')" class="mt-2" />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                                @if (session('status') === 'settings-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
