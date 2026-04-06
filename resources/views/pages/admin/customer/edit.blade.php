@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4>Edit Data Pelanggan</h4>

    <form action="{{ route('admin.pelanggans.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control"
                   value="{{ old('nama', $pelanggan->user->name) }}" required>
            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $pelanggan->user->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Tanggal Lahir --}}
        <div class="mb-3">
            <label for="ttl">Tanggal Lahir</label>
            <input type="date" name="ttl" id="ttl" class="form-control"
                   value="{{ old('ttl', $pelanggan->ttl) }}">
            @error('ttl') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat', $pelanggan->alamat) }}</textarea>
        </div>

        {{-- Nomor HP --}}
        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control"
                   value="{{ old('no_hp', $pelanggan->no_hp) }}">
        </div>

        {{-- Password Baru --}}
        <div class="mb-4 p-3 border rounded border-warning bg-light">
            <label class="text-warning font-weight-bold"><i class="fas fa-key"></i> Ganti Password (Opsional)</label>
            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti password">
            <small class="text-muted">Hanya diisi jika pelanggan lupa password dan minta di-reset.</small>
            @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.pelanggans.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
