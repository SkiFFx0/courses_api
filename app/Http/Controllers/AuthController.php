<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $registerUserData = $request->validate([
            'first_name' => ["required", "string"],
            'last_name' => ["required", "string"],
            'middle_name' => ["nullable", "string"],
            'username' => ["nullable", "max:255", "unique:users,username", "required_without_all:email,phone"],
            'email' => ["nullable", "string", "email", "max:255", "unique:users,email", "required_without_all:username,phone"],
            'phone' => ["nullable", "string", "regex:/^\+?\d{1,14}$/", "unique:users,phone", "required_without_all:username,email"],
            'role' => ["nullable", "string", "in:student,teacher"],
            'password' => ["required", "string", "min:8"],
        ]);

        User::query()->create($registerUserData);

        return response()->json([
            'message' => 'User successfully registered'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ["required", "string"],
            'password' => ["required", "string", "min:8"],
        ]);

        $loginValue = ltrim($request->login, "+");
        $loginField = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' :
            (is_numeric($loginValue) ? 'phone' : 'username');

        $user = User::query()->where($loginField, $loginValue)->orWhere($loginField, $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'Invalid credentials'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
