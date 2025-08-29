<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class PelangganController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::where('pelanggan_id', Auth::id())->get();
        return view('pages.pelanggan.index', compact('transaksis'));
    }
}
