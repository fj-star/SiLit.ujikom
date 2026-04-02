@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Karyawan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-total">{{ $stats['total_karyawan'] }} Orang</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir Hari Ini</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-hadir">{{ $stats['hadir'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-terlambat">{{ $stats['terlambat'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Izin/Sakit/Cuti</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-izin">{{ $stats['izin'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs card-header-tabs" id="absensiTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active font-weight-bold" id="hari-ini-tab" data-toggle="tab" href="#hari-ini" role="tab">Monitoring Hari Ini</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="riwayat-tab" data-toggle="tab" href="#riwayat" role="tab">Riwayat & Rekap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="rekap-tab" data-toggle="tab" href="#rekap" role="tab">Input Manual</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="absensiTabContent">
                        <div class="tab-pane fade show active" id="hari-ini" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Masuk</th>
                                            <th>Pulang</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($absensisHariIni as $a)
                                        <tr>
                                            <td><strong>{{ $a->user->name }}</strong></td>
                                            <td><span class="text-success font-weight-bold">{{ $a->jam_masuk ?? '--:--' }}</span></td>
                                            <td><span class="text-danger font-weight-bold">{{ $a->jam_keluar ?? '--:--' }}</span></td>
                                            <td>
                                                @php
                                                    $badge = [
                                                        'hadir' => 'success',
                                                        'terlambat' => 'warning',
                                                        'izin' => 'info',
                                                        'sakit' => 'primary',
                                                        'alpha' => 'danger'
                                                    ][$a->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge badge-{{ $badge }}">
                                                    {{ strtoupper($a->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.absensi.edit', $a->id) }}" class="btn btn-sm btn-warning btn-circle shadow-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada data hari ini.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $absensisHariIni->links() }}
                        </div>

                        <div class="tab-pane fade" id="riwayat" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Masuk</th>
                                            <th>Pulang</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($riwayatAbsensis as $a)
                                        <tr>
                                            <td><strong>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</strong></td>
                                            <td><strong>{{ $a->user->name }}</strong></td>
                                            <td><span class="text-success font-weight-bold">{{ $a->jam_masuk ?? '--:--' }}</span></td>
                                            <td><span class="text-danger font-weight-bold">{{ $a->jam_keluar ?? '--:--' }}</span></td>
                                            <td>
                                                @php
                                                    $badge = [
                                                        'hadir' => 'success',
                                                        'terlambat' => 'warning',
                                                        'izin' => 'info',
                                                        'sakit' => 'primary',
                                                        'alpha' => 'danger'
                                                    ][$a->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge badge-{{ $badge }}">
                                                    {{ strtoupper($a->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada data riwayat absensi.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $riwayatAbsensis->links() }}
                        </div>

                        <div class="tab-pane fade" id="rekap" role="tabpanel">
                            <form action="{{ route('admin.absensi.store_manual') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Pilih Karyawan</label>
                                            <select name="user_id" class="form-control" required>
                                                <option value="">-- Pilih Karyawan --</option>
                                                @foreach(\App\Models\User::where('role', 'karyawan')->get() as $u)
                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jam Masuk (Opsional)</label>
                                            <input type="time" name="jam_masuk" class="form-control" value="{{ date('H:i') }}">
                                            <small class="text-muted">Kosongkan jika ingin memakai waktu sekarang.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Status Presensi</label>
                                            <select name="status" class="form-control" required>
                                                <option value="hadir">Hadir (Tepat Waktu)</option>
                                                <option value="terlambat">Terlambat</option>
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="alpha">Alpha</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Keterangan / Alasan</label>
                                            <input type="text" name="keterangan" class="form-control" placeholder="Contoh: HP Rusak / Ban Bocor">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-block shadow-sm">
                                    <i class="fas fa-check-circle mr-1"></i> Submit Absensi Manual
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStats() {
        fetch('/admin/api/absensi-stats') 
            .then(response => response.json())
            .then(data => {
                document.getElementById('stat-total').innerText = data.total_karyawan + ' Orang';
                document.getElementById('stat-hadir').innerText = data.hadir;
                document.getElementById('stat-terlambat').innerText = data.terlambat;
                document.getElementById('stat-izin').innerText = data.izin;
            })
            .catch(error => console.error('Error fetching stats:', error));
    }
    setInterval(updateStats, 5000);
</script>
@endsection