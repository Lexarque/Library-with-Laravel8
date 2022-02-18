<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next, ...$role)
    {
            try
        {
            $user = FacadesJWTAuth::parseToken()->authenticate();
        }
        catch (Exception $e) 
        {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        if($user && in_array($user->type, $role)){
            return $next($request);
        }else{
            return response()->json(['message' => 'Invalid Role'], 404);
        }
    }
}
