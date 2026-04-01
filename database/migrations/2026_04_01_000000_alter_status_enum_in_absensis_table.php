<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mengubah ENUM agar support 'terlambat'
        DB::statement("ALTER TABLE absensis MODIFY status ENUM('hadir', 'izin', 'sakit', 'alpha', 'terlambat') DEFAULT 'hadir'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan ENUM (Hanya akan berhasil jika tidak ada data 'terlambat' di database)
        DB::statement("ALTER TABLE absensis MODIFY status ENUM('hadir', 'izin', 'sakit', 'alpha') DEFAULT 'hadir'");
    }
};
