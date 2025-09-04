<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\Treatment;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['pelanggan.user', 'layanan', 'treatment'])
            ->latest()
            ->get();

        return view('pages.admin.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::with('user')->get();
        $layanans   = Layanan::all();
        $treatments = Treatment::all();

        return view('pages.admin.transaksi.create', compact('pelanggans', 'layanans', 'treatments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggans,id',
            'layanan_id'        => 'required|exists:layanans,id',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'berat'             => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|in:cash,transfer,ewallet',
            'status'            => 'required|in:pending,proses,selesai',
            'created_by'        => 'required|in:admin,pelanggan',
        ]);

        // Hitung total harga
        $validatedData['total_harga'] = $this->hitungTotalHarga(
            $validatedData['layanan_id'],
            $validatedData['treatment_id'] ?? null,
            $validatedData['berat']
        );

        // Tambah tanggal otomatis kalau kolom ada
        if (Schema::hasColumn('transaksis', 'tanggal')) {
            $validatedData['tanggal'] = now();
        }

        DB::transaction(function () use ($validatedData) {
            $transaksi = Transaksi::create($validatedData);

            if (class_exists(LogAktivitas::class)) {
                LogAktivitas::create([
                    'user_id'    => auth()->id(),
                    'aksi'       => 'Tambah Transaksi',
                    'keterangan' => 'Transaksi ID: ' . $transaksi->id,
                ]);
            }
        });

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaksi $transaksi)
    {
        $pelanggans = Pelanggan::with('user')->get();
        $layanans   = Layanan::all();
        $treatments = Treatment::all();

        return view('pages.admin.transaksi.edit', compact('transaksi', 'pelanggans', 'layanans', 'treatments'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $validatedData = $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggans,id',
            'layanan_id'        => 'required|exists:layanans,id',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'berat'             => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|in:cash,transfer,ewallet',
            'status'            => 'required|in:pending,proses,selesai',
            'created_by'        => 'required|in:admin,pelanggan',
        ]);

        $validatedData['total_harga'] = $this->hitungTotalHarga(
            $validatedData['layanan_id'],
            $validatedData['treatment_id'] ?? null,
            $validatedData['berat']
        );

        if (Schema::hasColumn('transaksis', 'tanggal')) {
            $validatedData['tanggal'] = now();
        }

        DB::transaction(function () use ($transaksi, $validatedData) {
            $transaksi->update($validatedData);

            if (class_exists(LogAktivitas::class)) {
                LogAktivitas::create([
                    'user_id'    => auth()->id(),
                    'aksi'       => 'Update Transaksi',
                    'keterangan' => 'Transaksi ID: ' . $transaksi->id,
                ]);
            }
        });

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        DB::transaction(function () use ($transaksi) {
            $transaksi->delete();

            if (class_exists(LogAktivitas::class)) {
                LogAktivitas::create([
                    'user_id'    => auth()->id(),
                    'aksi'       => 'Hapus Transaksi',
                    'keterangan' => 'Transaksi ID: ' . $transaksi->id,
                ]);
            }
        });

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
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

        // Diskon tambahan kalau >= 10kg dan total >= 100rb
        if ($total_harga >= 100000 && $berat >= 10) {
            $total_harga -= ($total_harga * 0.1);
        }

        return $total_harga;
    }
}
