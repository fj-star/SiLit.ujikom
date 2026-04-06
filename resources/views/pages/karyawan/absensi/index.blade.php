@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-lg mb-4">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0 font-weight-bold">Presensi QR InstaWash</h5>
                </div>
                <div class="card-body text-center">
                    @if(!$sudah_absen || ($sudah_absen && !$sudah_absen->jam_keluar))
                        <div class="py-4">
                            <i class="fas fa-fingerprint text-primary fa-5x mb-4"></i>
                            <h5 class="font-weight-bold mb-3">Pilih Metode Presensi</h5>
                            
                            <button type="button" class="btn btn-info btn-lg btn-block shadow-sm mb-3" data-toggle="modal" data-target="#qrScannerModal">
                                <i class="fas fa-qrcode mr-2"></i> Tampilkan QR Code Saya
                            </button>

                            <form id="form-absen" action="{{ route('karyawan.absensi.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-lg btn-block shadow-sm">
                                    <i class="fas fa-hand-pointer mr-2"></i> Absen Manual (Tombol)
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="py-4">
                            <i class="fas fa-check-double text-success fa-5x mb-4"></i>
                            <h5 class="font-weight-bold text-success mb-3">Anda Sudah Menyelesaikan Presensi Hari Ini</h5>
                            <p class="text-muted">Terima kasih atas kerja keras Anda. Selamat beristirahat!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Kehadiran Karyawan -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow mb-4 border-0">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history mr-2"></i>Riwayat Kehadiran Anda</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($absensis as $absen)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <span class="text-success font-weight-bold">{{ $absen->jam_masuk ?? '--:--' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-danger font-weight-bold">{{ $absen->jam_keluar ?? '--:--' }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badge = [
                                                'hadir' => 'success',
                                                'terlambat' => 'warning',
                                                'izin' => 'info',
                                                'sakit' => 'primary',
                                                'alpha' => 'danger'
                                            ][$absen->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $badge }}">{{ ucfirst($absen->status) }}</span>
                                    </td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada riwayat absensi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination jika ada -->
                    <div class="mt-3">
                        {{ $absensis->links() ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="qrScannerModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title font-weight-bold text-primary"><i class="fas fa-qrcode mr-2"></i>QR Code Presensi Anda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center pt-0">
        <p class="text-muted small mb-3">Tunjukkan QR Code ini ke Webcam Admin InstaWash.</p>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ auth()->user()->id }}" alt="QR Karyawan" class="img-fluid border shadow-sm p-2 mb-3">
        <h5 class="font-weight-bold">{{ auth()->user()->name }}</h5>
      </div>
    </div>
  </div>
</div>

@endsection