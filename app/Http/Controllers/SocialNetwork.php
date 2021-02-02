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
