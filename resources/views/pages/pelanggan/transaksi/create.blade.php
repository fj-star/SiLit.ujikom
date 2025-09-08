@extends('layouts.main')

@section('content')
<div class="container mx-auto py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Buat Transaksi Baru</h2>

        <form action="{{ route('pelanggan.transaksi.store') }}" method="POST" id="transaksiForm">
            @csrf

            <!-- Layanan -->
            <div class="mb-4">
                <label for="layanan_id" class="block text-sm font-medium text-gray-700">Pilih Layanan</label>
                <select name="layanan_id" id="layanan_id" class="mt-1 block w-full border rounded p-2" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach ($layanans as $layanan)
                        <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}">
                            {{ $layanan->nama_layanan }} - Rp {{ number_format($layanan->harga, 0, ',', '.') }}/kg
                        </option>
                    @endforeach
                </select>
                @error('layanan_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Treatment -->
            <div class="mb-4">
                <label for="treatment_id" class="block text-sm font-medium text-gray-700">Treatment (Opsional)</label>
                <select name="treatment_id" id="treatment_id" class="mt-1 block w-full border rounded p-2">
                    <option value="">-- Tidak ada --</option>
                    @foreach ($treatments as $treatment)
                        <option value="{{ $treatment->id }}" data-harga="{{ $treatment->harga }}" data-diskon="{{ $treatment->diskon }}">
                            {{ $treatment->nama_treatment }} - Rp {{ number_format($treatment->harga, 0, ',', '.') }}
                            @if($treatment->diskon > 0) (Diskon {{ $treatment->diskon }}%) @endif
                        </option>
                    @endforeach
                </select>
                @error('treatment_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Berat -->
            <div class="mb-4">
                <label for="berat" class="block text-sm font-medium text-gray-700">Berat Cucian (kg)</label>
                <input type="number" name="berat" id="berat" min="1" value="1" class="mt-1 block w-full border rounded p-2" required>
                @error('berat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-4">
                <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="mt-1 block w-full border rounded p-2" required>
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
                @error('metode_pembayaran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Preview Harga -->
            <div class="mb-6">
                <p class="text-lg font-semibold">Total Harga: <span id="totalHarga">Rp 0</span></p>
                <small class="text-gray-500">*Harga bisa berubah jika memenuhi syarat diskon tambahan.</small>
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <a href="{{ route('pelanggan.transaksi.index') }}" class="px-4 py-2 bg-gray-300 rounded mr-2 hover:bg-gray-400">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan Transaksi</button>
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
