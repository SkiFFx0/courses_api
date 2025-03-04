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
        User::query()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('adminadmin'),
            'role' => 'admin',
        ]);
    }
}
