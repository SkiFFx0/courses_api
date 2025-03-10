<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
        ]);

        $admin->assignRole('admin');

        $teacher = User::query()->create([
            'first_name' => 'teacher',
            'last_name' => 'teacher',
            'username' => 'teacher',
            'password' => Hash::make('12345678'),
        ]);

        $teacher->assignRole('teacher');

        $student = User::query()->create([
            'first_name' => 'student',
            'last_name' => 'student',
            'username' => 'student',
            'password' => Hash::make('12345678'),
        ]);

        $student->assignRole('student');

        $guest = User::query()->create([
            'first_name' => 'guest',
            'last_name' => 'guest',
            'username' => 'guest',
            'password' => Hash::make('12345678'),
        ]);

        $guest->assignRole('guest');
    }
}
