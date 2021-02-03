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
                                'message' => 'Senha incorreta',
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
                            'message' => 'Usuário não encontrado para o e-mail informado',
                            'data'    => null
                        ],
    
                        200
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

                    200
                );
            }
        }
        else
        {
            $badRequest = [
                'error'   => true,
                'status'  => 400,
                'message' => 'Dados não infomados para autenticação! Informe e-mail e senha.',
                'data'    => null
            ];
            return response($badRequest, 400);
        }
    }
}
