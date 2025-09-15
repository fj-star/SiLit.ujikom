@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="container">
            <h2 class="mb-4">Daftar Transaksi</h2>
            <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Treatment</th>
                        <th>Berat (kg)</th>
                        <th>Total Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>inv{{ $transaksi->id }}</td>
                            <td>{{ $transaksi->user?->name ?? 'Tidak ada nama' }}</td>
                            <td>{{ $transaksi->layanan?->nama_layanan ?? 'Tidak ada layanan' }}</td>
                            <td>{{ $transaksi->treatment?->nama_treatment ?? '-' }}</td>
                            <td>{{ $transaksi->berat }}</td>
                            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                            <td>
                                <span class="badge 
                                    {{ $transaksi->status == 'pending' ? 'bg-warning' : ($transaksi->status == 'proses' ? 'bg-info' : 'bg-success') }}">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </td>
                            <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex ">
                                <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}" 
                                   class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" 
                                      method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        Hapus
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
                </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                let form = this.closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data transaksi akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
