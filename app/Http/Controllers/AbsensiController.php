<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Pastikan waktu sekarang menggunakan timezone Indonesia
        $today = Carbon::today()->toDateString();
        
        if ($user->role === 'admin') {
            $absensisHariIni = Absensi::with('user')->where('tanggal', $today)->latest()->paginate(10, ['*'], 'page_hari_ini');
            $riwayatAbsensis = Absensi::with('user')->where('tanggal', '!=', $today)->latest()->paginate(20, ['*'], 'page_riwayat');
            return view('pages.admin.absensi.index', compact('absensisHariIni', 'riwayatAbsensis'));
        }

        // Untuk Karyawan
        $absensis = Absensi::where('user_id', $user->id)->latest()->paginate(10);
        $sudah_absen = Absensi::where('user_id', $user->id)->where('tanggal', $today)->first();
        
        return view('pages.karyawan.absensi.index', compact('absensis', 'sudah_absen'));
    }

   public function store(Request $request)
{
    $now = \Carbon\Carbon::now();
    $today = $now->toDateString();
    $timeString = $now->toTimeString();

    $user_id = auth()->id();
    // Cari data absen user hari ini
    $absen = Absensi::where('user_id', $user_id)->where('tanggal', $today)->first();

    if (!$absen) {
        // --- JIKA BELUM ADA DATA = ABSEN MASUK ---
        $jamKerjaConfig = \App\Models\JamKerja::first();
        $batasText = $jamKerjaConfig ? $jamKerjaConfig->jam_masuk : '08:00:00';
        $batasMasuk = \Carbon\Carbon::parse($batasText);
        $status = $now->gt($batasMasuk) ? 'terlambat' : 'hadir';

        Absensi::create([
            'user_id'   => $user_id,
            'tanggal'   => $today,
            'jam_masuk' => $timeString,
            'status'    => $status
        ]);

        return redirect()->route('karyawan.absensi.index')->with('success', 'Berhasil Absen MASUK jam ' . $timeString);

    } else {
        // --- JIKA SUDAH ADA DATA = CEK UNTUK ABSEN PULANG ---
        
        // 1. Cek kalau dia sudah pernah absen pulang (biar nggak scan berkali-kali)
        if ($absen->jam_keluar) {
            return redirect()->route('karyawan.absensi.index')->with('info', 'Tuan sudah menyelesaikan tugas hari ini.');
        }

        // 2. Cek apakah sudah waktunya pulang
        $jamKerjaConfig = \App\Models\JamKerja::first();
        $batasPulangText = $jamKerjaConfig ? $jamKerjaConfig->jam_pulang : '17:00:00';
        $batasPulang = \Carbon\Carbon::parse($batasPulangText);

        if ($now->lt($batasPulang)) {
            return redirect()->route('karyawan.absensi.index')->with('error', 'Anda belum bisa melakukan absen pulang. Terima kasih, tetap kerja semangat!');
        }

        // 2. Update jam keluar
        $absen->update([
            'jam_keluar' => $timeString
        ]);

        return redirect()->route('karyawan.absensi.index')->with('success', 'Berhasil Absen PULANG jam ' . $timeString . '. Hati-hati di jalan Tuan!');
    }
}

    // Fitur QR Scan Otomatis (melalui GET request dari scan Kamera HP)
    public function qrScan(Request $request)
    {
        // Panggil aja method store secara otomatis, jadi satu arah logika.
        // Kita gunakan method store untuk langsung memproses absensi.
        return $this->store($request);
    }
}