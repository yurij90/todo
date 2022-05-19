<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Köszönjük a feliratkozást! Mielőtt elkezdené, meg tudná erősíteni e-mail címét az imént e-mailben elküldött linkre kattintva? Ha nem kapta meg az e-mailt, szívesen küldünk egy másikat.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Új ellenőrző linket küldtünk a regisztráció során megadott e-mail címre.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Megerősítő e-mail újraküldése') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Kijelentkezés') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
