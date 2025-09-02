<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::all();
        return view('pages.admin.treatment.index', compact('treatments'));
    }

    public function create()
    {
        return view('pages.admin.treatment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_treatment' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        Treatment::create($request->all());
        return redirect()->route('admin.treatments.index')->with('success', 'Treatment berhasil ditambahkan.');
    }

    public function edit(Treatment $treatment)
    {
        return view('pages.admin.treatment.edit', compact('treatment'));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $request->validate([
            'nama_treatment' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        $treatment->update($request->all());
        return redirect()->route('admin.treatments.index')->with('success', 'Treatment berhasil diperbarui.');
    }

    public function destroy(Treatment $treatment)
    {
        $treatment->delete();
        return redirect()->route('admin.treatments.index')->with('success', 'Treatment berhasil dihapus.');
    }
}
