@extends('layouts.main')
@section('title', 'Dashboard Pelanggan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard Pelanggan</h1>

@push('styles')
<style>
    .fade-in { opacity: 0; transform: translateY(15px); animation: fadeInUp .5s forwards ease-in-out; }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    .card { border-radius: 15px; transition: transform .25s, box-shadow .25s; }
    .card:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 10px 25px rgba(0,0,0,.12); }
</style>
@endpush

<div class="row">
    {{-- Total Transaksi --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-primary"><i class="fas fa-receipt fa-2x"></i></div>
            <h5 class="card-title mb-2">Total Transaksi</h5>
            <h2 class="mb-1">{{ $totalTransaksi ?? 0 }}</h2>
            <p class="text-muted">Jumlah semua transaksi Anda.</p>
            <a href="{{ route('pelanggan.transaksi.index') }}" class="btn btn-sm btn-primary">Pesan Lagi</a>
        </div>
    </div>

    {{-- Total Pengeluaran --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-success"><i class="fas fa-wallet fa-2x"></i></div>
            <h5 class="card-title mb-2">Total Pengeluaran</h5>
            <h2 class="mb-1">Rp {{ number_format($totalOmzet ?? 0, 0, ',', '.') }}</h2>
            <p class="text-muted">Total biaya semua transaksi Anda.</p>
        </div>
    </div>

    {{-- Transaksi Terakhir --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 fade-in text-center p-3">
            <div class="mb-3 text-warning"><i class="fas fa-history fa-2x"></i></div>
            <h5 class="card-title mb-2">Transaksi Terakhir</h5>
            <h2 class="mb-1">{{ $lastTransactionDate ?? '-' }}</h2>
            <p class="text-muted">Tanggal transaksi terakhir Anda.</p>
        </div>
    </div>
</div>

{{-- Grafik & Transaksi Terbaru --}}
<div class="row">
    {{-- Grafik Transaksi --}}
    <div class="col-md-7 mb-4">
        <div class="card shadow p-3 h-100">
            <h5 class="mb-3">Grafik Transaksi per Bulan ({{ now()->year }})</h5>
            <div style="height: 350px;">
                <canvas id="transactionsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="col-md-5 mb-4">
        <div class="card shadow p-3 h-100">
            <h5 class="mb-3">Histori Transaksi Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-sm table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Layanan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse($data as $t) --}}
                        {{-- <tr>
                            <td>{{ $t->created_at->format('d M Y') }}</td>
                            <td>{{ $t->layanan->nama_layanan ?? '-' }}</td>
                            <td>Rp {{ number_format((float)$t->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada transaksi.</td>
                        </tr>
                        @endforelse --}}
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-2">
            <a href="{{ route('pelanggan.transaksi.index') }}" class="btn btn-sm btn-outline-primary">Pesan Lagi</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('transactionsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: @json($chartData ?? []),
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
