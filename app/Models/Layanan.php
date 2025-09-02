<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory;
    protected $fillable = ['nama_layanan', 'deskripsi', 'harga'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'layanan_id');
    }
}
