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
            // Sesuai permintaan Anda: kriteria setelah line_bag
            $table->json('kriteria')->nullable()->after('line_bag');

            // Sesuai permintaan Anda: is_new_idea setelah tema
            $table->boolean('is_new_idea')->default(true)->after('tema');
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
