<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class RBACMiddleware {

    public function handle($request, Closure $next, $role) {
        $user = JWTAuth::parseToken()->authenticate();
        Log::info($user);
        if ($user->role !== $role) {
            $response = [
                'code' => 501,
                'status' => 'error',
                'message' => 'Access denied'
            ];

            return response()->json($response, $response['code']);
        }
        return $next($request);
    }

}
