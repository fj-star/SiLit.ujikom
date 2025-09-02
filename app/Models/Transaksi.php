<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\Treatment;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'layanan_id',
        'treatment_id',
        'berat',
        'total_harga',
        'metode_pembayaran',
        'status',
        'created_by',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id');
    }
}
