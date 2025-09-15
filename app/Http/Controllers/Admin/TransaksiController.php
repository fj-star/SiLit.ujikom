<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Treatment;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Mail\TransaksiSelesaiMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'layanan', 'treatment'])
            ->latest()
            ->get();

        return view('pages.admin.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $pelanggans = User::where('role', 'pelanggan')->get();
        $layanans   = Layanan::all();
        $treatments = Treatment::all();

        return view('pages.admin.transaksi.create', compact('pelanggans', 'layanans', 'treatments'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateData($request);

        $validatedData['total_harga'] = $this->hitungTotalHarga(
            $validatedData['layanan_id'],
            $validatedData['treatment_id'] ?? null,
            $validatedData['berat']
        );

        // ✅ simpan user_id kalau ada kolom created_by
        if (Schema::hasColumn('transaksis', 'created_by')) {
            $validatedData['created_by'] = auth()->id() ?? null;
        }
        if (Schema::hasColumn('transaksis', 'tanggal')) {
            $validatedData['tanggal'] = now();
        }

        DB::transaction(function () use ($validatedData) {
            $transaksi = Transaksi::create($validatedData);
            $this->logAktivitas('Tambah Transaksi', "Transaksi ID: {$transaksi->id}");
        });

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaksi $transaksi)
    {
        $pelanggans = User::where('role', 'pelanggan')->get();
        $layanans   = Layanan::all();
        $treatments = Treatment::all();

        return view('pages.admin.transaksi.edit', compact('transaksi', 'pelanggans', 'layanans', 'treatments'));
    }

    public function update(Request $request, Transaksi $transaksi)
{
    $validatedData = $this->validateData($request);

    $validatedData['total_harga'] = $this->hitungTotalHarga(
        $validatedData['layanan_id'],
        $validatedData['treatment_id'] ?? null,
        $validatedData['berat']
    );

    if (Schema::hasColumn('transaksis', 'created_by')) {
        $validatedData['created_by'] = auth()->user()->role ?? 'admin';
    }
    if (Schema::hasColumn('transaksis', 'tanggal')) {
        $validatedData['tanggal'] = now();
    }

    DB::transaction(function () use ($transaksi, $validatedData) {
        $transaksi->update($validatedData);

        $this->logAktivitas('Update Transaksi', "Transaksi ID: {$transaksi->id}");
    });

    // ✅ Panggil notifikasi setelah commit
    if ($validatedData['status'] === 'selesai') {
        DB::afterCommit(function () use ($transaksi) {
            $this->sendNotification($transaksi->fresh());
        });
    }

    return redirect()->route('admin.transaksi.index')
        ->with('success', 'Transaksi berhasil diperbarui.');
}


    public function destroy(Transaksi $transaksi)
    {
        DB::transaction(function () use ($transaksi) {
            $transaksi->delete();
            $this->logAktivitas('Hapus Transaksi', "Transaksi ID: {$transaksi->id}");
        });

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /* =======================
     * HELPER FUNCTIONS
     * =======================
     */

    private function validateData(Request $request)
    {
        return $request->validate([
            'user_id'           => 'required|exists:users,id',
            'layanan_id'        => 'required|exists:layanans,id',
            'treatment_id'      => 'nullable|exists:treatments,id',
            'berat'             => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,transfer,ewallet',
            'status'            => 'required|in:pending,proses,selesai',
        ]);
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

        return round($total_harga, 2);
    }

    private function sendNotification(Transaksi $transaksi)
    {
        $pelanggan = $transaksi->user;
        if (!$pelanggan) return;

        \Log::info("=== DEBUG: sendNotification jalan untuk Transaksi {$transaksi->id} ===");

        // ✅ Kirim Email
        try {
            Mail::to($pelanggan->email)->send(new TransaksiSelesaiMail($transaksi));
            \Log::info("Email terkirim ke {$pelanggan->email}");
        } catch (\Exception $e) {
            \Log::error("Gagal kirim email: " . $e->getMessage());
        }

        // ✅ Kirim WhatsApp via Fonnte
        if (!empty($pelanggan->no_hp)) {
            try {
                $res = Http::withHeaders([
                    'Authorization' => config('services.fonnte.token'),
                ])->post('https://api.fonnte.com/send', [
                    'target'  => $pelanggan->no_hp,
                    'message' => "Halo {$pelanggan->name}, pesanan laundry Anda dengan ID #{$transaksi->id} sudah selesai ✅",
                ]);

                \Log::info("Respon Fonnte: " . $res->body());
            } catch (\Exception $e) {
                \Log::error("Gagal kirim WhatsApp: " . $e->getMessage());
            }
        }
    }

    private function logAktivitas($aksi, $keterangan)
    {
        if (class_exists(LogAktivitas::class)) {
            LogAktivitas::create([
                'user_id'    => auth()->id(),
                'aksi'       => $aksi,
                'keterangan' => $keterangan,
            ]);
        }
    }
}
