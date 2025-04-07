<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\LoginRequest;
use App\Http\Requests\Website\RegisterRequest;
use App\Http\Resources\Website\UserResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = $request->register();
        $accessToken = $user->createToken($user->email)->plainTextToken;

        return response([
            'message' => __('users.auth.register'),
            'user' => new UserResource($user),
            'access_token' => $accessToken
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $request->login();
        $accessToken = $user->createToken($user->email)->plainTextToken;

        return response([
            'message' => __('users.auth.login'),
            'user' => new UserResource($user),
            'access_token' => $accessToken
        ]);
    }

    public function logout()
    {
        auth('api')->user()->currentAccessToken()->delete();
        return response([
            'message' => __('users.auth.logout')
        ]);
    }
}
