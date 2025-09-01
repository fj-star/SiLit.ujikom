<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;

class AdminController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('pages.admin.index', compact('layanans'));
    }

    public function create()
    {
        return view('pages.admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric',
        ]);

        Layanan::create($request->only('nama_layanan', 'harga_per_kg'));

        return redirect()->route('admin.dashboard')->with('success', 'Layanan berhasil ditambahkan');
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric',
        ]);

        $layanan->update($request->only('nama_layanan', 'harga_per_kg'));

        return redirect()->route('admin.dashboard')->with('success', 'Layanan berhasil diupdate');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Layanan berhasil dihapus');
    }
}

