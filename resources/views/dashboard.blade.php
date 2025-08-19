@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 fade-in text-center p-3">
                <div class="mb-3 text-primary">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
                <h5 class="card-title mb-2">Jumlah Pesanan</h5>
                <p class="card-text text-muted">Total pesanan yang masuk.</p>
                <a href="#" class="btn btn-sm btn-primary">Lihat</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 fade-in text-center p-3">
                <div class="mb-3 text-success">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <h5 class="card-title mb-2">Daftar Pelanggan</h5>
                <p class="card-text text-muted">Lihat semua pelanggan.</p>
                <a href="#" class="btn btn-sm btn-success">Lihat</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 fade-in text-center p-3">
                <div class="mb-3 text-warning">
                    <i class="fas fa-concierge-bell fa-2x"></i>
                </div>
                <h5 class="card-title mb-2">Layanan Tersedia</h5>
                <p class="card-text text-muted">Kelola layanan yang tersedia.</p>
                <a href="#" class="btn btn-sm btn-warning text-white">Lihat</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 fade-in text-center p-3">
                <div class="mb-3 text-danger">
                    <i class="fas fa-chart-line fa-2x"></i>
                </div>
                <h5 class="card-title mb-2">Laporan Penjualan</h5>
                <p class="card-text text-muted">Cek laporan penjualan.</p>
                <a href="#" class="btn btn-sm btn-danger">Lihat</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 fade-in text-center p-3">
                <div class="mb-3 text-info">
                    <i class="fas fa-user-cog fa-2x"></i>
                </div>
                <h5 class="card-title mb-2">Pengaturan Akun</h5>
                <p class="card-text text-muted">Atur data akun.</p>
                <a href="#" class="btn btn-sm btn-info text-white">Lihat</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 fade-in text-center p-3">
                <div class="mb-3 text-secondary">
                    <i class="fas fa-question-circle fa-2x"></i>
                </div>
                <h5 class="card-title mb-2">Bantuan & Support</h5>
                <p class="card-text text-muted">Panduan & bantuan.</p>
                <a href="#" class="btn btn-sm btn-secondary">Lihat</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .fade-in {
        opacity: 0;
        transform: translateY(15px);
        animation: fadeInUp 0.5s forwards ease-in-out;
    }
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        border-radius: 15px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
</style>
@endpush
