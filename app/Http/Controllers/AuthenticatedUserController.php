<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoCreatePostRequest;
use App\Models\Group;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        $todos = $user->todos->sortBy('created_at')->sortBy('priority')->sortBy('group_id', false);


        //echo '<pre>' , print_r($group_todos) , '</pre>';

        return view('todo', [
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
    public function destroy($id)
    {
        //
    }
}
