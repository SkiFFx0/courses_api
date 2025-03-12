<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $registerUserData = $request->validated();

        $user = User::query()->create($registerUserData);

        $user->assignRole('guest');

        return ApiResponse::success('User successfully registered', [
            "user" => $user
        ]);
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        $loginValue = ltrim($request->login, "+");
        $loginField = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' :
            (is_numeric($loginValue) ? 'phone' : 'username');

        $user = User::query()->where($loginField, $loginValue)->orWhere($loginField, $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return ApiResponse::error('Invalid login or password', null, 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success('Login successful', [
            "token" => $token,
            "token_type" => "Bearer",
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ApiResponse::success('Logged out successfully');
    }
}
