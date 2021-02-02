<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    public function login(Request $request)
    {
        if ($request->has('email') && $request->has('password'))
        {
            try
            {
                // $userPassword = Hash::make();

                $user = User::where('email', $request->input('email'))->get()->first();

                if ($user)
                {
                    $passwordCheck = Hash::check($request->input('password'), $user->password);

                    if ($passwordCheck)
                    {
                        return response(
                            [
                                'error'   => false,
                                'status'  => 200,
                                'message' => 'login...',
                                'data'    => null
                            ],
        
                            200
                        );
                    }
                    else
                    {
                        return response(
                            [
                                'error'   => true,
                                'status'  => 200,
                                'message' => 'invalid password',
                                'data'    => null
                            ],

                            200
                        );
                    }
                }
                else
                {
                    return response(
                        [
                            'error'   => true,
                            'status'  => 404,
                            'message' => 'Registro não encontrado',
                            'data'    => null
                        ],
    
                        404
                    );
                }
            }
            catch (Exception $exception)
            {
                return response(
                    [
                        'error'   => true,
                        'status'  => 400,
                        'message' => $exception->getMessage(),
                        'data'    => null
                    ],

                    500
                );
            }
        }
        else
        {
            $badRequest = [
                'error'   => true,
                'status'  => 400,
                'message' => 'Email e senha não informados',
                'data'    => null
            ];
            return response($badRequest, 400);
        }
    }
}
