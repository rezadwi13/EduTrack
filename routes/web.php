<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\MenuPermissionController;
use App\Http\Controllers\GuruController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\CaptchaController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Profile (semua user)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin only routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/guru/export-excel', [\App\Http\Controllers\GuruController::class, 'exportExcel'])->name('guru.export-excel');
    Route::get('/guru/export-pdf', [\App\Http\Controllers\GuruController::class, 'exportPdf'])->name('guru.export-pdf');
    // Export routes (letakkan di atas agar tidak tertindih resource)
    Route::get('/siswa/export-excel', [\App\Http\Controllers\SiswaController::class, 'exportExcel'])->name('siswa.export-excel');
    Route::get('/siswa/export-pdf', [\App\Http\Controllers\SiswaController::class, 'exportPdf'])->name('siswa.export-pdf');
    // Resource route
    Route::resource('users', UserController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('galeri', GaleriController::class);
    Route::resource('menu-permissions', MenuPermissionController::class);
    Route::patch('menu-permissions/{menuPermission}/toggle-status', [MenuPermissionController::class, 'toggleStatus'])->name('menu-permissions.toggle-status');
    Route::resource('siswa', SiswaController::class);
});

// Admin & Guru routes
Route::middleware(['auth', RoleMiddleware::class . ':admin,guru'])->group(function () {
    Route::get('/nilai/export-excel', [\App\Http\Controllers\NilaiController::class, 'exportExcelGuru'])->name('nilai.export-excel-guru');
    Route::get('/nilai/export-pdf', [\App\Http\Controllers\NilaiController::class, 'exportPdfGuru'])->name('nilai.export-pdf-guru');
    Route::resource('nilai', NilaiController::class);
    Route::get('/jadwal-pelajaran/export-pdf', [\App\Http\Controllers\JadwalPelajaranController::class, 'exportPdf'])->name('jadwal-pelajaran.export-pdf');
    Route::resource('jadwal-pelajaran', JadwalPelajaranController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('mata-pelajaran', MataPelajaranController::class);
    Route::resource('pengumuman', PengumumanController::class);
    
    // Route untuk melihat siswa berdasarkan mata pelajaran
    Route::get('mata-pelajaran/{mataPelajaran}/siswa', [MataPelajaranController::class, 'showSiswa'])->name('mata-pelajaran.siswa');
    
    // Routes untuk relasi many-to-many Siswa-Ekstrakurikuler
    Route::get('siswa/{siswa}/ekstrakurikuler', [SiswaController::class, 'showEkstrakurikuler'])->name('siswa.ekstrakurikuler');
    Route::post('siswa/{siswa}/add-ekstrakurikuler', [SiswaController::class, 'addEkstrakurikuler'])->name('siswa.add-ekstrakurikuler');
    Route::post('siswa/{siswa}/remove-ekstrakurikuler', [SiswaController::class, 'removeEkstrakurikuler'])->name('siswa.remove-ekstrakurikuler');
});

// Ekstrakurikuler routes (Admin & Guru can manage, Siswa can view/register)
Route::middleware(['auth'])->group(function () {
    // Admin & Guru can manage ekstrakurikuler
    Route::middleware([RoleMiddleware::class . ':admin,guru'])->group(function () {
        Route::resource('ekstrakurikuler', EkstrakurikulerController::class);
        
        // Routes untuk relasi many-to-many Ekstrakurikuler-Siswa
        Route::get('ekstrakurikuler/{ekstrakurikuler}/siswa', [EkstrakurikulerController::class, 'showSiswa'])->name('ekstrakurikuler.siswa');
        Route::post('ekstrakurikuler/{ekstrakurikuler}/add-siswa', [EkstrakurikulerController::class, 'addSiswa'])->name('ekstrakurikuler.add-siswa');
        Route::post('ekstrakurikuler/{ekstrakurikuler}/remove-siswa', [EkstrakurikulerController::class, 'removeSiswa'])->name('ekstrakurikuler.remove-siswa');
    });
    
    // Siswa can view and register for ekstrakurikuler
    Route::middleware([RoleMiddleware::class . ':siswa'])->group(function () {
        Route::get('/ekstrakurikuler-siswa', [EkstrakurikulerController::class, 'indexSiswa'])->name('ekstrakurikuler_siswa');
        Route::post('ekstrakurikuler-siswa/daftar/{ekstrakurikuler}', [EkstrakurikulerController::class, 'daftarSiswa'])->name('ekstrakurikuler.siswa.daftar');
    });
});

// Siswa only routes
Route::middleware(['auth', RoleMiddleware::class . ':siswa'])->group(function () {
    Route::get('/galeri-siswa', [GaleriController::class, 'indexSiswa'])->name('galeri_siswa');
    Route::get('/pengumuman-siswa', [PengumumanController::class, 'indexSiswa'])->name('pengumuman_siswa');
    Route::get('nilai-siswa', [NilaiController::class, 'siswa'])->name('nilai.siswa');
    Route::get('jadwal-siswa', [JadwalPelajaranController::class, 'siswa'])->name('jadwal-pelajaran.siswa');
    Route::get('jadwal-pelajaran/export-pdf', [JadwalPelajaranController::class, 'exportPdf'])->name('jadwal-pelajaran.export-pdf');
});

Route::get('captcha', [CaptchaController::class, 'show'])->name('captcha');

require __DIR__.'/auth.php';
