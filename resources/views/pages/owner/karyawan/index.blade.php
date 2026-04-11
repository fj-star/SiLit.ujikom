@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Data Karyawan</h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle" id="karyawanTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Karyawan</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Total Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $k->name }}</strong></td>
                        <td>{{ $k->no_hp ?? '-' }}</td>
                        <td>{{ $k->alamat ?? '-' }}</td>
                        <td><span class="badge bg-primary">{{ $k->total_transaksi }} transaksi</span></td>
                        <td>
                            <a href="{{ route('owner.karyawan.show', $k->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Lihat Gaji
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script>
$(document).ready(function() {
    $('#karyawanTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'pdf',   text: '<i class="fas fa-file-pdf"></i> PDF',   className: 'btn btn-danger btn-sm', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'print', text: '<i class="fas fa-print"></i> Print',   className: 'btn btn-secondary btn-sm', exportOptions: { columns: ':not(:last-child)' } }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
    });
});
</script>
@endpush
