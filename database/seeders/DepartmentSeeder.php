<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department; // <-- Import model Department

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel terlebih dahulu untuk menghindari data duplikat
        Department::truncate();

        $departments = [
            ['nama_departemen' => 'PPIC'],
            ['nama_departemen' => 'Produksi Injeksi'],
            ['nama_departemen' => 'Produksi Painting'],
            ['nama_departemen' => 'Engineering'],
            ['nama_departemen' => 'Material Engineering & Painting'],
            ['nama_departemen' => 'Maintenance'],
            ['nama_departemen' => 'Double Seat'],
            ['nama_departemen' => 'Quality'],
            ['nama_departemen' => 'Marketing'],
            ['nama_departemen' => 'Purchasing & Vendor Management'],
            ['nama_departemen' => 'HRD & IT'],
            ['nama_departemen' => 'MR, MDEM, GA & IR'],
        ];

        // Masukkan setiap departemen ke dalam database
        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}