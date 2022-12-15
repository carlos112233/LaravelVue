<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
});

Auth::routes();
//Users
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users_list', [App\Http\Controllers\HomeController::class, 'list'])->name('users_list');
Route::post('/create_user', [App\Http\Controllers\HomeController::class, 'store'])->name('create_user');
Route::put('/edit_user/{idUser}', [App\Http\Controllers\HomeController::class, 'update'])->name('edit_user');
Route::delete('/delete_user/{idUser}', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete_user');

//chat View
Route::get('/chat',  [App\Http\Controllers\ChatController::class, 'index'])->name('chat');



//chat Methods
Route::get('/chat/rooms', [App\Http\Controllers\ChatController::class, 'rooms'])->name('rooms');
Route::get('/chat/rooms/{roomId}/messages', [App\Http\Controllers\ChatController::class, 'message'])->name('message');
Route::post('/chat/rooms/{roomId}/message', [App\Http\Controllers\ChatController::class, 'newMessage'])->name('newmessage');
