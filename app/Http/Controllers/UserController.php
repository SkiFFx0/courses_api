<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(UpdateRequest $request)
    {
        $request->validated();

        $data = array_filter($request->only(['first_name', 'last_name', 'middle_name', 'username', 'email', 'phone']));
        $request->user()->update($data);

        return ApiResponse::success('User information updated successfully', [
            'updated' => $data,
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request->validated();

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password))
        {
            return ApiResponse::error('Old password is incorrect');
        }

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return ApiResponse::success('Password updated successfully', [
            'user' => $user
        ]);
    }

    public function destroy(Request $request)
    {
        $request->user()->delete();

        return ApiResponse::success('User deleted successfully');
    }
}
