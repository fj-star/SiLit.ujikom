<?php
namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Layanan;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();
        
        // Ambil semua transaksi milik user ini
        $transaksis = Transaksi::with(['layanan'])->where('user_id', $user->id)->get();
        
        // Hitung total transaksi
        $totalTransaksi = $transaksis->count();
        
        // Hitung total pengeluaran
        $totalPengeluaran = $transaksis->sum('total_harga');
        
        // Ambil transaksi terakhir
        $transaksiTerakhir = $transaksis->sortByDesc('created_at')->first();
        
        // Ambil layanan untuk ditampilkan di dashboard
        $layanans = Layanan::all();
        
        return view('pages.pelanggan.index', compact(
            'totalTransaksi', 
            'totalPengeluaran', 
            'transaksiTerakhir',
            'transaksis',
            'layanans'
        ));
    }
}