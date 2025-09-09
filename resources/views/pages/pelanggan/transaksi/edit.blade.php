@extends('layouts.main')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden p-6 sm:p-8 lg:p-10">

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b pb-4 border-gray-200">
                <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2 sm:mb-0">
                    Edit Transaksi
                </h2>
                <a href="{{ route('pelanggan.transaksi.index') }}"
                    class="px-6 py-3 bg-gray-300 text-gray-900 font-semibold rounded-full hover:bg-gray-400 transition duration-300 transform hover:scale-105 shadow-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    ← Kembali
                </a>
            </div>

            <form action="{{ route('pelanggan.transaksi.update', $transaksi->id) }}" method="POST" id="transaksiForm">
                @csrf
                @method('PUT')

                <!-- Layanan -->
                <div class="mb-6">
                    <label for="layanan_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Layanan</label>
                    <select name="layanan_id" id="layanan_id" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach ($layanans as $layanan)
                            <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}"
                                {{ $transaksi->layanan_id == $layanan->id ? 'selected' : '' }}>
                                {{ $layanan->nama_layanan }} - Rp {{ number_format($layanan->harga, 0, ',', '.') }}/kg
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Treatment -->
                <div class="mb-6">
                    <label for="treatment_id" class="block text-sm font-semibold text-gray-700 mb-2">Treatment (Opsional)</label>
                    <select name="treatment_id" id="treatment_id" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Tidak ada --</option>
                        @foreach ($treatments as $treatment)
                            <option value="{{ $treatment->id }}" data-harga="{{ $treatment->harga }}" data-diskon="{{ $treatment->diskon }}"
                                {{ $transaksi->treatment_id == $treatment->id ? 'selected' : '' }}>
                                {{ $treatment->nama_treatment }} - Rp {{ number_format($treatment->harga, 0, ',', '.') }}
                                @if($treatment->diskon > 0) (Diskon {{ $treatment->diskon }}%) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Berat -->
                <div class="mb-6">
                    <label for="berat" class="block text-sm font-semibold text-gray-700 mb-2">Berat Cucian (kg)</label>
                    <input type="number" name="berat" id="berat" min="1" value="{{ old('berat', $transaksi->berat) }}"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <!-- Metode Pembayaran -->
                <div class="mb-6">
                    <label for="metode_pembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500" required>
                        <option value="cash" {{ $transaksi->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ $transaksi->metode_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="ewallet" {{ $transaksi->metode_pembayaran == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status Transaksi</label>
                    <select name="status" id="status" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500" required>
                        <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <!-- Preview Harga -->
                <div class="mb-8">
                    <p class="text-lg font-semibold text-gray-900">Total Harga: <span id="totalHarga" class="text-indigo-600">Rp 0</span></p>
                    <small class="text-gray-500">*Harga otomatis dihitung termasuk diskon jika ada.</small>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('pelanggan.transaksi.index') }}"
                        class="px-6 py-3 bg-gray-300 text-gray-900 font-semibold rounded-full hover:bg-gray-400 transition duration-300 transform hover:scale-105 shadow-md">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-full hover:bg-indigo-700 transition duration-300 transform hover:scale-105 shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        Update Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const layananSelect   = document.getElementById("layanan_id");
            const treatmentSelect = document.getElementById("treatment_id");
            const beratInput      = document.getElementById("berat");
            const totalHargaEl    = document.getElementById("totalHarga");

            function hitungTotal() {
                let layananHarga   = layananSelect.options[layananSelect.selectedIndex]?.dataset.harga || 0;
                let treatmentHarga = treatmentSelect.options[treatmentSelect.selectedIndex]?.dataset.harga || 0;
                let treatmentDiskon= treatmentSelect.options[treatmentSelect.selectedIndex]?.dataset.diskon || 0;
                let berat          = parseFloat(beratInput.value) || 0;

                let total = layananHarga * berat;
                if (treatmentHarga > 0) {
                    total += parseFloat(treatmentHarga);
                    if (treatmentDiskon > 0) {
                        total -= total * (treatmentDiskon / 100);
                    }
                }

                if (total >= 100000 && berat >= 10) {
                    total -= total * 0.1; // diskon tambahan 10%
                }

                totalHargaEl.textContent = "Rp " + new Intl.NumberFormat("id-ID").format(total);
            }

            layananSelect.addEventListener("change", hitungTotal);
            treatmentSelect.addEventListener("change", hitungTotal);
            beratInput.addEventListener("input", hitungTotal);

            hitungTotal(); // init pertama
        });
    </script>
@endsection
