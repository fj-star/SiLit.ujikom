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
                            <td>{{ $pelanggan->user->name }}</td>
                            <td>{{ $pelanggan->user->email }}</td>
                            <td>{{ $pelanggan->no_hp }}</td>
                            <td>{{ $pelanggan->alamat }}</td>
                            <td>{{ $pelanggan->ttl }}</td>
                            <td>
                                <a href="{{ route('admin.pelanggans.edit', $pelanggan->id) }}" class="btn btn-warning btn-sm">Edit</a>
        
                                <form action="{{ route('admin.pelanggans.destroy', $pelanggan->id) }}" 
                                      method="POST" style="display:inline-block;"
                                      onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
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
@endsection
