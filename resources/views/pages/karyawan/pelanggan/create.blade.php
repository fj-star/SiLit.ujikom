@extends('layouts.main')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 text-center">
        <div class="card shadow p-4">
            <i class="fas fa-ban fa-3x text-danger mb-3"></i>
            <h5 class="text-danger">Akses Ditolak</h5>
            <p class="text-muted">Karyawan tidak diizinkan untuk menambah akun pelanggan baru.</p>
            <a href="{{ route('karyawan.pelanggan.index') }}" class="btn btn-secondary">Kembali ke Daftar Pelanggan</a>
        </div>
    </div>
</div>
@endsection