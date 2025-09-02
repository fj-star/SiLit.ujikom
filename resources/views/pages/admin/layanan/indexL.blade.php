@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Layanan</h4>
            <a href="{{ route('admin.layanans.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Layanan
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Layanan</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($layanans as $layanan)
                        <tr>
                            <td>{{ $layanan->nama_layanan }}</td>
                            <td>{{ $layanan->deskripsi ?: '-' }}</td>
                            <td><span class="badge bg-success">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span></td>
                            <td>
                                <a href="{{ route('admin.layanans.edit', $layanan) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.layanans.destroy', $layanan) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada layanan tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
