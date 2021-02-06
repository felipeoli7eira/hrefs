<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;
use Exception;

class User extends Controller
{
    private $httpStatus = [
        'Ok'         => 200,
        'Created'    => 201,
        'BadRequest' => 400,
        'NotFound'   => 404,
        'InternalServerError' => 500
    ];

    public function index()
    {
        try
        {
            $resource = UserModel::all();

            $success = [
                'error'   => false,
                'status'  => $this->httpStatus['Ok'],
                'message' => 'selecteds',
                'data'    => $resource
            ];

            return response($success, $this->httpStatus['Ok']);
        }
        catch (Exception $exception)
        {
            $error = [
                'error'   => true,
                'status'  => $this->httpStatus['InternalServerError'],
                'message' => $exception->getMessage(),
                'data'    => null
            ];

            return response($error, $this->httpStatus['Ok']);
        }
    }

    public function find(int $id)
    {
        try
        {
            $resource = UserModel::find($id);

            $success = [
                'error'   => false,
                'status'  => $this->httpStatus['Ok'],
                'message' => 'selected by id',
                'data'    => $resource
            ];
    
            return response($success, $this->httpStatus['Ok']);
        }
        catch (Exception $exception)
        {
            $error = [
                'error'   => true,
                'status'  => $this->httpStatus['NotFound'],
                'message' => $exception->getMessage(),
                'data'    => $resource
            ];
    
            return response($error, $this->httpStatus['Ok']);
        }
    }

    public function store(Request $request) 
    {
        if (! $request->has(['email', 'password']))
        {
            $badRequest = [
                'error'   => true,
                'status'  => $this->httpStatus['BadRequest'],
                'message' => 'Dados insuficientes para registro! Informe ao menos um email e senha',
                'data'    => null
            ];

            return response($badRequest, $this->httpStatus['Ok']);
        }

        if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
        {
            $badRequest = [
                'error'   => true,
                'status'  => $this->httpStatus['BadRequest'],
                'message' => 'Formato inválido para o email',
                'data'    => null
            ];

            return response($badRequest, $this->httpStatus['Ok']);
        }

        if (UserModel::where('email', $request->input('email'))->count() )
        {
            $badRequest = [
                'error'   => true,
                'status'  => $this->httpStatus['Ok'],
                'message' => 'Uma conta foi encontrada com esse e-mail, tente recupera-la',
                'data'    => null
            ];

            return response($badRequest, $this->httpStatus['Ok']);
        }

        if (!mb_strlen($request->input('password')) >= 3 )
        {
            $badRequest = [
                'error'   => true,
                'status'  => $this->httpStatus['BadRequest'],
                'message' => 'Escolha uma senha maior ou igual a 3 caracteres! (' . mb_strlen($request->input('password')) . ' atualmente)',
                'data'    => null
            ];

            return response($badRequest, $this->httpStatus['Ok']);
        }

        try
        {
            $user = UserModel::create(
                [
                    'email'         => $request->input('email'),
                    'password'      => Hash::make(
                        $request->input('password') # Hash::check('plain-text', $hashedPassword)
                    ),
                ]
            );

            $success = [
                'error'   => false,
                'status'  => $this->httpStatus['Created'],
                'message' => 'Conta criada',
                'data'    => $user,
            ];
    
            return response($success, $this->httpStatus['Created']);
        }
        catch (Exception $exception)
        {
            $error = [
                'error'   => true,
                'status'  => $this->httpStatus['InternalServerError'],
                'message' => $exception->getMessage(),
                'data'    => null,
            ];
    
            return response($error, $this->httpStatus['Ok']);
        }
    }

    public function update(Request $request, int $id)
    {
        try
        {
            $update = UserModel::where('id', $id)->update($request->all());

            $success = [
                'error'   => false,
                'status'  => $this->httpStatus['Ok'],
                'message' => 'Updated',
                'data'    => $update,
            ];

            return response($success, $this->httpStatus['Ok']);
        }
        catch (Exception $exception)
        {
            $error = [
                'error'   => true,
                'status'  => $this->httpStatus['InternalServerError'],
                'message' => $exception->getMessage(),
                'data'    => null,
            ];

            return response($error, $this->httpStatus['InternalServerError']);
        }
    }

    public function delete(int $id)
    {
        try
        {
            $resource = UserModel::where('id', $id)->delete();

            $success = [
                'error'   => false,
                'status'  => $this->httpStatus['Ok'],
                'message' => 'Deleted',
                'data'    => null
            ];

            return response($success, $this->httpStatus['Ok']);
        }
        catch (Exception $exception)
        {
            $error = [
                'error'   => true,
                'status'  => $this->httpStatus['InternalServerError'],
                'message' => $exception->getMessage(),
                'data'    => null
            ];

            return response($error, $this->httpStatus['InternalServerError']);
        }
    }
}
