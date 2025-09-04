@extends('layouts.main')

@section('content')
    <div class="card p-4">
        <h4 class="mb-3">Laporan Transaksi</h4>

        <!-- Filter -->
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 mb-3">
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2">
                <select name="bulan" class="form-control">
                    <option value="">-- Bulan --</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}" placeholder="Tahun">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                {{-- <a href="{{ route('admin.admin.laporan.cetak.pdf', request()->query()) }}" class="btn btn-danger">Cetak
                    PDF</a> --}}
            </div>
        </form>

        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        {{-- <th>Layanan</th> --}}
                        {{-- <th>Treatment</th> --}}
                        {{-- <th>Berat</th> --}}
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->pelanggan->user->name ?? '-' }}</td>
                            {{-- <td>{{ $item->layanan->nama_layanan ?? '-' }}</td> --}}
                            {{-- <td>{{ $item->treatment->nama_treatment ?? '-' }}</td> --}}
                            {{-- <td>{{ $item->berat }} Kg</td> --}}
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>{{ $item->tanggal ?? $item->created_at->format('d-m-Y') }}</td>
                            <td>
                                <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection