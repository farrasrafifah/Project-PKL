<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminRedaksiSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bukudigital.test'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('admin123'), // ganti sesuai mau kamu
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'redaksi@bukudigital.test'],
            [
                'name' => 'Tim Redaksi',
                'password' => Hash::make('redaksi123'), // ganti sesuai mau kamu
                'role' => 'redaksi',
            ]
        );
    }
}
