<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Treatment;
use App\Models\LogAktivitas;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah pesanan
        $totalPemesanan = Transaksi::count();
        
        // Omzet bulan ini
        $omzetBulanIni = Transaksi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_harga');
            
        // Data pelanggan, layanan, treatment
        $pelangganCount = User::where('role', 'pelanggan')->count();
        $layananCount = Layanan::count();
        $treatmentCount = Treatment::count();
        
        // Log aktivitas hari ini
        $logHariIni = LogAktivitas::whereDate('created_at', Carbon::today())->count();
        
        // Ringkasan status pesanan
        $pesananPending = Transaksi::where('status', 'pending')->count();
        $pesananProses = Transaksi::where('status', 'proses')->count();
        $pesananSelesai = Transaksi::where('status', 'selesai')->count();
        $totalPesanan = max(1, $pesananPending + $pesananProses + $pesananSelesai); // hindari pembagian 0
        $pctPending = round(($pesananPending / $totalPesanan) * 100, 1);
        $pctProses = round(($pesananProses / $totalPesanan) * 100, 1);
        $pctSelesai = round(($pesananSelesai / $totalPesanan) * 100, 1);
        
        // Total omzet
        $totalOmzet = Transaksi::sum('total_harga');
        
        // Grafik pesanan per bulan (selalu 12 bulan penuh)
        $chartLabels = [];
        $chartData = [];
        foreach (range(1, 12) as $i) {
            $chartLabels[] = Carbon::create()->month($i)->translatedFormat('F');
            $chartData[] = Transaksi::whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->count();
        }
        
        // Transaksi terbaru - perbaikan relasi di sini
        $transaksiTerbaru = Transaksi::with(['user', 'layanan'])
            ->latest()
            ->take(5)
            ->get();
           
            
        return view('pages.admin.index', compact(
            'omzetBulanIni',
            'totalPemesanan',
            // 'userName',
            'pelangganCount',
            'layananCount',
            'treatmentCount',
            'logHariIni',
            'pesananPending',
            'pesananProses',
            'pesananSelesai',
            'pctPending',
            'pctProses',
            'pctSelesai',
            'totalOmzet',
            'chartLabels',
            'chartData',
            'transaksiTerbaru'
        ));
    }
}