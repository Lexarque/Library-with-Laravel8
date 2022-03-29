<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException as ExceptionsJWTExceptions;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;


class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $role = DB::table('users')->where('email', $credentials)->value('role');

        try {
            if(! $token = FacadesJWTAuth::attempt($credentials))
            {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (ExceptionsJWTExceptions $e) 
        {
            return response()->json(['error' => 'could_not_create_token', 500]);
        }
        return response()->json(['token' => $token, 'data'=> $credentials, 'role' => $role,'status' => 1], 201);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:12'
        ]);
        
        if($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => $request->get('role')
        ]);
        
        $token = FacadesJWTAuth::fromUser($user);
        return response()->json([compact('user', 'token'), 'status' => 1], 201);
    
    }

    public function getAuthenticatedUser()
    {
        try
        {
            if (! $user = FacadesJWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return response()->json(['token_expired'], 401);
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return response()->json(['token_invalid'], 401);
        }
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e)
        {
            return response()->json(['token_absent'], 401);
        }
        return response()->json(['data' => compact('user'), 'status' => 1]);
    }

    
}
