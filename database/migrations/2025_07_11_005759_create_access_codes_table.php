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
        Schema::create('access_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode akses, harus unik
            $table->string('description')->nullable(); // Keterangan, misal: "Untuk Karyawan Produksi"
            $table->boolean('is_active')->default(true); // Status untuk mengaktifkan/nonaktifkan kode
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_codes');
    }
};
