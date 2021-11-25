<?php

namespace Modules\Authentication\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
//use Illuminate\Http\Response;

/**
 * Trait AuthenticationService
 * @package Modules\Authentication\Services
 */
trait AuthenticationService
{
    /**
     * authFail
     * @var array $authFail
     */
    public array $authFail = [
        'message' => 'Wrong Email and Password commbination',
        'errors' => [
            'email' => ['Wrong Email and Password combination'],
            'password' => ['Wrong Email and Password combination']
        ]
    ];

    /**
     * $serverError
     * @var array $serverError
     */
    public array $serverError = [
        'message' => 'Whoops Something went wrong during authentication',
        'errors' => [
            'email' => ['Something went Wrong'],
            'password' => ['Something went Wrong']
            ]
        ];

    /**
     * @param $request 
     * @param string $provider
     * @return object
     * @throws Exception
     */
    public function login($request, string $provider = 'admins'):object
    {
        try{
            $client_id = config('passport.oauth_clients.' . $provider . '.client_id');
            $client_secret = config('passport.oauth_clients.' . $provider . '.client_secret');

            $passportRequest = Request::create('oauth/token', 'POST', [
                'grant_type' => 'password',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'username' => $request->email,
                'password' => $request->password,
            ]);

            $response = app()->handle($passportRequest);

            switch($response->status()){
                case 500://the server has encountered an error it does not know how to handl
                case 401://usually outputs unauthorised but is actually unauthenticated
                    return (object)['response' => $response->content(), 'status' => 500];
                    break;
                case 200://successful 
                    return (object)[
                        'response' => array_merge((array)json_decode($response->content()),['message' => 'Successs Login']),
                        'status' => $response->status()
                    ];
                    break;
                default:
                //Unprocessable Entity response status code, syntax of request is correct but it was unable to process contained instruction
                    return (object)['response' => $this->authFail, 'status' => 444];
            }
        } catch(Exception $exception){
            Log::error($exception->getMessage());
            return (object)['response' => $this->serverError, 'status' => 600];
        }
    }
}