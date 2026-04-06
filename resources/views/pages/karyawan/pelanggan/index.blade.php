@extends('layouts.main')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="m-0 font-weight-bold text-primary">Data Pelanggan InstaWash</h5>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light text-center">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama</th>
                        <th>Kontak (Email/HP)</th>
                        <th>TTL</th>
                        <th>Alamat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $p)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($pelanggans->currentPage() - 1) * $pelanggans->perPage() }}</td>
                        <td class="font-weight-bold text-dark">{{ $p->name }}</td>
                        <td>
                            <small class="text-muted"><i class="fas fa-envelope fa-xs"></i> {{ $p->email }}</small><br>
                            <small class="text-dark"><i class="fas fa-phone fa-xs"></i> {{ $p->no_hp ?? '-' }}</small>
                        </td>
                        <td><small>{{ $p->ttl ?? '-' }}</small></td>
                        <td><small>{{ Str::limit($p->alamat, 40) }}</small></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('karyawan.pelanggan.edit',$p->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('karyawan.pelanggan.destroy',$p->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pelanggans->links() }}
        </div>
    </div>
</div>
@endsection