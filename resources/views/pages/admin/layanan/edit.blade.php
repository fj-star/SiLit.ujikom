@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4>Edit Layanan</h4>

    <form action="{{ route('admin.layanans.update', $layanan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Layanan</label>
            <input type="text" name="nama_layanan" class="form-control"
                   value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" step="0.01"
                   value="{{ old('harga', $layanan->harga) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.layanans.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
