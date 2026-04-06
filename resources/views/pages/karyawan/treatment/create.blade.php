@extends('layouts.main')
@section('content')
<div class="card p-4">
    <h4>Tambah Treatment</h4>
    <form action="{{ route('karyawan.treatments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Treatment</label>
            <input type="text" name="nama_treatment" class="form-control" value="{{ old('nama_treatment') }}" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Harga Tambahan</label>
            <input type="number" name="harga" class="form-control" step="0.01" value="{{ old('harga') }}" required>
        </div>
        <div class="mb-3">
            <label>Diskon (%)</label>
            <input type="number" name="diskon" class="form-control" step="0.01" min="0" max="100" value="{{ old('diskon', 0) }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('karyawan.treatments.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
