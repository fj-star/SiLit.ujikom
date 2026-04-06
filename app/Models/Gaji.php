<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $fillable = ['karyawan_id', 'created_by', 'jumlah_gaji', 'bulan_tahun', 'tanggal_bayar', 'keterangan'];

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
