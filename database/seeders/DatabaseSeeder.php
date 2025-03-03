<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('adminadmin'),
            'role' => 'admin',
        ]);
    }
}
