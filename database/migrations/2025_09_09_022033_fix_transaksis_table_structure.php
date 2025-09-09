<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixTransaksisTableStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus foreign key constraint jika ada
            $table->dropForeign(['pelanggan_id']);
            
            // Hapus kolom pelanggan_id
            $table->dropColumn('pelanggan_id');
            
            // Tambahkan kolom user_id jika belum ada
            if (!Schema::hasColumn('transaksis', 'user_id')) {
                $table->foreignId('user_id')->constrained()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus foreign key user_id
            $table->dropForeign(['user_id']);
            
            // Tambahkan kolom pelanggan_id
            $table->unsignedBigInteger('pelanggan_id')->nullable()->after('id');
            $table->foreign('pelanggan_id')->references('id')->on('users');
        });
    }
}