<?php
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensi;
use App\Http\Controllers\AbsensiController as KaryawanAbsensi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MidtransCallbackController;

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\PelangganController as AdminPelanggan;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksi;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\JamKerjaController;

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\LaporanController as OwnerLaporan;

/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Karyawan\TransaksiController as KaryawanTransaksi;
use App\Http\Controllers\Karyawan\PelangganController as KaryawanPelanggan;

/*
|--------------------------------------------------------------------------
| PELANGGAN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboard;
use App\Http\Controllers\Pelanggan\TransaksiController as PelangganTransaksi;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle']);


/*
|--------------------------------------------------------------------------
| PROFILE (ALL AUTH USER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Izinkan semua pengguna yang login (Admin/Karyawan/Pelanggan) mengakses halaman bayar
    Route::get('/pelanggan/transaksi/{transaksi}/bayar', [PelangganTransaksi::class, 'bayarMidtrans'])->name('pelanggan.transaksi.bayar');
    Route::post('/pelanggan/transaksi/{transaksi}/force-paid', [PelangganTransaksi::class, 'forcePaid'])->name('pelanggan.transaksi.force_paid');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','role:admin'])
    ->group(function () {

    Route::get('/api/absensi-stats', [AdminAbsensi::class, 'getStats']);
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/absensi', [AdminAbsensi::class, 'index'])->name('absensi.index');
        Route::post('/absensi/scan-proses', [AdminAbsensi::class, 'scanProses'])->name('absensi.scan_proses');
        Route::resource('absensi', AdminAbsensi::class)->except(['create', 'store']);
        Route::get('/admin/absensi/{id}/edit', [AdminAbsensi::class, 'edit'])->name('admin.absensi.edit');
Route::put('/admin/absensi/{id}', [AdminAbsensi::class, 'update'])->name('admin.absensi.update');
        Route::post('/admin/absensi/manual', [AdminAbsensi::class, 'storeManual'])->name('absensi.store_manual');
Route::post('/absensi', [AdminAbsensi::class, 'store'])->name('absensi.store');
        Route::resource('pelanggans', AdminPelanggan::class);
        Route::resource('layanans', LayananController::class);
        Route::resource('treatments', TreatmentController::class);
        Route::get('transaksi/{transaksi}/invoice', [AdminTransaksi::class, 'invoice'])->name('transaksi.invoice');
        Route::resource('transaksi', AdminTransaksi::class);
        Route::resource('karyawan', KaryawanController::class);

        Route::get('/jam-kerja', [JamKerjaController::class, 'index'])->name('jam_kerja.index');
        Route::put('/jam-kerja', [JamKerjaController::class, 'update'])->name('jam_kerja.update');

        Route::resource('log-aktivitas', LogAktivitasController::class)
            ->only(['index','destroy']);

        Route::resource('laporan', AdminLaporan::class)
            ->only(['index','destroy']);

        Route::get('laporan/cetak', [AdminLaporan::class, 'cetakPdf'])
            ->name('laporan.cetak.pdf');
    });

/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::prefix('owner')
    ->name('owner.')
    ->middleware(['auth','role:owner'])
    ->group(function () {

        Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('dashboard');

        Route::get('/laporan', [OwnerLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [OwnerLaporan::class, 'pdf'])->name('laporan.pdf');
    });

/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
*/
Route::prefix('karyawan')
    ->name('karyawan.')
    ->middleware(['auth','role:karyawan'])
    ->group(function () {

        Route::get('/absensi', [KaryawanAbsensi::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [KaryawanAbsensi::class, 'store'])->name('absensi.store');
        Route::get('/absensi/qr-scan', [KaryawanAbsensi::class, 'qrScan'])->name('absensi.qr_scan');
        Route::get('/dashboard', [KaryawanDashboard::class, 'index'])->name('dashboard');
        Route::put('/transaksi/{transaksi}/konfirmasi-bayar', [KaryawanTransaksi::class, 'konfirmasiBayar'])->name('transaksi.konfirmasi-bayar');
        Route::get('transaksi/{transaksi}/invoice', [KaryawanTransaksi::class, 'invoice'])->name('transaksi.invoice');
        Route::resource('transaksi', KaryawanTransaksi::class);
        Route::resource('pelanggan', KaryawanPelanggan::class);
    });

/*
|--------------------------------------------------------------------------
| PELANGGAN
|--------------------------------------------------------------------------
*/
Route::prefix('pelanggan')
    ->name('pelanggan.')
    ->middleware(['auth','role:pelanggan'])
    ->group(function () {
        Route::get('/dashboard', [PelangganDashboard::class, 'index'])->name('dashboard');

        Route::get('transaksi/{transaksi}/invoice', [PelangganTransaksi::class, 'invoice'])->name('transaksi.invoice');
        Route::resource('transaksi', PelangganTransaksi::class);
    });


// Route::middleware('auth')->group(function () {
//     Route::get('/transaksi/{transaksi}/pay', [MidtransController::class, 'pay'])
//         ->name('midtrans.pay');
// });
require __DIR__.'/auth.php';
