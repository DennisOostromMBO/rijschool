<x-guest-layout>
    <p class="mb-6 text-center text-gray-600 dark:text-gray-300 text-base">Registreer een nieuw account</p>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Voornaam</label>
            <input id="first_name" name="first_name" type="text" required autofocus autocomplete="given-name" value="{{ old('first_name') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>
        <div>
            <label for="middle_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tussenvoegsel</label>
            <input id="middle_name" name="middle_name" type="text" autocomplete="additional-name" value="{{ old('middle_name') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
        </div>
        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Achternaam</label>
            <input id="last_name" name="last_name" type="text" required autocomplete="family-name" value="{{ old('last_name') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>
        <div>
            <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Geboortedatum</label>
            <input id="birth_date" name="birth_date" type="date" required value="{{ old('birth_date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Gebruikersnaam</label>
            <input id="username" name="username" type="text" required autocomplete="username" value="{{ old('username') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">E-mailadres</label>
            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Telefoonnummer</label>
            <input id="phone" name="phone" type="tel" autocomplete="tel" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Wachtwoord</label>
            <input id="password" name="password" type="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bevestig Wachtwoord</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow transition">Registreren</button>
    </form>
    <div class="mt-6 text-center">
        <span class="text-sm text-gray-600 dark:text-gray-400">Al geregistreerd?</span>
        <a href="{{ route('login') }}" class="ml-1 text-blue-600 dark:text-blue-400 hover:underline font-medium">Log in</a>
    </div>
</x-guest-layout>
