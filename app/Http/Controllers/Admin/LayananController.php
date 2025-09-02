<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('pages.admin.layanan.indexL', compact('layanans'));
    }

    public function create()
    {
        return view('pages.admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
        ]);

        Layanan::create($request->only('nama_layanan', 'deskripsi', 'harga'));

        return redirect()->route('admin.layanans.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        return view('pages.admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
        ]);

        $layanan->update($request->only('nama_layanan', 'deskripsi', 'harga'));

        return redirect()->route('admin.layanans.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('admin.layanans.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
