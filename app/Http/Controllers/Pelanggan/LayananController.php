<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        // Ambil data user login
        // $user = Auth::user();
         Layanan::all();
        return view('pages.pelanggan.layanan.index');
        // return view('pages.pelanggan.index', compact('user'));
    }
}