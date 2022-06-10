<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoCreatePostRequest;
use App\Http\Requests\TodoDestroyPostRequest;
use App\Http\Requests\UserUpdatePostRequest;
use App\Models\Group;
use App\Models\Todo;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = Auth::id();
        $groups = $user->groups->sortBy('group_name');
        $user_todos = $user->todos;
        foreach($groups as $group){
            $todos = Todo::where('group_id', $group->id)->get();
            foreach($todos as $todo){
                $user_todos[] = $todo;
            }



        }
        $todos = $user_todos;

        //$todos = $user_todos->merge($group_todos);

        //echo $group_todos;


        //echo '<pre>' , print_r($user_groups_todos) , '</pre>';

        return view('todo', [
            'user_id' => $user_id,
            'todos' => $todos,
            'groups' => $groups,
        ]);
    }

    public function store(TodoCreatePostRequest $request)
    {
        $todo = new Todo;
        $todo->user_id = Auth::id();
        $todo->group_id = $request->todo_group_id;
        $todo->priority = $request->todo_priority;
        $todo->status = 'unsolved';
        $todo->description = $request->todo_description;
        $todo->save();
        return redirect()->route('todo');
    }

    public function destroy(TodoDestroyPostRequest $request)
    {
        $user_id = Auth::id();
        $todo = Todo::find($request->id);
        if ($user_id == $todo->user_id){
            Todo::destroy($request->id);
            return redirect()->route('todo');
        }
        else abort(403);
    }

    public function edit_profile()
    {
        $user = Auth::user();

        return view('edit', [
            'user' => $user,
        ]);
    }

    public function store_profile(UserUpdatePostRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('dashboard');
    }

    public function groups()
    {
        $groups = Group::all("id", "group_name");

        echo $groups;
    }

    public function users()
    {
        $users = User::all("id", "name");

        echo $users;
    }

    public function status(Request $request)
    {
        $todo = Todo::find($request->status_id);
        switch ($todo->status){
            case "unsolved":
                $todo->status = "in_progress";
                break;
            case "in_progress":
                $todo->status = "solved";
                break;
            case "solved":
                $todo->status = "in_progress";
        }
        $todo->save();
        return $todo->status;
    }

    public function show_users()
    {
        if(Auth::user()->role == "admin")
        {
            $users = User::all();

            return view('user', [
                'users' => $users,
            ]);

        }
        abort(403);

    }

    public function delete_user(Request $request)
    {
        if(Auth::user()->role == "admin")
        {
            User::destroy($request->id);
            return redirect()->route('show_users');
        }
        abort(403);

    }

    public function promote_user(Request $request)
    {
        if(Auth::user()->role == "admin")
        {
            $user = User::find($request->id);
            $user->role = "admin";
            $user->save();
            return redirect()->route('show_users');
        }
        abort(403);
    }

    public function demote_user(Request $request)
    {
        if(Auth::user()->role == "admin")
        {
            $user = User::find($request->id);
            $user->role = "user";
            $user->save();
            return redirect()->route('show_users');
        }
        abort(403);
    }

    public function show_groups()
    {
        $user = Auth::user();
        $groups = $user->groups->sortBy('group_name');
        $allgroups = Group::all();
        $users = User::all('id', 'name')->getDictionary();

        //echo '<pre>' , print_r($groups) , '</pre>';

        return view('group', [
            'groups' => $groups,
            'allgroups' => $allgroups,
            'users' => $users,
        ]);
    }
    public function create_group(Request $request)
    {
        $group = new Group;
        $group->group_name = $request->group_name;
        $group->group_owner = Auth::id();
        $group->save();

        $user_group = new UserGroup;
        $user_group->user_id = Auth::id();
        $user_group->group_id = $request->group_id;
        $user_group->save();

        return redirect()->route('show_groups');
    }
    public function add_member(Request $request)
    {
        $user_group = new UserGroup;
        $user_group->user_id = $request->user_id;
        $user_group->group_id = $request->group_id;
        $user_group->save();

        return redirect()->route('show_groups');
    }
}
