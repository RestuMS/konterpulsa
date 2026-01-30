<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@konter.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // User Kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@konter.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'is_active' => true,
        ]);
        
        // User Non-Active (Example)
        User::create([
            'name' => 'Staff Resign',
            'email' => 'resign@konter.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'is_active' => false,
        ]);
    }
}
