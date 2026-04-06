<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment;

class TreatmentSeeder extends Seeder
{
    public function run(): void
    {
        $treatments = [
            ['nama_treatment' => 'Pewangi Premium Lavender', 'harga' => 2000, 'diskon' => 0, 'deskripsi' => 'Pewangi import wangi lavender tahan lama'],
            ['nama_treatment' => 'Penghilang Noda Membandel', 'harga' => 5000, 'diskon' => 0, 'deskripsi' => 'Cairan khusus untuk membersihkan noda membandel pada pakaian'],
        ];

        foreach ($treatments as $treatment) {
            Treatment::create($treatment);
        }
    }
}
