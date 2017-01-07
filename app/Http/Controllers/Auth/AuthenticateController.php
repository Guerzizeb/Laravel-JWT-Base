<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ResponseTrait;
use Illuminate\Http\Request;
use JWTAuth;
use League\Flysystem\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use App\User;

class AuthenticateController extends Controller {

    use ResponseTrait;

    public function register(Request $request) {

        try {
            $v = \Validator::make($request->all(), [
                'name' => "required|min:3|unique:users",
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);

            if($v->fails()) {
                throw new \Exception("ValidationException");
            }

            $user = User::create([
                'name' => $request->json('name'),
                'email' => $request->json('email'),
                'password' => bcrypt($request->json('password')),
            ]);

            return $this->createdResponse($user);

        } catch(\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }

    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

}
