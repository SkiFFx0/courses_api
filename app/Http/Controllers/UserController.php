<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ["nullable", "string"],
            'last_name' => ["nullable", "string"],
            'middle_name' => ["nullable", "string"],
            'username' => ["nullable", "max:255", "unique:users,username,{$request->user()->id}"],
            'email' => ["nullable", "string", "email", "max:255", "unique:users,email,{$request->user()->id}"],
            'phone' => ["nullable", "string", "regex:/^\+?\d{1,14}$/", "unique:users,phone,{$request->user()->id}"],
        ]);

        $data = array_filter($request->only(['first_name', 'last_name', 'middle_name', 'username', 'email', 'phone']));
        $request->user()->update($data);

        return response()->json([
            'message' => 'User information successfully updated'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => ["required", "string", "min:8"],
            'password' => ["required", "string", "min:8"],
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password))
        {
            return response()->json([
                'message' => 'The old password is incorrect'
            ]);
        }

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'User password successfully updated'
        ]);
    }
}
