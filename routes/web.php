<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Guest route
Route::get('/', function () {
    if (Auth::user() != null){
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

//User routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
    //Todo routes
Route::get('/todo', [AuthenticatedUserController::class, 'index'])
    ->middleware(['auth'])->name('todo');
Route::post('/todo', [AuthenticatedUserController::class, 'store'])
    ->middleware(['auth'])->name('todo.store');
Route::post('/todo/delete/{id}', [AuthenticatedUserController::class, 'destroy'])
    ->middleware(['auth'])->name('todo_destroy');
    //Group routes
Route::get('/group', [AuthenticatedUserController::class, 'show_groups'])
    ->middleware(['auth'])->name('show_groups');
Route::post('/group/create', [AuthenticatedUserController::class, 'create_group'])
    ->middleware(['auth'])->name('create_group');
Route::post('group/add_member', [AuthenticatedUserController::class, 'add_member'])
    ->middleware(['auth'])->name('add_member');
    //Profile routes
Route::get('/edit_profile', [AuthenticatedUserController::class, 'edit_profile'])
    ->middleware(['auth'])->name('edit_profile');
Route::post('/edit_profile', [AuthenticatedUserController::class, 'store_profile'])
    ->middleware(['auth'])->name('store_profile');


//Admin routes
Route::get('/admin/edit_users', [AuthenticatedUserController::class, 'show_users'])
    ->middleware(['auth'])->name('show_users');
Route::post('/admin/edit_users/delete/{id}', [AuthenticatedUserController::class, 'delete_user'])
    ->middleware(['auth'])->name('delete_user');
Route::post('/admin/edit_users/promote/{id}', [AuthenticatedUserController::class, 'promote_user'])
    ->middleware(['auth'])->name('promote_user');
Route::post('/admin/edit_users/demote/{id}', [AuthenticatedUserController::class, 'demote_user'])
    ->middleware(['auth'])->name('demote_user');

require __DIR__.'/auth.php';
