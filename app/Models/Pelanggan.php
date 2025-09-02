<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Transaksi;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ttl', 'alamat', 'no_hp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }
}
