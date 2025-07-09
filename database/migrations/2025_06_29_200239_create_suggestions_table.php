<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();

            // Informasi Pengusul (lebih penting karena tanpa login)
            $table->string('nama')->nullable(); // Nama pengusul (wajib diisi di form)
            $table->string('npk')->nullable(); // NPK pengusul (wajib diisi di form)
            $table->string('line_bag')->nullable(); // Line/Bag
            $table->string('tema')->nullable(); // Tema dari suggestion

            // Bagian deskripsi masalah, perbaikan, dan tujuan (teks)
            $table->text('kondisi_semula_text')->nullable(); // Deskripsi Kondisi Semula (teks)
            $table->text('perbaikan_text')->nullable(); // Deskripsi Perbaikan yang diusulkan (teks)
            $table->text('tujuan_perbaikan')->nullable(); // Tujuan dari Perbaikan (teks)

            // Kolom untuk menyimpan path/URL gambar
            $table->string('kondisi_semula_gambar')->nullable(); // Path atau URL gambar Kondisi Semula
            $table->string('perbaikan_gambar')->nullable(); // Path atau URL gambar Perbaikan
            $table->string('hasil_perbaikan_gambar')->nullable(); // Path atau URL gambar Hasil Perbaikan (kemungkinan diisi admin)

            // Kolom Penilaian (diisi oleh admin/leader)
            $table->integer('nilai_ss')->nullable(); // Nilai Suggestion System yang diisi admin/leader

            // Bagian persetujuan dan pelaksanaan
            $table->string('dibuat_oleh')->nullable(); // Nama pembuat suggestion
            $table->date('tanggal_pelaksanaan')->nullable(); // Tanggal pelaksanaan suggestion
            $table->string('diperiksa_oleh')->nullable(); // Nama pemeriksa
            $table->string('disetujui_oleh')->nullable(); // Nama penyetuju

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};