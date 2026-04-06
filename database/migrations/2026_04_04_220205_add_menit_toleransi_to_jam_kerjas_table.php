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
        Schema::table('jam_kerjas', function (Blueprint $table) {
            $table->integer('menit_toleransi')->default(0)->after('jam_pulang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jam_kerjas', function (Blueprint $table) {
            $table->dropColumn('menit_toleransi');
        });
    }
};
