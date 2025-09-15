<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'layanan', 'treatment']);
        
        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }
        
        // Filter berdasarkan bulan dan tahun
        if ($request->has('bulan') && $request->bulan != '') {
            $bulan = $request->bulan;
            $tahun = $request->has('tahun') ? $request->tahun : date('Y');
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
        }
        
        $laporan = $query->latest()->get();
        
        // Hitung total pendapatan
        $totalPendapatan = $laporan->sum('total_harga');
        
        return view('pages.admin.laporan.index', compact('laporan', 'totalPendapatan'));
    }
    
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        
        return redirect()->route('admin.laporan.index')
            ->with('success', 'Data laporan berhasil dihapus');
    }
    
    public function cetakPdf(Request $request)
    {
        $query = Transaksi::with(['user', 'layanan', 'treatment']);
        
        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }
        
        // Filter berdasarkan bulan dan tahun
        if ($request->has('bulan') && $request->bulan != '') {
            $bulan = $request->bulan;
            $tahun = $request->has('tahun') ? $request->tahun : date('Y');
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
        }
        
        $laporan = $query->latest()->get();
        
        // Hitung total pendapatan
        $totalPendapatan = $laporan->sum('total_harga');
        
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('laporan', 'totalPendapatan'));
        
        // Nama file PDF
        $filename = 'laporan-transaksi-';
        if ($request->has('start_date') && $request->has('end_date')) {
            $filename .= $request->start_date . '-s.d-' . $request->end_date;
        } elseif ($request->has('bulan') && $request->bulan != '') {
            $tahun = $request->has('tahun') ? $request->tahun : date('Y');
            $filename .= Carbon::create()->month($request->bulan)->format('F') . '-' . $tahun;
        } else {
            $filename .= 'semua';
        }
        $filename .= '.pdf';
        
        return $pdf->download($filename);
    }
}