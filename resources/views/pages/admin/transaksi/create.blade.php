@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Tambah Transaksi</h2>
    <form action="{{ route('admin.transaksi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Pelanggan</label>
            <select name="pelanggan_id" class="form-control" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}">{{ $p->user->name ?? 'Tanpa Nama' }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Layanan</label>
            <select name="layanan_id" class="form-control" required>
                <option value="">-- Pilih Layanan --</option>
                @foreach($layanans as $l)
                    <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Treatment (Opsional)</label>
            <select name="treatment_id" class="form-control">
                <option value="">-- Tanpa Treatment --</option>
                @foreach($treatments as $t)
                    <option value="{{ $t->id }}">{{ $t->nama_treatment }} (Diskon: {{ $t->diskon }}%)</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Berat (kg)</label>
            <input type="number" name="berat" class="form-control" step="0.1" required>
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
                <option value="ewallet">E-Wallet</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Dibuat oleh</label>
            <select name="created_by" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="pelanggan">Pelanggan</option>
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
