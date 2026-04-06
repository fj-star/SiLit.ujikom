<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JamKerja;
use Illuminate\Http\Request;

class JamKerjaController extends Controller
{
    public function index()
    {
        $jamKerja = JamKerja::first();
        if (!$jamKerja) {
            $jamKerja = JamKerja::create([
                'jam_masuk' => '08:00:00',
                'jam_pulang' => '17:00:00',
                'menit_toleransi' => 0
            ]);
        }
        return view('pages.admin.jam_kerja.index', compact('jamKerja'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'menit_toleransi' => 'required|integer|min:0'
        ]);

        $jamKerja = JamKerja::first();
        if ($jamKerja) {
            $jamKerja->update([
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'menit_toleransi' => $request->menit_toleransi,
            ]);
        } else {
            JamKerja::create([
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'menit_toleransi' => $request->menit_toleransi,
            ]);
        }

        return redirect()->back()->with('success', 'Jam Kerja berhasil diperbarui!');
    }
}
