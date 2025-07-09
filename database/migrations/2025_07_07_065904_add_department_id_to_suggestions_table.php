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
        Schema::table('suggestions', function (Blueprint $table) {
            // Menambahkan kolom department_id sebagai foreign key
            $table->foreignId('department_id')
                ->nullable() // Boleh kosong untuk sementara agar data lama tidak error
                ->constrained('departments') // Menghubungkan ke tabel 'departments'
                ->onDelete('set null') // Jika departemen dihapus, kolom ini jadi null
                ->after('line_bag'); // Posisi kolom setelah 'line_bag'
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suggestions', function (Blueprint $table) {
            //
        });
    }
};
