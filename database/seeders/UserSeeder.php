<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'karyawan@demo.com'],
            [
                'name' => 'Karyawan Demo',
                'password' => Hash::make('password'),
                'nik' => '12345678',
                'department' => 'IT Support',
                'role' => 'employee'
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'nik' => '00000000',
                'department' => 'Management',
                'role' => 'admin'
            ]
        );
    }
}
