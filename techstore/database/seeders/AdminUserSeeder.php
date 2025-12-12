<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo hoặc cập nhật admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Tạo hoặc cập nhật customer user
        User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Nguyễn Văn A',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
            ]
        );
    }
}

