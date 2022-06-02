<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoCreatePostRequest;
use App\Http\Requests\TodoDestroyPostRequest;
use App\Http\Requests\UserUpdatePostRequest;
use App\Models\Group;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = Auth::id();
        $groups = $user->groups->sortBy('group_name');
        $user_todos = $user->todos;
        $group_todos = array();
        foreach($groups as $group){
            $group_id = $group->id;
            $group_todos = Todo::where('group_id', '=', $group_id)->get();
        }
            $todos = $user_todos->merge($group_todos);


        //echo '<pre>' , print_r($user_groups_todos) , '</pre>';

        return view('todo', [
            'user_id' => $user_id,
            'todos' => $todos,
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoDestroyPostRequest $request)
    {
        Todo::destroy($request->id);
        return redirect()->route('todo');
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
}
