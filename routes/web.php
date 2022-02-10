<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;

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
    return view('welcome');
})->name("root",);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//, 'role:admin'
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); 

// Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');//->middleware('auth:admin')

Route::get('/admin/sessions', [SessionController::class, 'index'])->name('sessions.index');//->middleware('auth:admin')

Route::group(['middleware' => 'auth'], function(){
    Route::resource(name: 'users', controller: \App\Http\Controllers\UserController::class);
});

Route::get('/admin/sessions', function () { 
    return view('admin.sessions.index');
})->middleware('auth:admin')->name('sessions.list');
