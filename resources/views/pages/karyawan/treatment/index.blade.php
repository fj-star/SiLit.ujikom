@extends('layouts.main')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Treatment</h4>
            <a href="{{ route('karyawan.treatments.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Treatment
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Treatment</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($treatments as $treatment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $treatment->nama_treatment }}</td>
                            <td>{{ $treatment->deskripsi ?: '-' }}</td>
                            <td><span class="badge bg-success">Rp {{ number_format($treatment->harga, 0, ',', '.') }}</span></td>
                            <td>{{ $treatment->diskon > 0 ? $treatment->diskon . '%' : '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('karyawan.treatments.edit', $treatment->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('karyawan.treatments.destroy', $treatment->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada treatment.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
