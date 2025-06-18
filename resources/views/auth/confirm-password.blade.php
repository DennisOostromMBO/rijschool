<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Bevestig je wachtwoord voordat je doorgaat.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="'Wachtwoord'" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                Bevestigen
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
