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

<script>
    const payButton = document.getElementById('pay-button');
    payButton.onclick = function (e) {
        e.preventDefault();
        
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                alert("Pembayaran Berhasil!"); 
                window.location.href = "{{ route('pelanggan.transaksi.index') }}";
            },
            onPending: function(result) {
                alert("Menunggu pembayaran. Silakan cek email atau aplikasi e-wallet Anda.");
                window.location.href = "{{ route('pelanggan.transaksi.index') }}";
            },
            onError: function(result) {
                alert("Pembayaran gagal! Silakan coba lagi.");
                location.reload();
            },
            onClose: function() {
                alert('Anda menutup layar pembayaran sebelum selesai.');
            }
        });
    };
</script>
@endsection
