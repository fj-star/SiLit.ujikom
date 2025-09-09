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
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('pages.pelanggan.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $layanans = Layanan::all();
        $treatments = Treatment::all();
        return view('pages.pelanggan.transaksi.create', compact('layanans', 'treatments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'berat' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,transfer,ewallet',
        ]);

        // Tambahkan user_id dari user yang sedang login
        $validatedData['user_id'] = auth()->id();
        $validatedData['status'] = 'pending';
        $validatedData['total_harga'] = $this->hitungTotalHarga(
            $validatedData['layanan_id'],
            $validatedData['treatment_id'] ?? null,
            $validatedData['berat']
        );

        // Hanya tambahkan created_by jika kolomnya ada di tabel
        if (Schema::hasColumn('transaksis', 'created_by')) {
            $validatedData['created_by'] = 'pelanggan';
        }

        DB::transaction(function () use ($validatedData) {
            Transaksi::create($validatedData);
        });

        return redirect()->route('pelanggan.transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat.');
    }

    public function show(Transaksi $transaksi)
    {
        // Pastikan transaksi milik user yang login
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.pelanggan.transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        // Pastikan transaksi milik user yang login
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya transaksi dengan status pending yang bisa diedit
        if ($transaksi->status !== 'pending') {
            return redirect()->route('pelanggan.transaksi.index')
                ->with('error', 'Hanya transaksi dengan status pending yang bisa diedit.');
        }

        $layanans = Layanan::all();
        $treatments = Treatment::all();
        return view('pages.pelanggan.transaksi.edit', compact('transaksi', 'layanans', 'treatments'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        // Pastikan transaksi milik user yang login
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya transaksi dengan status pending yang bisa diupdate
        if ($transaksi->status !== 'pending') {
            return redirect()->route('pelanggan.transaksi.index')
                ->with('error', 'Hanya transaksi dengan status pending yang bisa diupdate.');
        }

        $validatedData = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'berat' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,transfer,ewallet',
        ]);

        $validatedData['total_harga'] = $this->hitungTotalHarga(
            $validatedData['layanan_id'],
            $validatedData['treatment_id'] ?? null,
            $validatedData['berat']
        );

        DB::transaction(function () use ($transaksi, $validatedData) {
            $transaksi->update($validatedData);
        });

        return redirect()->route('pelanggan.transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Pastikan transaksi milik user yang login
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya transaksi dengan status pending yang bisa dihapus
        if ($transaksi->status !== 'pending') {
            return redirect()->route('pelanggan.transaksi.index')
                ->with('error', 'Hanya transaksi dengan status pending yang bisa dihapus.');
        }

        DB::transaction(function () use ($transaksi) {
            $transaksi->delete();
        });

        return redirect()->route('pelanggan.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    private function hitungTotalHarga($layanan_id, $treatment_id, $berat)
    {
        $layanan = Layanan::findOrFail($layanan_id);
        $treatment = $treatment_id ? Treatment::findOrFail($treatment_id) : null;
        
        $total_harga = $layanan->harga * $berat;
        
        if ($treatment) {
            $total_harga += $treatment->harga;
            
            if ($treatment->diskon > 0) {
                $diskon = $total_harga * ($treatment->diskon / 100);
                $total_harga -= $diskon;
            }
        }
        
        if ($total_harga >= 100000 && $berat >= 10) {
            $total_harga -= ($total_harga * 0.1);
        }
        
        return round($total_harga, 2);
    }
}