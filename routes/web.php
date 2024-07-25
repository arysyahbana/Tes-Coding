<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\Petugas;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('admin.pages.dashboard');
// });
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('transaksi')->group(function () {
    Route::get('/show', [TransaksiController::class, 'index'])->name('transaksi.show');
    Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/edit/{id}', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::post('/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::get('/destroy/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
});

Route::prefix('barang')->group(function () {
    Route::get('/show', [BarangController::class, 'index'])->name('barang.show');
    Route::post('/store', [BarangController::class, 'store'])->name('barang.store');
    Route::post('/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::get('/destroy/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
});

Route::prefix('customer')->group(function () {
    Route::get('/show', [CustomerController::class, 'index'])->name('customer.show');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('/destroy/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
});

Route::prefix('petugas')->group(function () {
    Route::get('/show', [PetugasController::class, 'index'])->name('petugas.show');
    Route::post('/store', [PetugasController::class, 'store'])->name('petugas.store');
    Route::post('/update/{id}', [PetugasController::class, 'update'])->name('petugas.update');
    Route::get('/destroy/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/show', [UserController::class, 'index'])->name('users.show');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__ . '/auth.php';
