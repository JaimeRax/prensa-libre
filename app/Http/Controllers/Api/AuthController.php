<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, auth('api')->user());
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);
        return response()->json(['message' => 'logged out']);
    }

    private function respondWithToken($token, $user, $status = 200)
    {
        $ttlMinutes = JWTAuth::factory()->getTTL();
        return response()->json([
            'token'       => $token,
            'token_type'  => 'bearer',
            'expires_in'  => $ttlMinutes * 60,
            'user'        => $user,
        ], $status);
    }
}
