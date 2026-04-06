<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pelanggan;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 10; $i++) {
            $email = 'pelanggan' . $i . '@gmail.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $faker->name,
                    'password' => Hash::make('12345678'),
                    'role'     => 'pelanggan',
                    'no_hp'    => '0812' . rand(10000000, 99999999),
                    'alamat'   => $faker->address,
                    'ttl'      => $faker->date('Y-m-d', '2005-01-01'),
                ]
            );

            Pelanggan::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'no_hp'  => $user->no_hp,
                    'alamat' => $user->alamat,
                    'ttl'    => $user->ttl,
                ]
            );
        }
    }
}
