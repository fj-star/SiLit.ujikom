@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">Edit Profil</h4>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">Profil berhasil diperbarui ✅</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <!-- Nama -->
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        @if ($user->role === 'pelanggan')
            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="ttl" value="{{ old('ttl', $user->ttl) }}" class="form-control">
                @error('ttl') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- No HP -->
            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="number" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="form-control">
                @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
