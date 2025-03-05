<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        $this->call([
            RolesAndPermissionsSeeder::class
        ]);

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
