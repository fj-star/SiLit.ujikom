@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">Daftar Treatment</h4>
    <a href="{{ route('admin.treatments.create') }}" class="btn btn-primary mb-3">Tambah Treatment</a>
    
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="treatmentTable">
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
                    <td>Rp {{ number_format($treatment->harga, 0, ',', '.') }}</td>
                    <td>{{ $treatment->diskon }}%</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('admin.treatments.edit', $treatment) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.treatments.destroy', $treatment) }}" method="POST" class="d-inline delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada data treatment</td></tr>
            @endforelse
        </tbody>
    </table>
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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script>
$(document).ready(function() {
    $('#treatmentTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'pdf',   text: '<i class="fas fa-file-pdf"></i> PDF',   className: 'btn btn-danger btn-sm',  exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'print', text: '<i class="fas fa-print"></i> Print',   className: 'btn btn-secondary btn-sm', exportOptions: { columns: ':not(:last-child)' } }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
    });
});
</script>
@endpush
