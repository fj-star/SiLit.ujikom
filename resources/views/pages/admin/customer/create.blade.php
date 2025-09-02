@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4>Tambah Pelanggan Baru</h4>

    <form action="{{ route('admin.pelanggans.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

       <div class="form-group">
    <label for="ttl">Tanggal Lahir</label>
    <input type="date" name="ttl" id="ttl" class="form-control"
           value="{{ old('ttl') }}">
</div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="number" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.pelanggans.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
