<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User;

Route::get('/users', [User::class, 'index']);
Route::get('/user/{id}', [User::class, 'find'])->whereNumber('id');
Route::post('/user', [User::class, 'store']);
Route::put('/user/{id}', [User::class, 'update'])->whereNumber('id');
Route::delete('/user/{id}', [User::class, 'delete'])->whereNumber('id');
