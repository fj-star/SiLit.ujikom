<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ttl'      => ['nullable', 'date'],
            'alamat'   => ['nullable', 'string', 'max:255'],
            'no_hp'    => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pelanggan',
        ]);

        // 🔥 Buat data pelanggan sesuai input form
        Pelanggan::create([
            'user_id' => $user->id,
            'ttl'     => $request->ttl,
            'alamat'  => $request->alamat,
            'no_hp'   => $request->no_hp,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('pelanggan.dashboard');
    }
}
