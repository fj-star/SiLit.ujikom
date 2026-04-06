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
                    <a href="{{ route('admin.jam_kerja.index') }}" class="btn btn-sm btn-primary mt-2 mt-md-0 position-absolute" style="right: 1.25rem; top: 10px;">
                        <i class="fas fa-clock"></i> Atur Jam Kerja
                    </a>
                    <button type="button" class="btn btn-sm btn-info mt-2 mt-md-0 position-absolute" style="right: 10rem; top: 10px;" data-toggle="modal" data-target="#qrKioskModal">
                        <i class="fas fa-camera"></i> Kiosk Scanner
                    </button>
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
<div class="modal fade" id="qrKioskModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title font-weight-bold text-primary"><i class="fas fa-camera mr-2"></i>Kiosk Absensi InstaWash</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="stopScanner()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center pt-0">
        <p class="text-muted small mb-3">Arahkan QR Code karyawan ke kamera laptop ATAU gunakan Barcode Scanner fisik.</p>
        
        <!-- Input rahasia/fisik untuk Honeywell Scanner -->
        <input type="text" id="honeywell-input" class="form-control text-center font-weight-bold shadow-sm mb-3" placeholder="[Kursor Disini] Scan via Honeywell..." style="border: 2px dashed #4e73df; color: #4e73df;" autocomplete="off">

        <div id="reader" style="width: 100%; border-radius: 10px; overflow: hidden; border: 2px solid #4e73df;"></div>
        <div id="kiosk-status" class="mt-3 font-weight-bold" style="font-size: 1.2rem;"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;
    let isProcessing = false;
    const synth = window.speechSynthesis;

    function speak(text) {
        if (synth) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            synth.speak(utterance);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        if (typeof $ !== 'undefined') {
            $('#qrKioskModal').on('shown.bs.modal', function () {
                document.getElementById('kiosk-status').innerText = "";
                document.getElementById('kiosk-status').className = "mt-3 font-weight-bold";
                isProcessing = false;

                // Fokuskan input untuk input fisik Honeywell
                let hwInput = document.getElementById('honeywell-input');
                hwInput.value = '';
                hwInput.focus();

                // Paksa agar input terus menerus fokus, jaga-jaga kalau focusnya hilang dicolong elemen lain
                let keepFocusInterval = setInterval(function() {
                    if ($('#qrKioskModal').is(':visible')) {
                        hwInput.focus();
                    } else {
                        clearInterval(keepFocusInterval);
                    }
                }, 500); // Tiap 0.5 detik balikan focus

                // Render Kamera HANYA jika Browser memberikan izin (Secure Context = localhost / HTTPS)
                if (window.isSecureContext) {
                    html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                } else {
                    document.getElementById('reader').innerHTML = `
                        <div class="p-3 text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                            Browser memblokir Kamera karena diakses lewat IP Jaringan (bukan localhost/HTTPS).<br>
                            <b>Pastikan PC Admin mengakses lewat <code>http://localhost:2007</code> jika ingin menggunakan webcam.</b><br>
                            Saat ini Anda hanya bisa pakai Barcode Scanner Fisik.
                        </div>
                    `;
                }
            });

            $('#qrKioskModal').on('hidden.bs.modal', function () {
                stopScanner();
            });

            // Deteksi input dari scanner fisik Honeywell (yang nge-trigger Enter alias keyCode=13)
            $('#honeywell-input').on('keypress', function(e) {
                if (e.which === 13 || e.keyCode === 13) {
                    e.preventDefault();
                    let decodedText = $(this).val().trim();
                    if(decodedText !== '') {
                        $(this).val('');
                        onScanSuccess(decodedText, null);
                    }
                }
            });
        }
    });

    function onScanSuccess(decodedText, decodedResult) {
        if(isProcessing) return;
        isProcessing = true;
        
        let statusEl = document.getElementById('kiosk-status');
        statusEl.innerText = "Memproses...";
        statusEl.className = "mt-3 font-weight-bold text-info";

        fetch("{{ route('admin.absensi.scan_proses') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({ user_id: decodedText })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let greeting = data.message;
                let theMsg = `Terima kasih! Selamat datang, ${data.name}!`;
                if(data.type === 'pulang') {
                    theMsg = `Terima kasih! Hati hati di jalan, ${data.name}!`;
                }

                statusEl.innerText = data.message + ". " + theMsg;
                statusEl.className = "mt-3 font-weight-bold text-success";
                
                speak(theMsg);
                
                setTimeout(() => {
                    isProcessing = false;
                    statusEl.innerText = "Siap scan berikutnya...";
                    statusEl.className = "mt-3 font-weight-bold text-muted";
                }, 4000);
            } else {
                statusEl.innerText = data.message;
                statusEl.className = "mt-3 font-weight-bold text-danger";
                speak("Mohon maaf. " + data.message);
                
                setTimeout(() => {
                    isProcessing = false;
                }, 3000);
            }
        })
        .catch(err => {
            console.error(err);
            statusEl.innerText = "Terjadi kesalahan sistem.";
            statusEl.className = "mt-3 font-weight-bold text-danger";
            setTimeout(() => { isProcessing = false; }, 3000);
        });
    }

    function onScanFailure(error) {
        // Mute errors
    }

    function stopScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().catch(error => {
                console.error("Gagal clear scanner.", error);
            });
            html5QrcodeScanner = null;
        }
        window.location.reload();
    }
</script>

@endsection