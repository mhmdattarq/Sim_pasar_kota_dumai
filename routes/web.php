<?php

// Route Frontend Simpasar
use App\Http\Controllers\HomeController; // menuju frontend
use App\Http\Controllers\PpayungController; // menuju pasar pulaupayung
use App\Http\Controllers\TamanlepinController; // menuju pasar tamanlepin
use App\Http\Controllers\KelakapController; // menuju pasar kelakaptujuh
use App\Http\Controllers\SenggolController; // menuju pasar senggol
use App\Http\Controllers\TarifController; // menuju tarif
use App\Http\Controllers\RegulasiController; // menuju regulasi

// Route Login
use App\Http\Controllers\AuthController; // menuju login


// Route Pembuatan akun pedagang dan backend pedagang
use App\Http\Controllers\Auth\PedagangAccountController; //routing menuju pembuatan akun pedagang
use App\Http\Controllers\Auth\PedagangRegistrasiController; // routing menuju pendaftaran pedagang
use App\Http\Controllers\Pedagang\PedagangDashboardController; // routing menuju dashboard pedagang
use App\Http\Controllers\Pedagang\PermohonanController; //proses permohonan
use App\Http\Controllers\Pedagang\UploadpermohonanController; //proses upload permohonan


// Route backend admin
use App\Http\Controllers\DashboardController; // menuju dashboard admin
use App\Http\Controllers\PasarController; // menuju pasar admin
use App\Http\Controllers\KiosController; // menuju kios admin
use App\Http\Controllers\LosController; // menuju loss admin
use App\Http\Controllers\PelataranController; // menuju pelataran admin
use App\Http\Controllers\Admin\AccPermohonanController; // menuju pedagang admin
use Illuminate\Support\Facades\Route;



//Frontend Simpasar
// mengarah ke home
Route::get('/', [HomeController::class, 'index'])->name('frontend.pages.home');
// mengarah ke pasar
Route::get('/pasar_pulau_payung', [PpayungController::class, 'PP'])->name('frontend.pages.pulaupayung');
Route::get('/pasar_taman_lepin', [TamanlepinController::class, 'TL'])->name('frontend.pages.tamanlepin');
Route::get('/pasar_kelakap_tujuh', [KelakapController::class, 'kelakap'])->name('frontend.pages.kelakap');
Route::get('/pasar_senggol', [SenggolController::class, 'senggol'])->name('frontend.pages.senggol');
// mengarah ke tarif restribusi
Route::get('/tarif_restribusi', [TarifController::class, 'tarif'])->name('frontend.pages.tarif');
// mengarah ke regulasi
Route::get('/regulasi', [RegulasiController::class, 'regulasi'])->name('frontend.pages.regulasi');

//login dan logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//routing pendaftaran pedagang
Route::get('/pendaftaran/pedagang', [PedagangRegistrasiController::class, 'showForm'])->name('backend_pedagang.auth.register');
Route::get('/get-tempat/{pasarId}', [\App\Http\Controllers\Auth\PedagangRegistrasiController::class, 'getTempatByPasar']);
Route::get('/get-luas/{tipe}/{id}', [PedagangRegistrasiController::class, 'getLuas']);
Route::post('/pendaftaran', [PedagangRegistrasiController::class, 'register'])->name('register.post');

//routing register admin
Route::get('/registeradmin', [AuthController::class, 'showRegisterFormAdmin'])->name('backend_admin.auth.register');
Route::post('/registeradmin', [AuthController::class, 'registerAdmin'])->name('registerAdmin.post');

// middleware dan seluruh fungsi dan tampilan backend admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    //dashboard
    Route::get('/dashboard/admin', [DashboardController::class, 'AdminDashboard'])->name('backend_admin.pages.dashboard');
    //pasar
    Route::get('/penambahan_pasar', [PasarController::class, 'create'])->name('backend_admin.pages.pasar.tambah');
    Route::post('/pasar/store', [PasarController::class, 'store'])->name('pasar.store');
    Route::get('/detail_pasar', [PasarController::class, 'table'])->name('backend_admin.pages.pasar.table');
    //kios
    Route::get('/penambahan_kios', [KiosController::class, 'create'])->name('backend_admin.pages.kios.tambah');
    Route::post('/kios/store', [KiosController::class, 'store'])->name('kios.store');
    Route::get('/detail_kios', [KiosController::class, 'table'])->name('backend_admin.pages.kios.table');
    //los
    Route::get('/penambahan_los', [LosController::class, 'create'])->name('backend_admin.pages.los.tambah');
    Route::post('/los/store', [LosController::class, 'store'])->name('los.store');
    Route::get('/detail_los', [LosController::class, 'table'])->name('backend_admin.pages.los.table');
    //pelataran
    Route::get('/penambahan_pelataran', [PelataranController::class, 'create'])->name('backend_admin.pages.pelataran.tambah');
    Route::post('/pelataran/store', [PelataranController::class, 'store'])->name('pelataran.store');
    Route::get('/detail_pelataran', [PelataranController::class, 'table'])->name('backend_admin.pages.pelataran.table');
    //pedagang
    Route::get('/list/permohonan', [AccPermohonanController::class, 'showTable'])->name('backend_admin.pages.pedagang.tabelpermohonan');
});

// middleware dan seluruh fungsi dan tampilan backend pedagang
Route::middleware(['auth', 'role:pedagang'])->group(function () {
    //dashboard
    Route::get('/dashboard/pedagang', [PedagangDashboardController::class, 'PedagangDashboard'])->name('backend_pedagang.pages.dashboard');
    // pembuatan surat permohonan
    Route::get('/permohonan', [PermohonanController::class, 'showForm'])->name('backend_pedagang.pages.permohonan');
    Route::get('/get-tempat/{pasarId}', [PermohonanController::class, 'getTempatByPasar']);
    Route::get('/get-luas/{tipe}/{id}', [PermohonanController::class, 'getLuas']);
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/preview-surat', [PermohonanController::class, 'previewSurat'])->name('preview.surat');
    Route::get('/pedagang/permohonan/success/{id}', [PermohonanController::class, 'success'])
        ->name('pedagang.permohonan.success');
    Route::get('/permohonan/download/{id}', [\App\Http\Controllers\Pedagang\PermohonanController::class, 'download'])
        ->name('pedagang.permohonan.download');

    //upload surat permohonan
    Route::get('/upload/permohonan', [UploadpermohonanController::class, 'showTable'])->name('backend_pedagang.pages.uploadpermohonan');
    Route::post('/upload-permohonan', [UploadpermohonanController::class, 'store'])->name('uploadpermohonan.store');
});