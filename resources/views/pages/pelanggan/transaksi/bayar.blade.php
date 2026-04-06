@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h5>Pembayaran Transaksi</h5>
        </div>

        <div class="card-body">
            <p>
                <strong>ID Transaksi:</strong> 
                INV{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}
            </p>

            <p>
                <strong>Total:</strong> 
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </p>

            <button id="pay-button" class="btn btn-primary">
                Bayar Sekarang
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}">
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    $role = auth()->user()->role;
    if($role === 'karyawan') {
        $redirectUrl = route('karyawan.transaksi.index');
        $successMsg = 'Terima kasih Bapak/Ibu Kasir sudah membantu transaksi pelanggan!';
    } else if($role === 'admin') {
        $redirectUrl = route('admin.transaksi.index');
        $successMsg = 'Terima kasih Admin, transaksi pelanggan berhasil dibantu!';
    } else {
        $redirectUrl = route('pelanggan.transaksi.index');
        $successMsg = 'Terima kasih sudah membayar dan menggunakan layanan InstaWash kami!';
    }
@endphp

<script>
    const payButton = document.getElementById('pay-button');
    payButton.onclick = function(e) {
        e.preventDefault();
        
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                // BYPASS NGROK: Panggil route backend secara manual untuk update status ke paid
                fetch("{{ route('pelanggan.transaksi.force_paid', $transaksi->id) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    Swal.fire({
                        title: 'Pembayaran Berhasil!',
                        text: '{{ $successMsg }}',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    }).then((result) => {
                        window.location.href = "{!! $redirectUrl !!}";
                    });
                }).catch(error => {
                    console.error('Error:', error);
                    window.location.href = "{!! $redirectUrl !!}";
                });
            },
            onPending: function(result) {
                Swal.fire('Menunggu Pembayaran', 'Silakan selesaikan pembayaran.', 'info').then(() => {
                    window.location.href = "{!! $redirectUrl !!}";
                });
            },
            onError: function(result) {
                Swal.fire('Gagal!', 'Pembayaran gagal. Silakan coba lagi.', 'error').then(() => {
                    location.reload();
                });
            },
            onClose: function() {
                Swal.fire('Dibatalkan', 'Anda menutup layar pembayaran sebelum selesai.', 'warning');
            }
        });
    };
</script>
@endsection
