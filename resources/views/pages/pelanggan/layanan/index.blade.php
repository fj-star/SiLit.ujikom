@extends('layouts.main')

@section('title', 'Layanan Tersedia')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Layanan Tersedia</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($layanans as $layanan)
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <h2 class="text-lg font-semibold">{{ $layanan->nama_layanan }}</h2>
                <p class="text-gray-600 mb-2">{{ $layanan->deskripsi ?? 'Tanpa deskripsi' }}</p>
                <p class="text-indigo-600 font-bold">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</p>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada layanan tersedia.</p>
        @endforelse
    </div>
</div>
@endsection
