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
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->user->name ?? 'System' }}</td>
                <td>{{ $log->aksi }}</td>
                <td>{{ $log->keterangan }}</td>
                <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection