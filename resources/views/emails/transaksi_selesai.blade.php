<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pesanan Laundry Selesai</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333;">
    <h2 style="color: #2c3e50;">Halo, {{ $transaksi->user->name }} 👋</h2>

    <p>
        Pesanan laundry Anda dengan ID <strong>#{{ $transaksi->id }}</strong> telah <span style="color:green;">selesai</span>.
    </p>
    <br>
    <p>
        <span>mohon untuk ambil Pesanan ini <strong>abaikan jika sudah</strong> </span>
    </p>

    <p><strong>Detail Pesanan:</strong></p>
    <ul>
        <li>Layanan: {{ $transaksi->layanan->nama ?? '-' }}</li>
        <li>Berat: {{ $transaksi->berat }} Kg</li>
        <li>Total Harga: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</li>
        <li>Status: {{ ucfirst($transaksi->status) }}</li>
    </ul>

    <p>Terima kasih sudah menggunakan layanan kami <strong>E-laundry Silit</strong>! 💙</p>

    <hr>
    <small>Email ini dikirim otomatis, mohon tidak dibalas.</small>
</body>
</html>
