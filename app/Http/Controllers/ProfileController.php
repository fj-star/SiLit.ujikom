<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi ditingkatkan untuk semua field di database kamu
        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'no_hp'  => ['required', 'string', 'max:15', 'unique:users,no_hp,'.$user->id],
            'alamat' => ['required', 'string', 'max:500'],
            'ttl'    => ['nullable', 'string', 'max:255'], // Mengikuti migration string nullable
        ]);

        if ($user->email !== $request->email) {
            $user->email_verified_at = null;
        }

        $user->fill($request->only(['name', 'email', 'no_hp', 'alamat', 'ttl']));
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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