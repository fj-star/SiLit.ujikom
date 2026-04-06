@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="container">
            <h2 class="mb-4">Daftar Pelanggan</h2>
            <a href="{{ route('admin.pelanggans.create') }}" class="btn btn-primary mb-3">Tambah Pelanggan</a>
        
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        
            <div class="table-responsive">
            <table  id="example1" class="table table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $index => $pelanggan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            {{-- Bagian Nama Pelanggan --}}
<td class="align-middle">
    <div class="font-weight-bold text-dark">{{ $pelanggan->user->name }}</div>
    {{-- Badge Jabatan Pelanggan --}}
    <span class="badge badge-success text-uppercase" style="font-size: 10px; padding: 2px 8px;">
        <i class="fas fa-user fa-xs mr-1"></i> Pelanggan
    </span>
</td>
                            <td>{{ $pelanggan->user->email }}</td>
                            <td>{{ $pelanggan->no_hp }}</td>
                            <td>{{ $pelanggan->alamat }}</td>
                            <td>{{ $pelanggan->ttl }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.pelanggans.edit', $pelanggan->id) }}"
                                       class="btn btn-sm btn-warning">
                                       <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.pelanggans.destroy', $pelanggan->id) }}"
                                          method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pelanggan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection
