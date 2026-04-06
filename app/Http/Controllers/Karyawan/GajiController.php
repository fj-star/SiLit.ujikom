<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index()
    {
        $gajis = Gaji::with('admin')
            ->where('karyawan_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('pages.karyawan.gaji.index', compact('gajis'));
    }
}
