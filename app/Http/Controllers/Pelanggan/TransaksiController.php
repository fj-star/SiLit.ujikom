<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\Treatment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['layanan','treatment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pages.pelanggan.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        return view('pages.pelanggan.transaksi.create', [
            'layanans' => Layanan::all(),
            'treatments' => Treatment::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'layanan_id' => 'required',
            'treatment_id' => 'nullable',
            'berat' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,midtrans',
        ]);

        DB::transaction(function () use ($data) {

            $total = $this->hitungTotalHarga(
                $data['layanan_id'],
                $data['treatment_id'],
                $data['berat']
            );

            Transaksi::create([
                'user_id' => auth()->id(),
                'pelanggan_id' => auth()->id(),
                'layanan_id' => $data['layanan_id'],
                'treatment_id' => $data['treatment_id'],
                'berat' => $data['berat'],
                'total_harga' => $total,
                'metode_pembayaran' => $data['metode_pembayaran'],
                'payment_status' => 'pending',
                'status' => 'pending',
                'created_by' => 'pelanggan',
            ]);
        });

        return redirect()->route('pelanggan.transaksi.index')
            ->with('success','Transaksi berhasil dibuat');
    }

    /* ================= MIDTRANS ================= */

    public function bayarMidtrans(Transaksi $transaksi)
{
    abort_if($transaksi->user_id !== auth()->id(), 403);

    if ($transaksi->payment_status === 'paid') {
        return redirect()->route('pelanggan.transaksi.index')->with('success', 'Transaksi sudah lunas');
    }

    \App\Services\MidtransService::init();

    // SUPAYA TIDAK ERROR 400: Kita buat Order ID yang selalu unik tiap kali mau bayar
    // Tapi kita simpan di kolom order_id supaya bisa dilacak saat callback
    $newOrderId = 'INSTA-' . $transaksi->id . '-' . time();
    
    // Kita generate Snap Token baru setiap kali masuk halaman ini biar fresh
    try {
        $snapToken = \Midtrans\Snap::getSnapToken([
            'transaction_details' => [
                'order_id'     => $newOrderId,
                'gross_amount' => (int) $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
            ],
        ]);

        // Update database dengan Order ID terbaru dan Token baru
        $transaksi->update([
            'order_id'   => $newOrderId,
            'snap_token' => $snapToken
        ]);

    } catch (\Exception $e) {
        return back()->with('error', 'Gagal terhubung ke Midtrans: ' . $e->getMessage());
    }

    return view('pages.pelanggan.transaksi.bayar', [
        'transaksi' => $transaksi,
        'snapToken' => $snapToken
    ]);
}

    /* ================= HELPER ================= */

    private function hitungTotalHarga($layanan_id, $treatment_id, $berat)
    {
        $layanan = Layanan::findOrFail($layanan_id);
        $total = $layanan->harga * $berat;

        if ($treatment_id) {
            $treatment = Treatment::findOrFail($treatment_id);
            $total += $treatment->harga;
            if ($treatment->diskon > 0) {
                $total -= $total * ($treatment->diskon / 100);
            }
        }

        return round($total);
    }

    public function show($id)
{
    // Ambil data transaksi berdasarkan ID
    $transaksi = Transaksi::findOrFail($id);

    // Kirim data ke view detail
    return view('pages.pelanggan.transaksi.show', compact('transaksi'));
}
}
