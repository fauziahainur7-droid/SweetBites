<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun admin di tabel users
        $user = User::updateOrCreate(
            [
                'email' => 'admin@sweetbites.com'
            ],
            [
                'name' => 'Admin SweetBites',
                'password' => Hash::make('admin12345'),
                'no_hp' => '081234567890',
                'alamat' => 'SweetBites',
            ]
        );

        // Membuat data admin di tabel admins
        Admin::updateOrCreate(
            [
                'email' => 'admin@sweetbites.com'
            ],
            [
                'name' => 'Admin SweetBites',
                'password' => Hash::make('admin12345'),
            ]
        );
    }
}