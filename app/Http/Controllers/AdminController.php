<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AssignRoleRequest;
use App\Models\ApiResponse;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function assignRole(AssignRoleRequest $request, User $user)
    {
        $request->validated();

        $role = $request->input('role');

        if (!Role::query()->where('name', $role)->exists())
        {
            return ApiResponse::error('Role does not exits', null, 422);
        }

        $user->syncRoles([$role]);

        return ApiResponse::success('Role assigned successfully', [
            'role' => $role,
            'user' => $user,
        ]);
    }

    public function destroyUser(User $user)
    {
        if (auth()->user()->id === $user->id)
        {
            return ApiResponse::error('You can not delete yourself', null, 403);
        }

        $user->delete();

        return ApiResponse::success('User deleted successfully');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();

        return ApiResponse::success('Course deleted successfully');
    }
}
