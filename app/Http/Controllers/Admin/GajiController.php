<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\User;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index()
    {
        $gajis = Gaji::with(['karyawan', 'admin'])->latest()->paginate(15);
        $karyawans = User::where('role', 'karyawan')->get();
        return view('pages.admin.gaji.index', compact('gajis', 'karyawans'));
    }

    public function create()
    {
        $karyawans = User::where('role', 'karyawan')->get();
        return view('pages.admin.gaji.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id'  => 'required|exists:users,id',
            'jumlah_gaji'  => 'required|numeric|min:0',
            'bulan_tahun'  => 'required|string|max:50',
            'tanggal_bayar'=> 'required|date',
            'keterangan'   => 'nullable|string',
        ]);

        Gaji::create([
            'karyawan_id'   => $request->karyawan_id,
            'created_by'    => auth()->id(),
            'jumlah_gaji'   => $request->jumlah_gaji,
            'bulan_tahun'   => $request->bulan_tahun,
            'tanggal_bayar' => $request->tanggal_bayar,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('admin.gaji.index')->with('success', 'Data gaji berhasil ditambahkan.');
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();
        return back()->with('success', 'Data gaji berhasil dihapus.');
    }
}
