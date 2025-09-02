@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Edit Transaksi</h2>
    <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Pelanggan</label>
            <select name="pelanggan_id" class="form-control" required>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}" {{ $p->id == old('pelanggan_id', $transaksi->pelanggan_id) ? 'selected' : '' }}>
                        {{ $p->user->name ?? 'Tanpa Nama' }}
                    </option>
                @endforeach
            </select>
            @error('pelanggan_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Layanan</label>
            <select name="layanan_id" class="form-control" required>
                @foreach($layanans as $l)
                    <option value="{{ $l->id }}" {{ $l->id == old('layanan_id', $transaksi->layanan_id) ? 'selected' : '' }}>
                        {{ $l->nama_layanan }}
                    </option>
                @endforeach
            </select>
            @error('layanan_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Treatment (Opsional)</label>
            <select name="treatment_id" class="form-control">
                <option value="">-- Tanpa Treatment --</option>
                @foreach($treatments as $t)
                    <option value="{{ $t->id }}" {{ $t->id == old('treatment_id', $transaksi->treatment_id) ? 'selected' : '' }}>
                        {{ $t->nama_treatment }} (Diskon: {{ $t->diskon }}%)
                    </option>
                @endforeach
            </select>
            @error('treatment_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Berat (kg)</label>
            <input type="number" name="berat" class="form-control" value="{{ old('berat', $transaksi->berat) }}" step="0.1" required>
            @error('berat')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                @foreach(['cash', 'transfer', 'ewallet'] as $mp)
                    <option value="{{ $mp }}" {{ $mp == old('metode_pembayaran', $transaksi->metode_pembayaran) ? 'selected' : '' }}>
                        {{ ucfirst($mp) }}
                    </option>
                @endforeach
            </select>
            @error('metode_pembayaran')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach(['pending', 'proses', 'selesai'] as $st)
                    <option value="{{ $st }}" {{ $st == old('status', $transaksi->status) ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Dibuat oleh</label>
            <select name="created_by" class="form-control" required>
                @foreach(['admin', 'pelanggan'] as $cb)
                    <option value="{{ $cb }}" {{ $cb == old('created_by', $transaksi->created_by) ? 'selected' : '' }}>
                        {{ ucfirst($cb) }}
                    </option>
                @endforeach
            </select>
            @error('created_by')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
