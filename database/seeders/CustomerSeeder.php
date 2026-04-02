<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pelanggan;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => 'pelanggan' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'no_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'ttl' => $faker->date('d-m-Y', '2005-01-01'),
            ]);

            // Jika tabel pelanggan butuh duplikasi kolom ini, kita isi juga
            Pelanggan::create([
                'user_id' => $user->id,
                'no_hp' => $user->no_hp,
                'alamat' => $user->alamat,
                'ttl' => $user->ttl,
            ]);
        }
    }
}
