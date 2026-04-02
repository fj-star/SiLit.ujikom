@extends('layouts.main')
@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h4>Daftar Transaksi InstaWash</h4>
            <a href="{{ route('karyawan.transaksi.create') }}" class="btn btn-primary">+ Tambah Transaksi</a>
        </div>

        <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-light text-center">
                <tr>
                    <th>no</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Berat</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status Laundry</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->user->name }}</td>
                    <td>{{ $t->layanan->nama_layanan ?? '-' }}</td>
                    <td>{{ $t->berat }} Kg</td>
                    <td>Rp {{ number_format($t->total_harga) }}</td>
                    <td class="text-center">
                        <span class="badge {{ $t->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                            {{ strtoupper($t->payment_status) }} ({{ strtoupper($t->metode_pembayaran) }})
                        </span>
                    </td>
                    <td class="text-center">
    @if($t->payment_status == 'paid')
        <span class="badge bg-success">LUNAS</span>
    @else
        <span class="badge bg-danger">BELUM BAYAR</span>
        
        {{-- Tombol Konfirmasi Khusus Cash --}}
        @if($t->metode_pembayaran == 'cash')
            <form action="{{ route('karyawan.transaksi.konfirmasi-bayar', $t->id) }}" method="POST" class="d-inline form-konfirmasi-cash">
                @csrf @method('PUT')
                <button type="button" class="btn btn-xs btn-outline-success py-0 btn-konfirmasi-cash" style="font-size: 10px;">
                    Konfirmasi
                </button>
            </form>
        @endif
    @endif
    <br>
    <small class="text-muted">({{ strtoupper($t->metode_pembayaran) }})</small>
</td>
                    <td class="text-center">
                        <a href="{{ route('karyawan.transaksi.invoice', $t->id) }}" class="btn btn-sm btn-info" title="Cetak Invoice"><i class="fas fa-print"></i> Cetak</a>
                        <a href="{{ route('karyawan.transaksi.edit',$t->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('karyawan.transaksi.destroy', $t->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        {{ $transaksis->links() }}
    </div>
</div>

<!-- Sweet Alert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const confirmButtons = document.querySelectorAll('.btn-konfirmasi-cash');
        
        confirmButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Konfirmasi Pembayaran Cash',
                    text: "Apakah Anda yakin sudah menerima uang cash/tunai dari pelanggan?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Sudah Terima!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection