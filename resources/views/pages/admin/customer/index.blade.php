
@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
    <h2>Data Pelanggan</h2>
    {{-- <a href="{{ route('admin.pelanggans.create') }}" class="btn btn-primary">Tambah Pelanggan</a> --}}
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>TTL</th>
                <th>Alamat</th>
                <th>No HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggans as $p)
            <tr>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->user->email }}</td>
                <td>{{ $p->ttl }}</td>
                <td>{{ $p->alamat }}</td>
                <td>{{ $p->no_hp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
