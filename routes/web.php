<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataPelangganController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\LokasiTiangController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionRegisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# ------ Unauthenticated routes ------ #
Route::get('/', [PaketController::class, 'showLanding'])->name('landingPage');

Route::get('/register', [RegisteredUserController::class, 'create']);
require __DIR__.'/auth.php';


Route::get('/api/kota/{provinsiId}', [KotaController::class, 'kota']);
Route::get('/searchProvinsi', [RegisteredUserController::class, 'searchProvinsi']);

# ------ Authenticated routes ------ #
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [RouteController::class, 'dashboard'])
    ->name('home')
    ->middleware('auth', 'noCache'); # dashboard
    Route::prefix('profile')->group(function(){
        Route::get('/', [ProfileController::class, 'myProfile'])->name('profile');
        Route::put('/change-ava', [ProfileController::class, 'changeFotoProfile'])->name('change-ava');
        Route::put('/change-profile', [ProfileController::class, 'changeProfile'])->name('change-profile');
    }); # profile group

    Route::get('/data-pendaftar', [UserController::class, 'index'])->name('data-pendaftar.index');
    Route::put('/data-pendaftar/update/{id}', [UserController::class, 'update'])->name('data-pendaftar.update');
    Route::get('/data-pendaftar/send-notif/{wa}', [UserController ::class, 'sendNotif'])->name('data-pendaftar.send-notif');
    Route::post('/data-pendaftar/konfirmasi/{id}', [UserController ::class, 'konfirmasi'])->name('data-pendaftar.konfirmasi');
    Route::delete('/data-pendaftar/destroy/{id}', [UserController ::class, 'destroy'])->name('data-pendaftar.destroy');
    Route::get('/data-pendaftar/generate_pdf/{id}', [UserController ::class, 'pdf'])->name('data-pendaftar.generate_pdf');
    Route::get('/data-pendaftar/kirim-pesan/{id}', [UserController ::class, 'kirimPesan'])->name('data-pendaftar.kirim-pesan');
    Route::get('/data-pendaftar/bayar-paket/{id}/{orderId}', [UserController ::class, 'bayarPaket'])->name('data-pendaftar.bayar-paket');


    Route::get('/data-admin', [AdminController::class, 'index'])->name('data-admin.index');
    Route::get('/data-admin/create', [AdminController::class, 'create'])->name('data-admin.create');
    Route::post('/data-admin/store', [AdminController::class, 'store'])->name('data-admin.store');
    Route::get('/data-admin/edit/{id}', [AdminController::class, 'edit'])->name('data-admin.edit');
    Route::put('/data-admin/update/{id}', [AdminController::class, 'update'])->name('data-admin.update');
    Route::delete('/data-admin/destroy/{id}', [AdminController::class, 'destroy'])->name('data-admin.destroy');

    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
    Route::get('/paket/create', [PaketController::class, 'create'])->name('paket.create');
    Route::post('/paket/store', [PaketController::class, 'store'])->name('paket.store');
    Route::get('/paket/edit/{id}', [PaketController::class, 'edit'])->name('paket.edit');
    Route::put('/paket/update/{id}', [PaketController::class, 'update'])->name('paket.update');
    Route::delete('/paket/destroy/{id}', [PaketController::class, 'destroy'])->name('paket.destroy');
    Route::get('/landing-page-paket', [PaketController::class, 'showLanding'])->name('landing-page-paket');

    Route::get('/data-pelanggan', [DataPelangganController::class, 'index'])->name('data-pelanggan.index');
    Route::get('/data-pelanggan/create', [DataPelangganController::class, 'create'])->name('data-pelanggan.create');
    Route::post('/data-pelanggan/store', [DataPelangganController::class, 'store'])->name('data-pelanggan.store');
    Route::get('/data-pelanggan/edit/{id}', [DataPelangganController::class, 'edit'])->name('data-pelanggan.edit');
    Route::put('/data-pelanggan/update/{id}', [DataPelangganController::class, 'update'])->name('data-pelanggan.update');
    Route::delete('/data-pelanggan/destroy/{id}', [DataPelangganController::class, 'destroy'])->name('data-pelanggan.destroy');

    Route::get('/lokasi-tiang', [LokasiTiangController::class, 'index'])->name('lokasi-tiang.index');
    Route::get('/lokasi-tiang/create', [LokasiTiangController::class, 'create'])->name('lokasi-tiang.create');
    Route::post('/lokasi-tiang/store', [LokasiTiangController::class, 'store'])->name('lokasi-tiang.store');
    Route::get('/lokasi-tiang/edit/{id}', [LokasiTiangController::class, 'edit'])->name('lokasi-tiang.edit');
    Route::put('/lokasi-tiang/update/{id}', [LokasiTiangController::class, 'update'])->name('lokasi-tiang.update');
    Route::delete('/lokasi-tiang/destroy/{id}', [LokasiTiangController::class, 'destroy'])->name('lokasi-tiang.destroy');

    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/generate-pdf-report', [TransactionController::class, 'generatePDF']);
    Route::get('/word-paket', [TransactionController::class, 'generateExcel']);
    Route::get('/generate-word-report', [TransactionController::class, 'generateWord']);
    Route::get('/transaksi/bayar', [TransactionController::class, 'bayar'])->name('transaksi.bayar');
    Route::post('/transaksi/store', [TransactionController::class, 'store'])->name('transaksi.store');

    Route::get('/transaksi/regis', [TransactionRegisController::class, 'index'])->name('transaksi-regis.index');
    Route::get('/generate-pdf-report-regis', [TransactionRegisController::class, 'printPDF']);
    Route::get('/transactions/excel', [TransactionRegisController::class, 'downloadExcel'])->name('transactions-regis.excel');
    Route::get('/generate-word-report-regis', [TransactionRegisController::class, 'downloadWord']);
    Route::get('/transaksi/regis/bayar', [TransactionRegisController::class, 'bayar'])->name('transaksi-regis.bayar');
    Route::post('/transaksi/regis/store', [TransactionRegisController::class, 'store'])->name('transaksi-regis.store');
    // Route::get('//transactions-regis/word', [TransactionController::class, 'generateWord'])->name('transactions.word');


});
