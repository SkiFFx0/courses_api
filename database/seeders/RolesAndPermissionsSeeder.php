<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'assign roles']);

        // Course-related permissions (no "own" distinction)
        Permission::create(['name' => 'create courses']);
        Permission::create(['name' => 'edit courses']);
        Permission::create(['name' => 'delete courses']);
        Permission::create(['name' => 'view courses']);

        // Teacher-specific permissions
        Permission::create(['name' => 'manage students']); // Add/remove students
        Permission::create(['name' => 'grade submissions']);

        // Student-specific permissions
        Permission::create(['name' => 'enroll courses']);
        Permission::create(['name' => 'submit assignments']);

        // Comment-related permissions
        Permission::create(['name' => 'manage comments']);

        // Roles
        Role::create(['name' => 'guest']);

        $student = Role::create(['name' => 'student']);
        $student->givePermissionTo([
            'enroll courses', 'submit assignments', 'view courses', 'manage comments'
        ]);

        $teacher = Role::create(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'create courses', 'edit courses', 'delete courses',
            'manage students', 'grade submissions', 'manage comments'
        ]);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
