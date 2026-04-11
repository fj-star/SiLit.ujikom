<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        // Pastikan menggunakan zona waktu Asia/Jakarta yang sudah kita set di config
        $today = Carbon::today()->toDateString();
        
        // 1. Ambil Statistik (Hanya untuk Hari Ini)
        $stats = [
            'total_karyawan' => User::where('role', 'karyawan')->count(),
            // Hadir & Terlambat masuk ke kotak 'Hadir'
            'hadir'          => Absensi::where('tanggal', $today)->whereIn('status', ['hadir', 'terlambat'])->count(),
            'terlambat'      => Absensi::where('tanggal', $today)->where('status', 'terlambat')->count(),
            // Izin, Sakit, & Alpha masuk ke kotak 'Izin/Sakit/Cuti'
            'izin'           => Absensi::where('tanggal', $today)->whereIn('status', ['izin', 'sakit', 'alpha'])->count(),
        ];

        // 2. Ambil Data Tabel Hari Ini
        $absensisHariIni = Absensi::with('user')
                    ->where('tanggal', $today)
                    ->latest()
                    ->paginate(10, ['*'], 'page_hari_ini');

        // 3. Ambil Data Riwayat
        $riwayatAbsensis = Absensi::with('user')
                    ->where('tanggal', '!=', $today)
                    ->latest()
                    ->paginate(20, ['*'], 'page_riwayat');

        return view('pages.admin.absensi.index', compact('absensisHariIni', 'riwayatAbsensis', 'stats'));
    }

    public function edit($id)
    {
        // Cari data absensi berdasarkan ID
        $absensi = Absensi::with('user')->findOrFail($id);
        return view('pages.admin.absensi.edit', compact('absensi'));
    }

    public function storeManual(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'status'  => 'required|in:hadir,terlambat,izin,sakit,alpha', // Ditambah hadir & terlambat
        'jam_masuk' => 'nullable', // Admin bisa input jam manual
        'keterangan' => 'nullable'
    ]);

    $today = \Carbon\Carbon::today()->toDateString();

    // Cek biar gak double absen di hari yang sama
    $exists = Absensi::where('user_id', $request->user_id)
                     ->where('tanggal', $today)
                     ->exists();

    if ($exists) {
        return back()->with('error', 'Karyawan ini sudah ada data absensinya hari ini, bray!');
    }

    Absensi::create([
        'user_id'    => $request->user_id,
        'tanggal'    => $today,
        'status'     => $request->status,
        'keterangan' => $request->keterangan,
        // Kalau Admin gak isi jam, otomatis pakai jam sekarang
        'jam_masuk'  => $request->jam_masuk ?? \Carbon\Carbon::now()->toTimeString(),
    ]);

    return back()->with('success', 'Absensi manual berhasil dicatat!');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'jam_masuk' => 'nullable',
            'jam_keluar' => 'nullable',
            'keterangan' => 'nullable'
        ]);

        $absensi = Absensi::findOrFail($id);
        
        $absensi->update([
            'jam_masuk'  => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.absensi.index')->with('success', 'Data berhasil diperbarui, Tuan!');
    }

    public function getStats()
{
    $today = \Carbon\Carbon::today()->toDateString();
    return response()->json([
        'total_karyawan' => \App\Models\User::where('role', 'karyawan')->count(),
        'hadir'          => \App\Models\Absensi::where('tanggal', $today)->whereIn('status', ['hadir', 'terlambat'])->count(),
        'terlambat'      => \App\Models\Absensi::where('tanggal', $today)->where('status', 'terlambat')->count(),
        'izin'           => \App\Models\Absensi::where('tanggal', $today)->whereIn('status', ['izin', 'sakit', 'alpha'])->count(),
    ]);
}

    // Fitur QR Scan lewat Kiosk Admin
    public function scanProses(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);
        if ($user->role !== 'karyawan') {
            return response()->json(['success' => false, 'message' => 'Gagal: QR Bukan Karyawan!']);
        }

        $now = \Carbon\Carbon::now();
        $today = $now->toDateString();
        $timeString = $now->toTimeString();

        $absen = Absensi::where('user_id', $user->id)->where('tanggal', $today)->first();

        if (!$absen) {
            $jamKerjaConfig = \App\Models\JamKerja::first();
            $batasText = $jamKerjaConfig ? $jamKerjaConfig->jam_masuk : '08:00:00';
            $toleransi = $jamKerjaConfig ? $jamKerjaConfig->menit_toleransi : 0;
            
            $batasMasuk = \Carbon\Carbon::parse($batasText);
            $batasToleransi = $batasMasuk->copy()->addMinutes($toleransi);

//            if ($now->gt($batasToleransi)) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Gagal! Waktu keterlambatan melampaui batas toleransi (' . $toleransi . ' menit).'
//                ]);
//            }

            $status = $now->gt($batasMasuk) ? 'terlambat' : 'hadir';

            Absensi::create([
                'user_id'   => $user->id,
                'tanggal'   => $today,
                'jam_masuk' => $timeString,
                'status'    => $status
            ]);

            return response()->json([
                'success' => true, 
                'type' => 'masuk',
                'name' => $user->name,
                'message' => 'Berhasil Hadir jam ' . $timeString
            ]);

        } else {
            if ($absen->jam_keluar) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Karyawan sudah absen keluar.'
                ]);
            }

            $jamKerjaConfig = \App\Models\JamKerja::first();
            $batasPulangText = $jamKerjaConfig ? $jamKerjaConfig->jam_pulang : '17:00:00';
            $batasPulang = \Carbon\Carbon::parse($batasPulangText);

            if ($now->lt($batasPulang)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum bisa melakukan scan pulang, terima kasih tetap kerja semangat!'
                ]);
            }

            $absen->update(['jam_keluar' => $timeString]);

            return response()->json([
                'success' => true, 
                'type' => 'pulang',
                'name' => $user->name,
                'message' => 'Berhasil Pulang jam ' . $timeString
            ]);
        }
    }
}