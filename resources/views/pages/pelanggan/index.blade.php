@extends('layouts.main')
@section('content')
<div class="container-fluid px-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Pelanggan</h1>
        <a href="{{ route('pelanggan.transaksi.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Transaksi Baru
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Transaksi Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransaksi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pengeluaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Terakhir Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Transaksi Terakhir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($transaksiTerakhir)
                                    {{ $transaksiTerakhir->created_at->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Transaksi Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Status Terakhir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($transaksiTerakhir)
                                    <span class="badge badge-{{ $transaksiTerakhir->status == 'pending' ? 'warning' : ($transaksiTerakhir->status == 'proses' ? 'info' : 'success') }}">
                                        {{ ucfirst($transaksiTerakhir->status) }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">Belum ada transaksi</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Riwayat Transaksi -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('pelanggan.transaksi.index') }}">Lihat Semua</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('pelanggan.transaksi.create') }}">Tambah Baru</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($transaksis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Layanan</th>
                                        <th>Berat</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksis->take(5) as $transaksi)
                                        <tr>
                                            <td>INV{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $transaksi->layanan->nama_layanan }}</td>
                                            <td>{{ $transaksi->berat }} kg</td>
                                            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $transaksi->status == 'pending' ? 'warning' : ($transaksi->status == 'proses' ? 'info' : 'success') }}">
                                                    {{ ucfirst($transaksi->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('pelanggan.transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($transaksi->status == 'pending')
                                                        <form action="{{ route('pelanggan.transaksi.destroy', $transaksi->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('pelanggan.transaksi.index') }}" class="btn btn-primary">Lihat Semua Transaksi</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Belum ada riwayat transaksi</p>
                            <a href="{{ route('pelanggan.transaksi.create') }}" class="btn btn-primary">Buat Transaksi Baru</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="col-xl-4 col-lg-5">
            <!-- Card Layanan Populer -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Layanan Tersedia</h6>
                </div>
                <div class="card-body">
                    @if(isset($layanans) && $layanans->count() > 0)
                        <div class="list-group">
                            @foreach($layanans->take(3) as $layanan)
                                <a href="{{ route('pelanggan.transaksi.create') }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $layanan->nama_layanan }}</h6>
                                        <small>Rp {{ number_format($layanan->harga, 0, ',', '.') }}/kg</small>
                                    </div>
                                    <p class="mb-1 small text-muted">{{ Str::limit($layanan->deskripsi, 50) }}</p>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('pelanggan.transaksi.create') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Layanan</a>
                        </div>
                    @else
                        <p class="text-center text-gray-500">Belum ada layanan tersedia</p>
                    @endif
                </div>
            </div>

            <!-- Card Tips -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tips Laundry</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i> <strong>Diskon 10%</strong> untuk transaksi dengan berat minimal 10kg dan total harga minimal Rp100.000.
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Pastikan status transaksi sudah <strong>Selesai</strong> sebelum mengambil laundry Anda.
                    </div>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Anda dapat membatalkan transaksi selama status masih <strong>Pending</strong>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize DataTable if there are transactions
        @if($transaksis->count() > 0)
        $('#dataTable').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            },
            dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-5"i><"col-sm-7"p>>',
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Semua"]]
        });
        @endif
    });
</script>
@endsection