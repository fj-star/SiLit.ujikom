@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">Log Aktivitas</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Aksi</th>
                <th>Keterangan</th>
                <th>Waktu</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->user->name ?? 'System' }}</td>
                <td>{{ $log->aksi }}</td>
                <td>{{ $log->keterangan }}</td>
                <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                <td>
        <form action="{{ route('admin.log-aktivitas.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Yakin hapus log ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
        </form>
    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection