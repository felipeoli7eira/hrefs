<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User;
use App\Http\Controllers\SocialNetwork;
use App\Http\Controllers\HyperLink;
use App\Http\Controllers\Auth;

Route::get('/users',        [User::class, 'index']);
Route::get('/user/{id}',    [User::class, 'find'])->whereNumber('id');
Route::post('/user',        [User::class, 'store']);
Route::put('/user/{id}',    [User::class, 'update'])->whereNumber('id');
Route::delete('/user/{id}', [User::class, 'delete'])->whereNumber('id');




Route::get('/user/socialnetworks',          [SocialNetwork::class, 'index']);
Route::get('/user/socialnetworks/{id}',     [SocialNetwork::class, 'find'])->whereNumber('id');
Route::post('/user/socialnetwork',          [SocialNetwork::class, 'create']);
Route::put('/user/socialnetwork/{id}',      [SocialNetwork::class, 'update'])->whereNumber('id');
Route::delete('/user/socialnetworks/{id}',  [SocialNetwork::class, 'delete'])->whereNumber('id');




Route::get('user/hyperlinks',      [HyperLink::class, 'index']);
Route::get('user/hyperlinks/{id}', [HyperLink::class, 'find'])->whereNumber('id');
Route::post('user/hyperlinks',     [HyperLink::class, 'create']);
Route::put('user/hyperlinks/{id}', [HyperLink::class, 'update'])->whereNumber('id');
Route::delete('user/hyperlinks/{id}', [HyperLink::class, 'delete'])->whereNumber('id');




Route::post('/login', [Auth::class, 'login']);




Route::fallback(function($request)
{
    return response(
        [
            'error' => true,
            'data' => $request,
            'message' => 'InternalServerError',
            'status' => 500
        ],

        500
    );
});
