@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">Tambah Treatment</h4>

    {{-- Error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.treatments.store') }}" method="POST">
        @csrf

        {{-- Nama Treatment --}}
        <div class="mb-3">
            <label for="nama_treatment" class="form-label">Nama Treatment</label>
            <input type="text" name="nama_treatment" id="nama_treatment" class="form-control" value="{{ old('nama_treatment') }}" required>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" step="0.01" value="{{ old('harga') }}" required>
        </div>

        {{-- Diskon --}}
        <div class="mb-3">
            <label for="diskon" class="form-label">Diskon (%)</label>
            <input type="number" name="diskon" id="diskon" class="form-control" step="0.01" value="{{ old('diskon') }}">
        </div>

        {{-- Tombol --}}
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
