<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        $this->call([
            SuggestionSeeder::class,
            DepartmentSeeder::class,
            // Anda bisa menambahkan seeder lain di sini jika ada
        ]);
    }
}
