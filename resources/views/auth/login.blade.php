<x-guest-layout>
    <p class="mb-6 text-center text-gray-600 dark:text-gray-300 text-base">Log in op je account</p>
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Gebruikersnaam</label>
            <input id="username" name="username" type="text" required autofocus autocomplete="username" value="{{ old('username') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Wachtwoord</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:bg-slate-700">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Onthoud mij</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Wachtwoord vergeten?</a>
            @endif
        </div>
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow transition">Inloggen</button>
    </form>
    <div class="mt-6 text-center">
        <span class="text-sm text-gray-600 dark:text-gray-400">Nog geen account?</span>
        <a href="{{ route('register') }}" class="ml-1 text-blue-600 dark:text-blue-400 hover:underline font-medium">Registreer nu</a>
    </div>
</x-guest-layout>
