@extends('layouts.main')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden p-6 sm:p-8 lg:p-10">

            {{-- Pesan Sukses dari Session --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b pb-4 border-gray-200">
                <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2 sm:mb-0">
                    Riwayat Transaksi
                </h2>
                <a href="{{ route('pelanggan.transaksi.create') }}"
                    class="px-6 py-3 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition duration-300 transform hover:scale-105 shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    + Tambah Transaksi
                </a>
            </div>

            <div  class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="table table-bordered" class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="py-3 px-6 rounded-tl-lg">#</th>
                            <th scope="col" class="py-3 px-6">Tanggal</th>
                            <th scope="col" class="py-3 px-6">Layanan</th>
                            <th scope="col" class="py-3 px-6">Berat</th>
                            <th scope="col" class="py-3 px-6">Total Harga</th>
                            <th scope="col" class="py-3 px-6 text-center rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $transaksi)
                            <tr class="bg-white border-b last:border-b-0 hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-4 px-6 text-gray-600">
                                    {{ $transaksi->created_at->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-gray-800">{{ $transaksi->layanan->nama_layanan ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $transaksi->treatment->nama_treatment ?? 'N/A' }}</div>
                                </td>
                                <td class="py-4 px-6 text-gray-600">
                                    {{ $transaksi->berat }} kg
                                </td>
                                <td class="py-4 px-6 font-bold text-gray-900">
                                    Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'proses' => 'bg-blue-100 text-blue-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusColors[$transaksi->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($transaksi->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500 text-lg font-medium">Belum ada riwayat transaksi. Mari mulai transaksi pertama Anda!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection