@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="container">
        <div class="row">
            @php
                $cards = [
                    ['title' => 'Jumlah Pesanan', 'text' => 'Total pesanan yang masuk.', 'link' ],
                    ['title' => 'Daftar Pelanggan', 'text' => 'Lihat semua pelanggan yang terdaftar.', 'link' ],
                    ['title' => 'Layanan Tersedia', 'text' => 'Kelola layanan yang tersedia.', 'link' ],
                    ['title' => 'Laporan Penjualan', 'text' => 'Lihat laporan penjualan per periode.', 'link'],
                    ['title' => 'Pengaturan Akun', 'text' => 'Ubah data akun dan keamanan.', 'link'],
                    ['title' => 'Bantuan & Support', 'text' => 'Dapatkan panduan penggunaan aplikasi.', 'link' ],
                ];
            @endphp

            @foreach ($cards as $index => $card)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100 fade-in" style="animation-delay: {{ $index * 0.2 }}s;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $card['title'] }}</h5>
                            <p class="card-text">{{ $card['text'] }}</p>
                            <a href class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Animasi fade-in */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s forwards ease-in-out;
    }
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Efek hover */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>
@endpush
