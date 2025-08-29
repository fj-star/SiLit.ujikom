<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'user_id', 'tanggal_lahir', 'alamat', 'no_hp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
