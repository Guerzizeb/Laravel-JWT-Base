<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthenticateController extends Controller {

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                $response = [
                    'code' => 422,
                    'status' => 'error',
                    'data' => [],
                    'message' => 'invalid_credentials'
                ];
                return response()->json($response, $response['code']);
            }
        } catch (JWTException $e) {
            $response = [
                'code' => 500,
                'status' => 'error',
                'data' => [],
                'message' => 'could_not_create_token'
            ];
            return response()->json($response, $response['code']);
        }

        $response = [
            'code' => 200,
            'status' => 'error',
            'token' => $token,
            'message' => 'Login success'
        ];

        return response()->json($response, $response['code']);
    }

}
