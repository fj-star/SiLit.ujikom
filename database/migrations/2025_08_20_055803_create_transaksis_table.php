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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
        $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
        $table->foreignId('treatment_id')->nullable()->constrained('treatments')->onDelete('set null');
        $table->integer('berat'); // dalam kg
        $table->decimal('total_harga', 10, 2);
        $table->enum('metode_pembayaran', ['cash', 'transfer', 'ewallet'])->default('cash');
        $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
        $table->enum('created_by', ['admin', 'pelanggan']);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
