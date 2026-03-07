<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentikasi user
        $request->authenticate();

        // Regenerasi session (WAJIB untuk security)
        $request->session()->regenerate();

        $user = auth()->user();

        // Redirect berdasarkan role
        return match ($user->role) {
            'admin'     => redirect()->route('admin.dashboard')->with('success', 'Halo ' . auth()->user()->name),
            'owner'     => redirect()->route('owner.dashboard')->with('success', 'Halo ' . auth()->user()->name),
            'karyawan'  => redirect()->route('karyawan.dashboard')->with('success', 'Halo ' . auth()->user()->name),
            'pelanggan' => redirect()->route('pelanggan.dashboard')->with('success', 'Halo ' . auth()->user()->name),
            default     => redirect('/'),
        };
    }

    /**
     * Proses logout
     */
    public function destroy(Request $request): RedirectResponse
{
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Tambahkan flash message 'logout_success' di sini bray
    return redirect('/login')->with('logout_success', 'Kamu telah berhasil keluar dari sistem.');
}
    
}
