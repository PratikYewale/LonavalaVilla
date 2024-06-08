<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = [
            'success' => false,
            'message' => 'Unauthenticated User. Please Login',
        ];
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $response['message'] = 'Token is Invalid';
                return response()->json($response, 403, [], JSON_NUMERIC_CHECK);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $response['message'] = 'Token is Expired';
                return response()->json($response, 403, [], JSON_NUMERIC_CHECK);
            } else {
                $response['message'] = 'Authorization Token not found';
                return response()->json($response, 401, [], JSON_NUMERIC_CHECK);
            }
        }
        return $next($request);
    }
}
