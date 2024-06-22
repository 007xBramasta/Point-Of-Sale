<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->middleware('auth');

// Route::get('/level', [LevelController::class, 'index']);

Route::prefix('kategori')->middleware('auth')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});


Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index'); //menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list'])->name('user.list'); //ambil data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create'])->name('user.create'); //menampilkan halaman form tambah
    Route::post('/', [UserController::class, 'store'])->name('user.store'); //menyimpan data user
    Route::get('/{id}', [UserController::class, 'show'])->name('user.show'); //menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); //menampilkan halaman form edit
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update'); //mengupdate data user
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy'); //menghapus data user
    Route::get('/download/pdf', [UserController::class, 'exportPdf'])->name('user.pdf'); //export data user ke pdf
    Route::get('/download/excel', [UserController::class, 'exportExcel'])->name('user.excel'); //export data user ke excel
});


Route::resource('barang', BarangController::class)->middleware('auth');

Route::resource('stok', StokController::class)->middleware('auth');

Route::resource('penjualan', PenjualanController::class)->middleware('auth');

Route::resource('penjualan_detail', PenjualanDetailController::class)->middleware('auth');


Route::resource('level', LevelController::class)->middleware('auth');


// Login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticate']);
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'store']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
