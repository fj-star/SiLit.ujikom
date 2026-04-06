@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Data Karyawan</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Karyawan</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Total Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyawans as $k)
                    <tr>
                        <td>{{ $loop->iteration + ($karyawans->currentPage() - 1) * $karyawans->perPage() }}</td>
                        <td><strong>{{ $k->name }}</strong></td>
                        <td>{{ $k->no_hp ?? '-' }}</td>
                        <td>{{ $k->alamat ?? '-' }}</td>
                        <td><span class="badge bg-primary">{{ $k->total_transaksi }} transaksi</span></td>
                        <td>
                            <a href="{{ route('owner.karyawan.show', $k->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Lihat Gaji
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data karyawan.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $karyawans->links() }}
        </div>
    </div>
</div>
@endsection
