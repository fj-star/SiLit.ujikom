@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">Edit Treatment</h4>
    <form action="{{ route('admin.treatments.update', $treatment) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_treatment" class="form-label">Nama Treatment</label>
            <input type="text" name="nama_treatment" id="nama_treatment" class="form-control" value="{{ old('nama_treatment', $treatment->nama_treatment) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi', $treatment->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" step="0.01" value="{{ old('harga', $treatment->harga) }}" required>
        </div>

        <div class="mb-3">
            <label for="diskon" class="form-label">Diskon (%)</label>
            <input type="number" name="diskon" id="diskon" class="form-control" step="0.01" value="{{ old('diskon', $treatment->diskon) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
