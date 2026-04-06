<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            ['nama_layanan' => 'cuci biasa', 'harga' => 5000, 'deskripsi' => 'Pencucian pakaian sehari-hari secara reguler'],
            ['nama_layanan' => 'cuci regular', 'harga' => 6000, 'deskripsi' => 'Pencucian pakaian plus setrika rapi'],
            ['nama_layanan' => 'cuci express', 'harga' => 10000, 'deskripsi' => 'Pencucian kilat 1 hari selesai'],
            ['nama_layanan' => 'setrika saja', 'harga' => 4000, 'deskripsi' => 'Hanya jasa setrika pakaian'],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}
