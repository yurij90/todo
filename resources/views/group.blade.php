<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Csoportok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="app" class="p-6 bg-white border-b border-gray-200">

                    <h2>Csoportjaid</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Csoport neve</th>
                                <th>Létrehozta</th>
                                <th>Tagok</th>
                                <th>Hozzáadva</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($groups as $group)
                            <tr>
                                <td>{{ $group->group_name }}</td>
                                <td>
                                    {{ $users[$group->group_owner]->name }}
                                </td>
                                <td>
                                    @foreach($group->users as $user)
                                    [{{ $user->name }}]
                                    @endforeach
                                </td>
                                <td>{{ $group->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    Nincsenek csoportjaid!
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <hr>
                    <h2>Csoport létrehozása</h2>
                    <form class="p-5" action="{{ route('create_group') }}" method="POST">
                        @csrf

                        <label class="form-label" for="group_name">Csoport neve</label>
                        <input type="hidden" name="group_id" value="{{ $allgroups->last()->id+1 }}">
                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Csoport neve">
                        <input class="btn btn-primary mt-2" type="submit" value="Létrehozás">
                    </form>

                    <hr>
                    <h2>Csoportok kezelése</h2>
                    @forelse($groups as $group)
                    @if($group->group_owner == Auth::id())
                        <hr>
                    <h4>Csoport neve: {{ $group->group_name }}</h4>
                    <form class="p-5" action="{{ route('add_member') }}" method="POST">
                        @csrf

                        <div>
                            <input type="hidden" value="{{ $group->id }}" name="group_id">
                            <label class="form-label mt-2" for="user_id">Felhasználó hozzáadása</label>
                            <select id="user_id" class="form-control" name="user_id">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input class="btn btn-primary mt-2" type="submit" value="Hozzáadás">
                    </form>
                    @endif
                        @empty
                        <h4>Nincsenek csoportjaid!</h4>
                        <hr>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
