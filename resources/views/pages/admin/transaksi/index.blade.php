@extends('layouts.main')

@section('content')

<div class="card">
    <div class="card-body">
        <div class="container">
    <h2 class="mb-4">Daftar Transaksi</h2>
    <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Treatment</th>
                <th>Berat</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Metode Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $transaksi)
            <tr>
                <td>{{ $transaksi->pelanggan->user->name ?? 'N/A' }}</td>
                <td>{{ $transaksi->layanan->nama_layanan ?? 'N/A' }}</td>
                <td>{{ $transaksi->treatment->nama_treatment ?? '-' }}</td>
                <td>{{ $transaksi->berat }} kg</td>
                <td>Rp {{ number_format($transaksi->total_harga,0,',','.') }}</td>
                <td>{{ ucfirst($transaksi->status) }}</td>
                <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                <td>
                    <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline delete-form">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm ">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
    </div>
</div>


@endsection
