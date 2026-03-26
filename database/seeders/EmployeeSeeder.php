<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            'Galuh Zakiyatun',
            'Dimas Farid Awaludin',
            'Desi Halisna Ariani',
            'Baiq Nana Erlina',
            'Misdan',
            'Lalu Taufiq Wijaya',
            'Rossie Masulana Septian',
            'Raden Kukuh Ahadi Ridho',
            'Hendra Hadi Pratama',
            'Wahyu Septia Candrika',
            'Muhammad Azlul',
            'Iwan Vani',
            'Aditya Marandika Rachman',
            'Andri Pratama',
        ];

        foreach ($employees as $index => $fullName) {
            $firstName = explode(' ', $fullName)[0];
            $email = Str::lower($firstName) . '@nustech.com';
            
            // Avoid email collisions by appending name length if necessary
            if (User::where('email', $email)->exists()) {
                $email = Str::lower($firstName) . strlen($fullName) . '@nustech.com';
            }

            // Ensure unique NIK
            $nik = 'NST' . str_pad($index + 1, 5, '0', STR_PAD_LEFT);
            while (User::where('nik', $nik)->exists()) {
                 $nik = 'NST' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            }

            User::updateOrCreate(
                ['name' => $fullName],
                [
                    'email' => $email,
                    'password' => Hash::make('Masuk123'),
                    'role' => 'employee',
                    'nik' => $nik,
                    'department' => 'Field Team',
                ]
            );
        }
    }
}
