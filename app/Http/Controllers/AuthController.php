<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    

    public function login(LoginRequest $request)
    {

        $credentials = $request->only(['email', 'password']);


        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if ($request->remember_me) {
                JWTAuth::factory()->setTTL(null);
            }
        

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request) 
    {
        DB::table('users')->insert([
            'id_user' => Str::uuid(),
            'name' => request('name'),
            'email' => request('email'),
            'role' => request('role'),
            'password' => bcrypt(request('password')),
        ]);
        return response(['message' => 'User Registered'], 200);

    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }


}