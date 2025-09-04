<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();
        $tanggalField = Schema::hasColumn('transaksis', 'tanggal') ? 'tanggal' : 'created_at';

        // filter range tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween($tanggalField, [$request->start_date, $request->end_date]);
        }

        // filter bulan & tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth($tanggalField, $request->bulan)
                  ->whereYear($tanggalField, $request->tahun);
        }

        $laporan = $query->latest($tanggalField)->get();

        return view('pages.admin.laporan.index', compact('laporan'));
    }

    

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Data laporan berhasil dihapus.');
    }
}
