@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-3 gap-3">
        <a href="{{ route('owner.karyawan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h4 class="fw-bold mb-0">Riwayat Gaji – {{ $karyawan->name }}</h4>
    </div>

    {{-- Info Karyawan --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"><small class="text-muted">Nama</small><p class="fw-bold mb-1">{{ $karyawan->name }}</p></div>
                <div class="col-md-4"><small class="text-muted">No HP</small><p class="fw-bold mb-1">{{ $karyawan->no_hp ?? '-' }}</p></div>
                <div class="col-md-4"><small class="text-muted">Alamat</small><p class="fw-bold mb-1">{{ $karyawan->alamat ?? '-' }}</p></div>
            </div>
        </div>
    </div>

    {{-- Tabel Gaji --}}
    <div class="card shadow-sm border-0">
        <div class="card-header fw-semibold bg-white border-0 pt-3">Riwayat Pembayaran Gaji</div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Bulan / Tahun</th>
                        <th>Tanggal Dibayar</th>
                        <th class="text-end">Jumlah Gaji</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @forelse ($gajis as $g)
                    @php $total += $g->jumlah_gaji; @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $g->bulan_tahun }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($g->tanggal_bayar)->format('d/m/Y') }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($g->jumlah_gaji, 0, ',', '.') }}</td>
                        <td>{{ $g->keterangan ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data gaji.</td></tr>
                    @endforelse
                </tbody>
                @if(count($gajis) > 0)
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total Gaji Dibayar:</td>
                        <td class="text-end fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
