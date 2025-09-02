@extends('layouts.main')

@section('content')
    <div class="card p-4">
        <h4 class="mb-3">Daftar Treatment</h4>
        <a href="{{ route('admin.treatments.create') }}" class="btn btn-primary mb-3">Tambah Treatment</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama Treatment</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Diskon (%)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($treatments as $treatment)
                    <tr>
                        <td>{{ $treatment->nama_treatment }}</td>
                        <td>{{ $treatment->deskripsi }}</td>
                        <td>@rupiah($treatment->harga)</td>
                        <td>@diskon($treatment->diskon)</td>
                        <td>
                            <a href="{{ route('admin.treatments.edit', $treatment) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.treatments.destroy', $treatment) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus treatment ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data treatment</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection