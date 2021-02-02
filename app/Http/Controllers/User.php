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
        if ($request->has(['email', 'password']))
        {
            try
            {
                $user = UserModel::create(
                    [
                        'profile_name'  => $request->input('profile_name'),
                        'user_name'     => $request->input('username'),
                        'photo'         => $request->input('photo'),
                        'bio'           => $request->input('bio'),
                        'phone'         => $request->input('phone'),
                        'whatsapp'      => $request->input('whatsapp'),
                        'email'         => $request->input('email'),
                        'password'      => Hash::make(
                            $request->input('password') # Hash::check('plain-text', $hashedPassword)
                        ),
                    ]
                );

                $success = [
                    'error'   => false,
                    'status'  => $this->httpStatus['Created'],
                    'message' => 'Created',
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
        
                return response($error, $this->httpStatus['InternalServerError']);
            }
        }
        else
        {

            $badRequest = [
                'error'   => true,
                'status'  => $this->httpStatus['BadRequest'],
                'message' => 'Dados insuficientes para registro! Informe ao menos um email e senha',
                'data'    => null
            ];

            return response($badRequest, $this->httpStatus['BadRequest']);
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
