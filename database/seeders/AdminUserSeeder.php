<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'adminsagar@school.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'phone' => '9876543210',
            'address' => 'School Admin Office',
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }
}