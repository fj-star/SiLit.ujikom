<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Fazril',
            'email' => 'admin@gmail.com',
            'no_hp' => '0239201392',
            'ttl' => '10-03-2007',
            'alamat'=>'cianjur',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);
        User::create([
        'name' => 'Boss deng',
        'email' => 'owner@gmail.com',
        'no_hp' => '023920138',
        'ttl' => '10-03-2007',
        'alamat'=>'cianjur',
        'password' => Hash::make('12345678'),
        'role' => 'owner'
    ]);

    User::create([
        'name' => 'Karyawan',
        'email' => 'karyawan@gmail.com',
        'no_hp' => '023920137',
        'ttl' => '10-03-2007',
        'alamat'=>'cianjur',
        'password' => Hash::make('12345678'),
        'role' => 'karyawan'
    ]);
    }

}
