<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\UserSocialNetwork;

class SocialNetwork extends Controller
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
            $resource = UserSocialNetwork::all();

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

            return response($error, $this->httpStatus['InternalServerError']);
        }
    }

    public function create(Request $request)
    {
        if (
            $request->has('facebook') ||
            $request->has('instagram') ||
            $request->has('linkedin') &&
            $request->has('user_id')
        )
        {
            try
            {
                $resource = UserSocialNetwork::create($request->all());

                $success = [
                    'error'   => false,
                    'status'  => $this->httpStatus['Created'],
                    'message' => 'Created',
                    'data'    => null
                ];

                return response($success, $this->httpStatus['Created']);
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
        else
        {
            $badRequest = [
                'error'   => true,
                'status'  => $this->httpStatus['BadRequest'],
                'message' => 'Nenhum dado informado para cadastro. Informa ao menos uma rede social (instagram, facebook ou linkedin)',
                'data'    => null
            ];

            return response($badRequest, $this->httpStatus['BadRequest']);
        }
    }
}
