<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['layanan', 'treatment'])
            ->where('pelanggan_id', auth()->user()->pelanggan->id)
            ->latest()
            ->get();

        return view('pages.pelanggan.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $layanans   = Layanan::all();
        $treatments = Treatment::all();

        return view('pages.pelanggan.transaksi.create', compact('layanans', 'treatments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'layanan_id'        => 'required|exists:layanans,id',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'berat'             => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|in:cash,transfer,ewallet',
        ]);

        $validatedData['pelanggan_id'] = auth()->user()->pelanggan->id;
        $validatedData['created_by']   = 'pelanggan';
        $validatedData['status']       = 'pending';

        // Hitung harga
        $validatedData['total_harga'] = $this->hitungTotalHarga(
            $validatedData['layanan_id'],
            $validatedData['treatment_id'] ?? null,
            $validatedData['berat']
        );

        if (Schema::hasColumn('transaksis', 'tanggal')) {
            $validatedData['tanggal'] = now();
        }

        DB::transaction(function () use ($validatedData) {
            Transaksi::create($validatedData);
        });

        return redirect()->route('pelanggan.transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat.');
    }

    private function hitungTotalHarga($layanan_id, $treatment_id, $berat)
    {
        $layanan   = Layanan::findOrFail($layanan_id);
        $treatment = $treatment_id ? Treatment::findOrFail($treatment_id) : null;

        $total_harga = $layanan->harga * $berat;

        if ($treatment) {
            $total_harga += $treatment->harga;
            if ($treatment->diskon > 0) {
                $total_harga -= ($total_harga * ($treatment->diskon / 100));
            }
        }

        if ($total_harga >= 100000 && $berat >= 10) {
            $total_harga -= ($total_harga * 0.1);
        }

        return $total_harga;
    }
}
