@extends('layouts.main')

@section('content')
<div class="card p-4">
    <h4 class="mb-3">{{ isset($transaksi) ? 'Edit Transaksi' : 'Tambah Transaksi' }}</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($transaksi) ? route('admin.transaksi.update',$transaksi) : route('admin.transaksi.store') }}" method="POST">
        @csrf
        @if(isset($transaksi))
            @method('PUT')
        @endif

        {{-- Pelanggan --}}
        <div class="mb-2">
            <label>Pelanggan</label>
            <select name="pelanggan_id" class="form-control">
                <option value="">- Pilih Pelanggan -</option>
                @foreach($pelanggans as $id => $name)
                    <option value="{{ $id }}" {{ (isset($transaksi) && $transaksi->pelanggan_id==$id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Layanan --}}
        <div class="mb-2">
    <label>Layanan</label>
    <select name="layanan_id" class="form-control">
        <option value="">- Pilih Layanan -</option>
        @foreach($layanans as $layanan)
            <option value="{{ $layanan->id }}" {{ (isset($transaksi) && $transaksi->layanan_id==$layanan->id) ? 'selected' : '' }}>
                {{ $layanan->nama_layanan }}
            </option>
        @endforeach
    </select>
</div>
        {{-- Treatment --}}
        <div class="mb-2">
            <label>Treatment</label>
            <select name="treatment_id" class="form-control">
                <option value="">- Tidak ada -</option>
                @foreach($treatments as $treatment)
                    <option value="{{ $treatment->id }}" {{ (isset($transaksi) && $transaksi->treatment_id==$treatment->id) ? 'selected' : '' }}>
                        {{ $treatment->nama }} - Rp {{ number_format($treatment->harga) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Berat --}}
        <div class="mb-2">
            <label>Berat (kg)</label>
            <input type="number" name="berat" class="form-control" step="0.1" min="0" value="{{ old('berat', $transaksi->berat ?? '') }}">
        </div>

        {{-- Metode Bayar --}}
        <div class="mb-2">
            <label>Metode Pembayaran</label>
            <input type="text" name="metode_pembayaran" class="form-control" value="{{ old('metode_pembayaran', $transaksi->metode_pembayaran ?? '') }}">
        </div>

        {{-- Status (Edit only) --}}
        @isset($transaksi)
        <div class="mb-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="baru" {{ $transaksi->status=='baru'?'selected':'' }}>Baru</option>
                <option value="proses" {{ $transaksi->status=='proses'?'selected':'' }}>Proses</option>
                <option value="selesai" {{ $transaksi->status=='selesai'?'selected':'' }}>Selesai</option>
            </select>
        </div>
        @endisset

        <button type="submit" class="btn btn-primary">{{ isset($transaksi) ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection
