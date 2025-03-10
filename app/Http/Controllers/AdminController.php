<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'string', 'in:guest,student,teacher'],
        ]);

        $role = $request->input('role');

        if (!Role::query()->where('name', $role)->exists())
        {
            return response()->json([
                'message' => 'Role does not exist'
            ], 422);
        }

        $user->syncRoles([$role]);

        return response()->json([
            'message' => 'Role assigned successfully'
        ]);
    }

    public function destroyUser(User $user)
    {
        if (auth()->user()->id === $user->id)
        {
            return response()->json([
                'message' => 'You cannot delete yourself'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'User successfully deleted'
        ]);
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Course successfully deleted'
        ]);
    }
}
