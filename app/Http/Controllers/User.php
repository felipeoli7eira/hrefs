<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;
use Exception;

class User extends Controller
{
    public function index()
    {
        $users = UserModel::all();

        return response()->json(
            [
                'error'   => false,
                'status'  => 200,
                'message' => 'lista de recursos',
                'data'    => $users,
            ],
            200
        );
    }

    public function find(int $id)
    {
        try
        {
            $find = UserModel::find($id);

            return response()->json(
                [
                    'error'   => false,
                    'status'  => 200,
                    'message' => 'Busca realizada',
                    'data'    => $find
                ],
                200
            );
        }
        catch (Exception $exception)
        {
            return response()->json(
                [
                    'error'   => true,
                    'status'  => 400,
                    'message' => 'Erro na busca',
                    'data'    => $exception
                ],
                400
            );
        }
    }

    public function store(Request $request)
    {
        if ($request->has(['email', 'password']))
        {
            try
            {
                $user = UserModel::create(
                    [
                        'fullname' => $request->input('fullname', 'null'),
                        'username' => $request->input('username', 'null'),
                        'photo'    => $request->input('photo', 'null'),
                        'bio'      => $request->input('bio', 'null'),
                        'email'    => $request->input('email'),
                        'password' => Hash::make(
                            $request->input('password')
                        ), // Hash::check('plain-text', $hashedPassword)
                    ]
                );
        
                return response()->json(
                    [
                        'error'   => false,
                        'status'  => 201,
                        'message' => 'registro efetuado',
                        'data'    => $user->id
                    ],
                    201
                );
            }
            catch (\Exception $exception)
            {
                return response()->json(
                    [
                        'error'   => true,
                        'status'  => 400,
                        'message' => 'erro ao registrar',
                        'data'    => (int) $exception->getCode()
                    ],
                    400
                );
            }
        }
        else
        {
            return response()->json(
                [
                    'error'   => true,
                    'status'  => 400,
                    'message' => 'Dados insuficientes para registro! Informe ao menos um email e senha.',
                    'data'    => null
                ],
                400
            );
        }
    }

    public function update(Request $request, int $paramID)
    {
        try
        {
            $update = UserModel::where('id', $paramID)->update($request->all());

            return response()->json(
                [
                    'error'   => false,
                    'status'  => 200,
                    'message' => 'Operação concluída',
                    'data'    => $update,
                ],
                200
            );
        }
        catch (\Exception $exception)
        {
            return response()->json(
                [
                    'error'   => true,
                    'status'  => 500,
                    'message' => 'Ops! algo deu errado',
                    'data'    => $exception,
                ],
                500
            );
        }
    }

    public function delete(int $id)
    {
        try
        {
            $delete = UserModel::where('id', $id)->delete();

            return response()->json(
                [
                    'error' => false,
                    'status' => 200,
                    'message' => 'Operação concluída',
                    'data' => $delete
                ],
                200
            );
        }
        catch (\Exception $exception)
        {
            return response()->json(
                [
                    'error' => true,
                    'status' => 500,
                    'message' => 'Operação concluída',
                    'data' => $delete
                ],
                500
            );
        }
    }
}
