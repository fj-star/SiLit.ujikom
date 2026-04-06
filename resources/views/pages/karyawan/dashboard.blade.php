@extends('layouts.main')
@section('title','Dashboard Karyawan')
@section('content')

{{-- Welcome Banner --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow p-4 bg-primary text-white rounded-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fa-3x mr-4"></i>
                <div>
                    <h4 class="mb-0">Selamat Datang, {{ auth()->user()->name }}!</h4>
                    <p class="mb-0 small">Dashboard Karyawan – InstaWash Laundry</p>
                </div>
            </div>
        </div>
    </div>
</div>

<h5 class="mb-3">Ringkasan Hari Ini</h5>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Transaksi Hari Ini</h6>
                <h3>{{ $totalHariIni }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Pending</h6>
                <h3>{{ $pending }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Selesai</h6>
                <h3>{{ $selesai }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <a href="{{ route('karyawan.transaksi.create') }}" class="btn btn-primary me-2">
        <i class="fas fa-plus"></i> Input Transaksi
    </a>
    <a href="{{ route('karyawan.transaksi.index') }}" class="btn btn-outline-primary me-2">
        <i class="fas fa-exchange-alt"></i> Daftar Transaksi
    </a>
    <a href="{{ route('karyawan.layanans.index') }}" class="btn btn-outline-success me-2">
        <i class="fas fa-box"></i> Layanan
    </a>
    <a href="{{ route('karyawan.treatments.index') }}" class="btn btn-outline-info me-2">
        <i class="fas fa-star"></i> Treatment
    </a>
    <a href="{{ route('karyawan.gaji.index') }}" class="btn btn-outline-warning">
        <i class="fas fa-wallet"></i> Gaji Saya
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        Transaksi Terbaru Hari Ini
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $t)
                <tr>
                    <td>{{ $t->order_id ?? '#'.$t->id }}</td>
                    <td>
                        @if($t->pelanggan)
                            {{ $t->pelanggan->name }}
                        @elseif($t->nama_tamu)
                            {{ $t->nama_tamu }} <span class="badge bg-secondary" style="font-size:9px">tamu</span>
                        @else
                            <span class="text-muted">Guest</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $t->status == 'selesai' ? 'success' : 'warning' }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
