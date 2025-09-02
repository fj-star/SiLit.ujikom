<?php

namespace App\Models;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_treatment',
        'deskripsi',
        'harga',
        'diskon',
    ];
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'treatment_id');
    }

}

