<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model
{
    protected $fillable = ['jam_masuk', 'jam_pulang', 'menit_toleransi'];
}
