@extends('layouts.main')
@section('content')
<div class="container-fluid px-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Transaksi</h1>
        <a href="{{ route('pelanggan.transaksi.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Transaksi
        </a>
    </div>

    <!-- Alert Success -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter Status:</div>
                    <a class="dropdown-item" href="{{ route('pelanggan.transaksi.index') }}">Semua</a>
                    <a class="dropdown-item" href="{{ route('pelanggan.transaksi.index', ['status' => 'pending']) }}">Pending</a>
                    <a class="dropdown-item" href="{{ route('pelanggan.transaksi.index', ['status' => 'proses']) }}">Proses</a>
                    <a class="dropdown-item" href="{{ route('pelanggan.transaksi.index', ['status' => 'selesai']) }}">Selesai</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Treatment</th>
                            <th>Berat (kg)</th>
                            <th>Total Harga</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Treatment</th>
                            <th>Berat (kg)</th>
                            <th>Total Harga</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($transaksis as $index => $transaksi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge badge-secondary">INV{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    @if($transaksi->user)
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold">{{ $transaksi->user->name }}</div>
                                                <div class="small text-muted">{{ $transaksi->user->email }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-danger">User tidak ditemukan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($transaksi->layanan)
                                        <span class="badge badge-info">{{ $transaksi->layanan->nama_layanan }}</span>
                                    @else
                                        <span class="text-danger">Layanan tidak ditemukan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($transaksi->treatment)
                                        <span class="badge badge-warning">{{ $transaksi->treatment->nama_treatment }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $transaksi->berat }}</td>
                                <td class="font-weight-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @switch($transaksi->metode_pembayaran)
                                        @case('cash')
                                            <span class="badge badge-success"><i class="fas fa-money-bill-wave"></i> Cash</span>
                                            @break
                                        @case('transfer')
                                            <span class="badge badge-info"><i class="fas fa-exchange-alt"></i> Transfer</span>
                                            @break
                                        @case('ewallet')
                                            <span class="badge badge-primary"><i class="fas fa-wallet"></i> E-Wallet</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($transaksi->status)
                                        @case('pending')
                                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                            @break
                                        @case('proses')
                                            <span class="badge badge-info"><i class="fas fa-spinner"></i> Proses</span>
                                            @break
                                        @case('selesai')
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('pelanggan.transaksi.edit', $transaksi->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           data-toggle="tooltip" 
                                           data-placement="top" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pelanggan.transaksi.destroy', $transaksi->id) }}" 
                                              method="POST" 
                                              style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <div class="text-center">
                                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">Belum ada data transaksi</p>
                                        <a href="{{ route('pelanggan.transaksi.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Tambah Transaksi
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-group {
        display: flex;
    }
    
    .btn-group .btn {
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endsection

@section('scripts')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            },
            dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-5"i><"col-sm-7"p>>',
            buttons: [
                { extend: 'copy', className: 'btn btn-sm btn-secondary' },
                { extend: 'csv', className: 'btn btn-sm btn-secondary' },
                { extend: 'excel', className: 'btn btn-sm btn-secondary' },
                { extend: 'pdf', className: 'btn btn-sm btn-secondary' },
                { extend: 'print', className: 'btn btn-sm btn-secondary' }
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 0 },  // No
                { responsivePriority: 2, targets: 1 },  // ID Transaksi
                { responsivePriority: 3, targets: 9 },  // Tanggal
                { responsivePriority: 4, targets: 10 }  // Aksi
            ],
            initComplete: function () {
                // Add search functionality to each column
                this.api().columns().every(function () {
                    var column = this;
                    var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });
                });
            }
        });
        
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection