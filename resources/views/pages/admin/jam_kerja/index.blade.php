@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Jam Kerja</h1>
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Absensi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Atur Jadwal Masuk dan Pulang</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jam_kerja.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Jam Masuk (Batas Waktu)</label>
                            <input type="time" name="jam_masuk" class="form-control" value="{{ $jamKerja->jam_masuk ?? '08:00' }}" required>
                            <small class="text-muted">Karyawan yang absen lewat jam ini akan "Terlambat".</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Toleransi Keterlambatan (Menit)</label>
                            <input type="number" name="menit_toleransi" min="0" class="form-control" value="{{ $jamKerja->menit_toleransi ?? 0 }}" required>
                            <small class="text-danger">Lewat dari batas ini = absen DITOLAK.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Jam Pulang</label>
                            <input type="time" name="jam_pulang" class="form-control" value="{{ $jamKerja->jam_pulang ?? '17:00' }}" required>
                            <small class="text-muted">Waktu pulang resmi.</small>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
