@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
   @push('styles')
        <style>
            .fade-in {
                opacity: 0;
                transform: translateY(15px);
                animation: fadeInUp .5s forwards ease-in-out;
            }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .card {
                border-radius: 15px;
                transition: transform .25s, box-shadow .25s;
            }

            .card:hover {
                transform: translateY(-6px) scale(1.03);
                box-shadow: 0 10px 25px rgba(0, 0, 0, .12);
            }
            .btn {
    transition: all 0.3s ease-in-out;
}

.btn:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 15px rgba(0, 0, 0, .15);
}
        </style>
    @endpush

   <div class="row mb-4">
    <div class="col-12">
        <div class="card shadow p-4 rounded-lg bg-primary-gradient text-dark">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fa-3x mr-4"></i>
                <div>
                    <marquee behavior="" direction="">

                        <h1 class="h3 mb-0">Selamat Datang, {{ auth()->user()->name }}!</h1>
                    </marquee>
                    <p class="lead mb-0">Dashboard Admin Silit Laundry</p>
                </div>
            </div>
        </div>
    </div>
</div>
 
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
                <h2 class="mb-1">Rp {{ number_format((float) $omzetBulanIni, 0, ',', '.') }}</h2>
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
                    Total Omzet: <strong>Rp {{ number_format((float) $totalOmzet, 0, ',', '.') }}</strong>
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
                                    <td>Rp {{ number_format((float) $t->total_harga, 0, ',', '.') }}</td>
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
                <hr>
                <span class="text-green-500">
                    Total pendapatan =
                    @php
                        $omzet = (int) $totalOmzet;
                        if ($omzet >= 1000000) {
                            $juta = number_format($omzet / 1000000, 2, ',', '.');
                            echo "Rp " . $juta . " juta";
                        } elseif ($omzet >= 1000) {
                            $ribu = number_format($omzet, 0, ',', '.');
                            echo "Rp " . $ribu;
                        } else {
                            echo "Rp " . number_format($omzet, 0, ',', '.');
                        }
                    @endphp
                </span>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ctx, {
            type: 'bar', // Menggunakan grafik batang
            data: {
                labels: @json($chartLabels), // Label bulan dari controller
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: @json($chartData), // Data jumlah pesanan dari controller
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

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
@endpush