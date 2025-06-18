<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Rijschool Vierkante Wielen</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/dark-mode.css'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100 dark:bg-slate-900">
        <div class="min-h-screen flex flex-col justify-center items-center">
            <div class="w-full sm:max-w-md mt-8 px-6 py-8 bg-white dark:bg-slate-800 shadow-lg rounded-lg">
                <a href="/" class="flex flex-col items-center group mb-8">
                    <span class="text-3xl font-extrabold text-blue-600 dark:text-gray-100 group-hover:text-blue-700 dark:group-hover:text-gray-300 transition">Rijschool Vierkante Wielen</span>
                </a>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
