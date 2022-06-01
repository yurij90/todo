<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2>Profil szerkesztés</h2>
                    <form class="p-5" action="{{ route('store_profile') }}" method="POST">
                        @csrf

                        <label class="form-label mt-2" for="user_name">Felhasználónév</label>
                        <input class="form-control" type="text" id="user_name" name="name" value="{{ $user->name }}">
                        @if ($errors->has('name'))
                            <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                        <label class="form-label mt-2" for="user_email">E-mail cím</label>
                        <input class="form-control" type="email" id="user_email" name="email" value="{{ $user->email }}">
                        @if ($errors->has('email'))
                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                        @endif
                        <label class="form-label mt-2" for="user_password">Jelszó</label>
                        <input type="password" id="user_password" class="form-control" name="password" value="">
                        @if ($errors->has('password'))
                            <div class="error text-danger">{{ $errors->first('password') }}</div>
                        @endif
                        <label class="form-label mt-2" for="user_password">Jelszó ismét</label>
                        <input type="password" id="user_password_confirm" class="form-control" name="password_confirm" value="">
                        @if ($errors->has('password_confirm'))
                            <div class="error text-danger">{{ $errors->first('password_confirm') }}</div>
                        @endif
                        <input class="btn btn-primary mt-2" type="submit" value="Mentés">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
