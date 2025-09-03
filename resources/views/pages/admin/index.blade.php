@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

<div class="row">
    {{-- Jumlah Pesanan --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-primary"><i class="fas fa-shopping-cart fa-2x"></i></div>
            <h5 class="card-title mb-2">Jumlah Pesanan</h5>
            <h2 class="mb-1">{{ $totalPemesanan }}</h2>
            <p class="text-muted">Total pesanan yang masuk.</p>
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-primary">Lihat</a>
        </div>
    </div>

    {{-- Data Pelanggan --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-success"><i class="fas fa-users fa-2x"></i></div>
            <h5 class="card-title mb-2">Data Pelanggan</h5>
            <h2 class="mb-1">{{ $pelangganCount }}</h2>
            <p class="text-muted">Total pelanggan terdaftar.</p>
            <a href="{{ route('admin.pelanggans.index') }}" class="btn btn-sm btn-success">Kelola</a>
        </div>
    </div>

    {{-- Layanan Tersedia --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-warning"><i class="fas fa-concierge-bell fa-2x"></i></div>
            <h5 class="card-title mb-2">Layanan Tersedia</h5>
            <h2 class="mb-1">{{ $layananCount }}</h2>
            <p class="text-muted">Kelola layanan yang tersedia.</p>
            <a href="{{ route('admin.layanans.index') }}" class="btn btn-sm btn-warning text-white">Lihat</a>
        </div>
    </div>

    {{-- Log Aktivitas --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-danger"><i class="fas fa-chart-line fa-2x"></i></div>
            <h5 class="card-title mb-2">Log Aktivitas (Hari Ini)</h5>
            <h2 class="mb-1">{{ $logHariIni }}</h2>
            <p class="text-muted">Catatan aktivitas terbaru.</p>
            <a href="{{ route('admin.log-aktivitas.index') }}" class="btn btn-sm btn-danger">Lihat</a>
        </div>
    </div>

    {{-- Treatment --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-info"><i class="fas fa-soap fa-2x"></i></div>
            <h5 class="card-title mb-2">Treatment</h5>
            <h2 class="mb-1">{{ $treatmentCount }}</h2>
            <p class="text-muted">Tambahan harga & diskon.</p>
            <a href="{{ route('admin.treatments.index') }}" class="btn btn-sm btn-info text-white">Lihat</a>
        </div>
    </div>

    {{-- Omzet Bulan Ini --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-secondary"><i class="fas fa-money-bill-wave fa-2x"></i></div>
            <h5 class="card-title mb-2">Omzet Bulan Ini</h5>
            <h2 class="mb-1">Rp {{ number_format((float)$omzetBulanIni, 0, ',', '.') }}</h2>
            <p class="text-muted">Total pemasukan bulan {{ now()->translatedFormat('F Y') }}.</p>
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-secondary">Lihat</a>
        </div>
    </div>
</div>

{{-- Status Ringkasan --}}
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow p-3">
            <h5 class="mb-3">Ringkasan Status Pesanan</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Pending</span><span>{{ $pesananPending }} ({{ $pctPending }}%)</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-secondary" style="width: {{ $pctPending }}%"></div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Proses</span><span>{{ $pesananProses }} ({{ $pctProses }}%)</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: {{ $pctProses }}%"></div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Selesai</span><span>{{ $pesananSelesai }} ({{ $pctSelesai }}%)</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: {{ $pctSelesai }}%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-2 text-muted">
                Total Omzet: <strong>Rp {{ number_format((float)$totalOmzet, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>
</div>

{{-- Grafik & Transaksi Terbaru --}}
<div class="row">
    <div class="col-md-7 mb-4">
        <div class="card shadow p-3 h-100">
            <h5 class="mb-3">Grafik Pesanan per Bulan ({{ now()->year }})</h5>
            <div style="height: 350px;">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-4">
        <div class="card shadow p-3 h-100">
            <h5 class="mb-3">Transaksi Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-sm table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $t)
                        <tr>
                            <td>{{ $t->created_at->format('d M Y') }}</td>
                            <td>{{ $t->pelanggan->user->name ?? '-' }}</td>
                            <td>{{ $t->layanan->nama_layanan ?? '-' }}</td>
                            <td>Rp {{ number_format((float)$t->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-2">
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fade-in { opacity: 0; transform: translateY(15px); animation: fadeInUp .5s forwards ease-in-out; }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    .card { border-radius: 15px; transition: transform .25s, box-shadow .25s; }
    .card:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 10px 25px rgba(0,0,0,.12); }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Jumlah Pesanan',
                data: @json($chartData),
                tension: 0.35,
                fill: true,
                backgroundColor: 'rgba(78, 115, 223, 0.15)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { precision: 0, stepSize: 1 } } }
        }
    });
</script>
@endpush

@if(session('success'))
<script>
    Swal.fire({
        title: 'Selamat Datang 🎉',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'Siap!',
        confirmButtonColor: '#3085d6',
    })
</script>
@endif
