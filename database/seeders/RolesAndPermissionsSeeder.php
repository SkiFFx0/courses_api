<?php

namespace Database\Seeders;

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
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage roles']);

        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'manage students']);
        Permission::create(['name' => 'grade submissions']);

        Permission::create(['name' => 'enroll courses']);
        Permission::create(['name' => 'submit assignments']);

        Permission::create(['name' => 'manage comments']);

        Permission::create(['name' => 'view courses']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $teacher = Role::create(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'view courses', 'manage courses', 'manage students', 'grade submissions', 'manage comments'
        ]);

        $student = Role::create(['name' => 'student']);
        $student->givePermissionTo([
            'view courses', 'enroll courses', 'submit assignments', 'manage comments'
        ]);

        $guest = Role::create(['name' => 'guest']);
        $guest->givePermissionTo('view courses');
    }
}
