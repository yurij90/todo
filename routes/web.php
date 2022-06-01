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

Route::get('/', function () {
    if (Auth::user() != null){
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/todo', [AuthenticatedUserController::class, 'index'])
    ->middleware(['auth'])->name('todo');
Route::post('/todo', [AuthenticatedUserController::class, 'store'])
    ->middleware(['auth'])->name('todo.store');
Route::get('edit_profile', [AuthenticatedUserController::class, 'edit_profile'])
    ->middleware(['auth'])->name('edit_profile');
Route::post('edit_profile', [AuthenticatedUserController::class, 'store_profile'])
    ->middleware(['auth'])->name('store_profile');

require __DIR__.'/auth.php';
