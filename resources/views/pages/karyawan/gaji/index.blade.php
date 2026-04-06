@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-3 text-gray-800">Riwayat Gaji Saya</h4>

    <div class="card shadow-sm border-0">
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
                    @forelse ($gajis as $g)
                    <tr>
                        <td>{{ $loop->iteration + ($gajis->currentPage() - 1) * $gajis->perPage() }}</td>
                        <td><strong>{{ $g->bulan_tahun }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($g->tanggal_bayar)->format('d/m/Y') }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($g->jumlah_gaji, 0, ',', '.') }}</td>
                        <td>{{ $g->keterangan ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data gaji untuk akun Anda.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $gajis->links() }}
        </div>
    </div>
</div>
@endsection
