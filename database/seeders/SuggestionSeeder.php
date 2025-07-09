<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Suggestion; // Pastikan Model diimpor
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Kita akan menggunakan ini untuk tanggal

class SuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menggunakan nama tabel dari model untuk truncate, ini lebih aman
        // Ganti 'suggestions' dengan nama tabel Anda jika berbeda
        DB::table('suggestions')->truncate();

        // Data Contoh 1
        Suggestion::create([
            'nama' => 'Budi Santoso',
            'npk' => '1902345',
            'line_bag' => 'Assembly Line 1',
            'tema' => 'Pengurangan Waktu Tunggu Mesin',
            'kondisi_semula_text' => 'Saat ini, mesin sering berhenti selama 5-10 menit saat pergantian material karena operator harus berjalan jauh untuk mengambil material baru.', // Sesuai Model
            'perbaikan_text' => 'Menempatkan rak material cadangan di samping setiap mesin. Rak ini akan diisi ulang oleh tim logistik setiap pagi.', // Sesuai Model
            'tujuan_perbaikan' => 'Mengurangi waktu henti mesin (downtime) dan meningkatkan efisiensi operator.',
            // Kolom gambar kita biarkan null
            'kondisi_semula_gambar' => null,
            'perbaikan_gambar' => null,
            'hasil_perbaikan_gambar' => null,
            // Kolom tambahan dari model Anda
            'nilai_ss' => null, // Atau bisa diisi 0 jika tipe datanya integer
            'dibuat_oleh' => 'Budi Santoso',
            'tanggal_pelaksanaan' => Carbon::now()->subDays(10), // Contoh tanggal 10 hari lalu
            'diperiksa_oleh' => null,
            'disetujui_oleh' => null,
        ]);

        // Data Contoh 2
        Suggestion::create([
            'nama' => 'Citra Lestari',
            'npk' => '2105678',
            'line_bag' => 'Quality Control',
            'tema' => 'Optimalisasi Proses Pengecekan Kualitas',
            'kondisi_semula_text' => 'Proses pengecekan produk akhir masih manual menggunakan checklist kertas, yang lambat dan rentan kesalahan pencatatan.', // Sesuai Model
            'perbaikan_text' => 'Mengembangkan aplikasi checklist digital sederhana yang bisa diakses melalui tablet di setiap stasiun QC.', // Sesuai Model
            'tujuan_perbaikan' => 'Mempercepat proses pencatatan, mengurangi penggunaan kertas, dan meminimalkan human error.',
            'kondisi_semula_gambar' => null,
            'perbaikan_gambar' => null,
            'hasil_perbaikan_gambar' => null,
            'nilai_ss' => null,
            'dibuat_oleh' => 'Citra Lestari',
            'tanggal_pelaksanaan' => Carbon::now()->subDays(5), // Contoh tanggal 5 hari lalu
            'diperiksa_oleh' => null,
            'disetujui_oleh' => null,
        ]);

        // Data Contoh 3
        Suggestion::create([
            'nama' => 'Agus Wijaya',
            'npk' => '1801122',
            'line_bag' => 'Warehouse',
            'tema' => 'Peningkatan Keamanan Area Gudang',
            'kondisi_semula_text' => 'Pencahayaan di lorong gudang bagian belakang sangat minim, sehingga menyulitkan operator forklift saat bekerja di malam hari dan berisiko kecelakaan.', // Sesuai Model
            'perbaikan_text' => 'Menambah 5 titik lampu LED hemat energi di sepanjang lorong gudang yang gelap.', // Sesuai Model
            'tujuan_perbaikan' => 'Meningkatkan visibilitas dan keselamatan kerja bagi tim gudang, terutama pada shift malam.',
            'kondisi_semula_gambar' => null,
            'perbaikan_gambar' => null,
            'hasil_perbaikan_gambar' => null,
            'nilai_ss' => null,
            'dibuat_oleh' => 'Agus Wijaya',
            'tanggal_pelaksanaan' => Carbon::now()->subDays(2), // Contoh tanggal 2 hari lalu
            'diperiksa_oleh' => null,
            'disetujui_oleh' => null,
        ]);
    }
}