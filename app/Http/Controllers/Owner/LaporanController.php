<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default tanggal: Awal bulan ini sampai hari ini
        $from = $request->get('from', Carbon::now()->startOfMonth()->toDateString());
        $to   = $request->get('to', Carbon::now()->toDateString());

        // Eager Loading 'pelanggan' dan 'user' agar nama tidak hilang
        $query = Transaksi::with(['pelanggan', 'user', 'layanan']);

        // Filter: Hanya transaksi yang sudah bayar (Paid) agar sama dengan Dashboard
        $query->where('payment_status', 'paid');

        if ($from && $to) {
            $query->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59',
            ]);
        }

        $transaksis = $query->latest()->get();

        return view('pages.owner.laporan', [
            'transaksis' => $transaksis,
            'total'      => $transaksis->sum('total_harga'),
            'from'       => $from,
            'to'         => $to,
        ]);
    }

    public function pdf(Request $request)
    {
        $from = $request->get('from');
        $to   = $request->get('to');

        $query = Transaksi::with(['pelanggan', 'user', 'layanan'])->where('payment_status', 'paid');

        if ($from && $to) {
            $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
        }

        $transaksis = $query->get();

        $pdf = Pdf::loadView('pages.owner.pdf', [
            'transaksis' => $transaksis,
            'total'      => $transaksis->sum('total_harga'),
            'from'       => $from,
            'to'         => $to,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-instawash-' . $from . '.pdf');
    }

    public function exportCsv(Request $request)
    {
        $from = $request->get('from', Carbon::now()->startOfMonth()->toDateString());
        $to   = $request->get('to', Carbon::now()->toDateString());

        $query = Transaksi::with(['pelanggan', 'user', 'layanan'])->where('payment_status', 'paid');

        if ($from && $to) {
            $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
        }

        $transaksis = $query->latest()->get();

        $filename = 'laporan-instawash-' . $from . '-sd-' . $to . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transaksis) {
            $file = fopen('php://output', 'w');
            // BOM untuk Excel agar UTF-8 terbaca dengan benar
            fputs($file, "\xEF\xBB\xBF");
            // Header kolom
            fputcsv($file, ['No', 'Tanggal', 'Order ID', 'Pelanggan', 'Layanan', 'Status', 'Total Harga']);
            foreach ($transaksis as $i => $t) {
                fputcsv($file, [
                    $i + 1,
                    $t->created_at->format('d/m/Y'),
                    $t->order_id,
                    $t->pelanggan->name ?? $t->user->name ?? 'Guest',
                    $t->layanan->nama_layanan ?? '-',
                    strtoupper($t->status),
                    $t->total_harga,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}