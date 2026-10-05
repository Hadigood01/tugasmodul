<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;


/*
|--------------------------------------------------------------------------
| LOGIN & REGISTER
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', function () {
    return redirect()->route('login');
});


// LOGIN PENGGUNA
Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.process');


// LOGIN ADMIN
Route::get('/admin/login', [
    AuthController::class,
    'showAdminLogin'
])->name('admin.login');

Route::post('/admin/login', [
    AuthController::class,
    'loginAdmin'
])->name('admin.login.process');


// REGISTER
Route::get('/register', [
    AuthController::class,
    'showRegister'
])->name('register');

Route::post('/register', [
    AuthController::class,
    'register'
])->name('register.store');


// LOGOUT
Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


    /*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/

Route::get('/laporan', [
    PeminjamanController::class,
    'laporanIndex'
])->name('laporan.index');

Route::get('/laporan/pdf', [
    PeminjamanController::class,
    'laporanPdf'
])->name('laporan.pdf');

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            AdminController::class,
            'dashboard'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | BARANG
        |--------------------------------------------------------------------------
        */

        Route::resource('barang', BarangController::class);


        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        Route::get('/peminjaman', [
            PeminjamanController::class,
            'adminIndex'
        ])->name('peminjaman.index');


        /*
        |--------------------------------------------------------------------------
        | SETUJUI PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        Route::post('/peminjaman/{peminjaman}/setujui', [
            PeminjamanController::class,
            'setujuiPeminjaman'
        ])->name('peminjaman.setujui');


        /*
        |--------------------------------------------------------------------------
        | TOLAK PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        Route::post('/peminjaman/{peminjaman}/tolak', [
            PeminjamanController::class,
            'tolakPeminjaman'
        ])->name('peminjaman.tolak');


        /*
        |--------------------------------------------------------------------------
        | PENGEMBALIAN
        |--------------------------------------------------------------------------
        */

        Route::get('/pengembalian', [
            PeminjamanController::class,
            'pengembalianIndex'
        ])->name('pengembalian.index');

        Route::post('/pengembalian/{peminjaman}', [
            PeminjamanController::class,
            'pengembalian'
        ])->name('pengembalian.proses');


        /*
        |--------------------------------------------------------------------------
        | DENDA
        |--------------------------------------------------------------------------
        */

        Route::get('/denda', [
            PeminjamanController::class,
            'dendaIndex'
        ])->name('denda.index');


        /*
        |--------------------------------------------------------------------------
        | LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::get('/laporan', [
            PeminjamanController::class,
            'laporanIndex'
        ])->name('laporan.index');
    });


/*
|--------------------------------------------------------------------------
| PENGGUNA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pengguna'])
    ->prefix('pengguna')
    ->name('pengguna.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            PenggunaController::class,
            'dashboard'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | BARANG
        |--------------------------------------------------------------------------
        */

        Route::get('/barang', [
            BarangController::class,
            'penggunaIndex'
        ])->name('barang');


        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        Route::get('/peminjaman', [
            PeminjamanController::class,
            'index'
        ])->name('peminjaman.index');

        Route::get('/peminjaman/create', [
            PeminjamanController::class,
            'create'
        ])->name('peminjaman.create');

        Route::post('/peminjaman', [
            PeminjamanController::class,
            'store'
        ])->name('peminjaman.store');

        Route::get('/peminjaman/{peminjaman}', [
            PeminjamanController::class,
            'show'
        ])->name('peminjaman.show');


        /*
        |--------------------------------------------------------------------------
        | PENGEMBALIAN
        |--------------------------------------------------------------------------
        */

        Route::get('/pengembalian', [
            PeminjamanController::class,
            'pengembalianPenggunaIndex'
        ])->name('pengembalian.index');

        Route::post('/pengembalian/{peminjaman}/ajukan', [
            PeminjamanController::class,
            'ajukanPengembalian'
        ])->name('pengembalian.ajukan');
    });