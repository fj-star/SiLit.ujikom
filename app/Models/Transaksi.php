<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
     protected $fillable = [
        'pelanggan_id',
        'layanan_id',
        'treatment_id',
        'berat',
        'total_harga',
        'metode_pembayaran',
        'status',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}

