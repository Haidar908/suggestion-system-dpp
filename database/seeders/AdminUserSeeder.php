<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan ini ada dan mengarah ke model User Anda
use Illuminate\Support\Facades\Hash; // Untuk mengenkripsi password

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Anda belum punya user dengan email ini untuk menghindari error unique
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('password_aman'), // Ganti dengan password yang kuat dan mudah Anda ingat
                'posisi' => 'Administrator', // Sesuaikan jika ada kolom 'posisi'
                'role' => 'admin', // Ini yang penting untuk peran admin
            ]);
        }
    }
}