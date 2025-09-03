<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')->latest()->paginate(20);
        return view('pages.admin.log.index', compact('logs'));
    }

    public function destroy(LogAktivitas $logAktivita)
    {
        $logAktivita->delete();
        return redirect()->route('admin.log-aktivitas.index')
            ->with('success', 'Log berhasil dihapus.');
    }
}
