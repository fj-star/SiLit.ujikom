@extends('layouts.main')
@section('content')
<div class="container-fluid px-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Transaksi</h1>
        <a href="{{ route('pelanggan.transaksi.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Transaksi Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">ID Transaksi</th>
                                <td>INV{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $transaksi->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Layanan</th>
                                <td>{{ $transaksi->layanan->nama_layanan }}</td>
                            </tr>
                            <tr>
                                <th>Treatment</th>
                                <td>
                                    @if($transaksi->treatment)
                                        {{ $transaksi->treatment->nama_treatment }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Berat</th>
                                <td>{{ $transaksi->berat }} kg</td>
                            </tr>
                            <tr>
                                <th>Total Harga</th>
                                <td class="font-weight-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $transaksi->status == 'pending' ? 'warning' : ($transaksi->status == 'proses' ? 'info' : 'success') }}">
                                        {{ ucfirst($transaksi->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        @if($transaksi->status == 'pending')
                            {{-- <   --}}
                            
                            <form action="{{ route('pelanggan.transaksi.destroy', $transaksi->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('pelanggan.transaksi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <span class="badge badge-{{ $transaksi->status == 'pending' ? 'warning' : ($transaksi->status == 'proses' ? 'info' : 'success') }} p-3" style="font-size: 1.2rem;">
                            {{ strtoupper($transaksi->status) }}
                        </span>
                    </div>
                    
                    <div class="alert alert-{{ $transaksi->status == 'pending' ? 'warning' : ($transaksi->status == 'proses' ? 'info' : 'success') }}">
                        @switch($transaksi->status)
                            @case('pending')
                                <i class="fas fa-clock"></i> <strong>Pending:</strong> Transaksi Anda sedang menunggu untuk diproses.
                                @break
                            @case('proses')
                                <i class="fas fa-spinner"></i> <strong>Proses:</strong> Transaksi Anda sedang dalam proses pengerjaan.
                                @break
                            @case('selesai')
                                <i class="fas fa-check-circle"></i> <strong>Selesai:</strong> Transaksi Anda sudah selesai dan siap diambil.
                                @break
                        @endswitch
                    </div>
                    
                    @if($transaksi->status == 'pending')
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Anda masih dapat mengedit atau menghapus transaksi ini.
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Timeline Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-badge bg-primary">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Transaksi Dibuat</h6>
                                <p class="timeline-text">{{ $transaksi->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($transaksi->status != 'pending')
                        <div class="timeline-item">
                            <div class="timeline-badge bg-info">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Diproses</h6>
                                <p class="timeline-text">Transaksi sedang dalam proses pengerjaan</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($transaksi->status == 'selesai')
                        <div class="timeline-item">
                            <div class="timeline-badge bg-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Selesai</h6>
                                <p class="timeline-text">Transaksi telah selesai</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        height: 100%;
        width: 4px;
        background: #e9ecef;
        left: 20px;
        top: 0;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    
    .timeline-badge {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        text-align: center;
        position: absolute;
        left: 0;
        top: 0;
        padding-top: 8px;
        color: white;
    }
    
    .timeline-content {
        margin-left: 60px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
    }
    
    .timeline-title {
        margin-top: 0;
        color: #4e73df;
        font-weight: bold;
    }
    
    .timeline-text {
        margin-bottom: 0;
        color: #5a5c69;
    }
</style>
@endsection