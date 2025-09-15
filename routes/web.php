<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\TreatmentController;
// Pelanggan Controllers
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController; // Alias untuk dashboard pelanggan
use App\Http\Controllers\Pelanggan\PelangganController as UserPelangganController;
use App\Http\Controllers\Pelanggan\TransaksiController as UserTransaksiController;
use App\Models\Transaksi;
use App\Mail\TransaksiSelesaiMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

Route::get('/test-fonnte', function () {
    $res = Http::withHeaders([
        'Authorization' => config('services.fonnte.token'),
    ])->post('https://api.fonnte.com/send', [
        'target'  => '6285865812892', // 👉 ganti dengan nomor WA tujuan, tanpa +
        'message' => 'Test kirim notifikasi dari Laravel 🚀',
    ]);

    return $res->json();
});

Route::get('/test-email', function () {
    $transaksi = Transaksi::with('user','layanan')->first(); // ambil 1 transaksi

    Mail::to('alamat_email_tujuan@gmail.com')
        ->send(new TransaksiSelesaiMail($transaksi));

    return "Email test terkirim ✅";
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================== ADMIN ==================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pelanggans', AdminPelangganController::class);
    Route::resource('layanans', LayananController::class);
    Route::resource('treatments', TreatmentController::class);
    Route::resource('transaksi', AdminTransaksiController::class);
    Route::resource('log-aktivitas', LogAktivitasController::class)->only(['index', 'destroy']);
    Route::resource('laporan', LaporanController::class)->only(['index', 'destroy']);
    Route::get('/laporan/cetak', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak.pdf');
});

// ================== PELANGGAN ==================
Route::prefix('pelanggan')->name('pelanggan.')->middleware(['auth', 'role:pelanggan'])->group(function () {
    // Gunakan alias PelangganDashboardController
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    // histori transaksi pelanggan
    Route::resource('transaksi', UserTransaksiController::class);
});

require __DIR__.'/auth.php';