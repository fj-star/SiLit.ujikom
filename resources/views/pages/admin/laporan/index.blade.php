@extends('layouts.main')
@section('content')
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Laporan Transaksi</h4>
            <div>
                {{-- <a href="{{ route('admin.laporan.cetak.pdf', request()->query()) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a> --}}
            </div>
        </div>
        
        <!-- Info Total Pendapatan -->
        <div class="alert alert-info">
            <h5>Total Pendapatan: <strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></h5>
        </div>
        
        <!-- Filter -->
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 mb-3">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2">
                <label for="bulan" class="form-label">Bulan</label>
                <select name="bulan" class="form-control">
                    <option value="">-- Bulan --</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ request('tahun') ?: date('Y') }}" placeholder="Tahun">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        
        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Treatment</th>
                        <th>Berat</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->layanan->nama_layanan ?? '-' }}</td>
                            <td>{{ $item->treatment->nama_treatment ?? '-' }}</td>
                            <td>{{ $item->berat }} Kg</td>
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $item->status == 'pending' ? 'warning' : ($item->status == 'proses' ? 'info' : 'success') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data laporan ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection