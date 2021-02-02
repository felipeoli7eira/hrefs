<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auth extends Controller
{
    public function login(Request $request)
    {
        return response($request->all(), 200);
    }
}
