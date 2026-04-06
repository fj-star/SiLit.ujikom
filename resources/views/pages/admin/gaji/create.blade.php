@extends('layouts.main')
@section('content')
<div class="card shadow-sm p-4">
    <h4 class="mb-4">Input Gaji Karyawan</h4>
    <form action="{{ route('admin.gaji.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="fw-semibold">Pilih Karyawan</label>
                <select name="karyawan_id" class="form-control" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($karyawans as $k)
                        <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="fw-semibold">Bulan / Tahun</label>
                <input type="text" name="bulan_tahun" class="form-control" placeholder="contoh: April 2026" value="{{ old('bulan_tahun') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="fw-semibold">Jumlah Gaji (Rp)</label>
                <input type="number" name="jumlah_gaji" class="form-control" min="0" step="1000" value="{{ old('jumlah_gaji') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="fw-semibold">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" class="form-control" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
            </div>
            <div class="col-12 mb-3">
                <label class="fw-semibold">Keterangan (opsional)</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="misal: Gaji pokok + bonus kehadiran">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.gaji.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
