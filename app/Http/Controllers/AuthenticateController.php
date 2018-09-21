<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthenticateController extends Controller
{
    private $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = $this->jwt->attempt($credentials)) {
                return $this->output(401, 'invalid_credentials');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->output(500, 'could_not_create_token');
        }
        // all good so return the token
        return $this->output(
            200,
            '登录成功',
            [
                'user' => $this->jwt->user(),
                'token' => $token
            ]
        );
    }

    public function user(Request $request)
    {
        return $this->output(
            200,
            '获取用户信息成功',
            [
                'user' => $request->user()
            ]
        );
    }
}
