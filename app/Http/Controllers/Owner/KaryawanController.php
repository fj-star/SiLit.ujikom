<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Gaji;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')
            ->withCount(['transaksis as total_transaksi'])
            ->get();
        return view('pages.owner.karyawan.index', compact('karyawans'));
    }

    public function show(User $karyawan)
    {
        $gajis = Gaji::where('karyawan_id', $karyawan->id)->latest()->get();
        return view('pages.owner.karyawan.show', compact('karyawan', 'gajis'));
    }
}
