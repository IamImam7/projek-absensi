<?php

use App\Http\Livewire\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Import semua komponen Livewire yang digunakan sebagai halaman penuh
use App\Http\Livewire\Cuti\ManajemenCuti;
use App\Http\Livewire\Cuti\PengajuanCuti;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Karyawan\ListKaryawan;
use App\Http\Livewire\Absensi\RiwayatAbsensi;
use App\Http\Livewire\Settings\ManageSettings;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Jika user sudah login, arahkan ke dashboard.
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    // Jika belum, tampilkan halaman welcome.
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Ini adalah satu-satunya cara yang benar untuk mendaftarkan rute ini
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Umum
    Route::get('/absensi/riwayat', RiwayatAbsensi::class)->name('absensi.riwayat');
    Route::get('/laporan/absensi/excel', [ReportController::class, 'exportExcel'])->name('laporan.absensi.excel');
    Route::get('/laporan/absensi/pdf', [ReportController::class, 'exportPdf'])->name('laporan.absensi.pdf');

    // Rute Karyawan
    Route::middleware(['role:karyawan'])->group(function () {
        Route::get('/cuti/pengajuan', PengajuanCuti::class)->name('cuti.pengajuan');
    });

    // Rute Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/karyawan', ListKaryawan::class)->name('karyawan.index');
        Route::get('/cuti/manajemen', ManajemenCuti::class)->name('cuti.manajemen');
         Route::get('/pengaturan', ManageSettings::class)->name('settings.index');
    });
});

require __DIR__.'/auth.php';
