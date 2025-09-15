<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profil user sesuai role.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi dasar
        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ];

        // Kalau role pelanggan → tambahkan field tambahan
        if ($user->role === 'pelanggan') {
            $rules = array_merge($rules, [
                'ttl'    => ['nullable', 'date'],
                'alamat' => ['nullable', 'string', 'max:255'],
                'no_hp'  => ['nullable', 'string', 'max:20'],
            ]);
        }

        $data = $request->validate($rules);

        // Kalau email berubah, reset verifikasi
        if ($user->email !== $data['email']) {
            $user->email_verified_at = null;
        }

        $user->update($data);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
