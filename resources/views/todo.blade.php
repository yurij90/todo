<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div id="app">
                        <todo-table :user_id='{{ $user_id }}' :todos='@json($todos)'></todo-table>
                    </div>
                    {{-- <h2>Feladataid</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Létrehozta</th>
                                <th>Csoport</th>
                                <th>Prioritás</th>
                                <th>Leírás</th>
                                <th>Hozzáadva</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($todos as $todo)
                            <tr>
                                <td>{{ $todo->user->name }}</td>
                                <td>{{ $todo->group->group_name ?? "Egyéni" }}</td>
                                <td>{{ $todo->priority }}</td>
                                <td>{{ $todo->description }}</td>
                                <td>{{ $todo->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    Nincsenek feladatai!
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table> --}}

                    <hr>
                    <h2>Feladat létrehozása</h2>
                    <form class="p-5" action="{{ route('todo.store') }}" method="POST">
                        @csrf

                        Prioritás
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="todo_priority" id="todo_prio_1" value="1" checked>
                            <label class="form-check-label" for="todo_prio_1">1</label>
                        </div>
                        @for($i = 2; $i < 6; $i++)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="todo_priority" id="todo_prio_{{ $i }}" value="{{ $i }}">
                            <label class="form-check-label" for="todo_prio_{{ $i }}">{{ $i }}</label>
                        </div>
                        @endfor
                        <div>
                        <label class="form-label mt-2" for="todo_select">Csoport</label>
                        <select id="todo_select" class="form-control" name="todo_group_id">
                        <option value="0">Egyéni</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                        @endforeach
                        </select>
                        </div>
                        <label class="form-label mt-2" for="todo_textarea">Leírás</label>
                        <textarea rows="3" id="todo_textarea" class="form-control" name="todo_description"></textarea>
                        <input class="btn btn-primary mt-2" type="submit" value="Létrehozás">
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
