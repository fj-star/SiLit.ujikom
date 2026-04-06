@extends('layouts.main')
@section('content')
<div class="card">
    <div class="card-body">
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-gray-800">Manajemen Gaji Karyawan</h4>
        <a href="{{ route('admin.gaji.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Input Gaji
        </a>
    </div>
    </div>
</div>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Karyawan</th>
                        <th>Bulan / Tahun</th>
                        <th>Tanggal Bayar</th>
                        <th class="text-end">Jumlah Gaji</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gajis as $g)
                    <tr>
                        <td>{{ $loop->iteration + ($gajis->currentPage() - 1) * $gajis->perPage() }}</td>
                        <td><strong>{{ $g->karyawan->name ?? '-' }}</strong></td>
                        <td>{{ $g->bulan_tahun }}</td>
                        <td>{{ \Carbon\Carbon::parse($g->tanggal_bayar)->format('d/m/Y') }}</td>
                        <td class="text-end fw-bold text-success">Rp {{ number_format($g->jumlah_gaji, 0, ',', '.') }}</td>
                        <td>{{ $g->keterangan ?: '-' }}</td>
                        <td>
                            <form action="{{ route('admin.gaji.destroy', $g->id) }}" method="POST" class="d-inline delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data gaji.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $gajis->links() }}
        </div>
    </div>
</div>
@endsection
