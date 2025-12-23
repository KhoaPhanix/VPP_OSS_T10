<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin account
        User::create([
            'username' => 'admin',
            'email' => 'admin@vpp.com',
            'password' => Hash::make('admin123'),
            'full_name' => 'Administrator',
            'role' => 'admin',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Test customer accounts
        User::create([
            'username' => 'khachhang1',
            'email' => 'customer1@example.com',
            'password' => Hash::make('password'),
            'full_name' => 'Nguyễn Văn A',
            'gender' => 'male',
            'phone' => '0901234567',
            'address' => '123 Đường ABC, Quận 1, TP.HCM',
            'role' => 'customer',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'username' => 'khachhang2',
            'email' => 'customer2@example.com',
            'password' => Hash::make('password'),
            'full_name' => 'Trần Thị B',
            'gender' => 'female',
            'phone' => '0907654321',
            'address' => '456 Đường XYZ, Quận 2, TP.HCM',
            'role' => 'customer',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);
    }
}
