<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Felhasználók') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="app" class="p-6 bg-white border-b border-gray-200">

                    <h2>Felhasználók</h2>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jogosultság</th>
                            <th>Felhasználónév</th>
                            <th>E-mail</th>
                            <th>Létrehozva</th>
                            <th>Módosítva</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    @if($user->role == "admin" && Auth::user()->id != $user->id)
                                    <form :action="'/admin/edit_users/demote/'+{{ $user->id }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" :value="{{ $user->id }}">
                                        <button type="submit"><i class="fa-solid fa-user-minus link-danger"></i></button>
                                    </form>
                                    @elseif($user->role == "user")
                                        <form :action="'/admin/edit_users/promote/'+{{ $user->id }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" :value="{{ $user->id }}">
                                            <button type="submit"><i class="fa-solid fa-user-plus link-success"></i></button>
                                        </form>
                                    @else

                                    @endif
                                </td>
                                <td>
                                    @if(Auth::user()->id != $user->id)
                                    <form :action="'/admin/edit_users/delete/'+{{ $user->id }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" :value="{{ $user->id }}">
                                        <button type="submit"><i class='fa-solid fa-trash-can link-danger'></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

