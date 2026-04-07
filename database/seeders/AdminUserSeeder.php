<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name'     => 'Admin',
            'no_hp'    => '0239201392',
            'ttl'      => '2007-03-10',
            'alamat'   => 'cianjur',
            'password' => Hash::make('12345678'),
            'role'     => 'admin',
        ]);

        User::firstOrCreate(['email' => 'owner@gmail.com'], [
            'name'     => 'Owner',
            'no_hp'    => '023920138',
            'ttl'      => '2007-03-10',
            'alamat'   => 'cianjur',
            'password' => Hash::make('12345678'),
            'role'     => 'owner',
        ]);

        User::firstOrCreate(['email' => 'karyawan@gmail.com'], [
            'name'     => 'Karyawan',
            'no_hp'    => '023920137',
            'ttl'      => '2007-03-10',
            'alamat'   => 'cianjur',
            'password' => Hash::make('12345678'),
            'role'     => 'karyawan',
        ]);
    }

}
