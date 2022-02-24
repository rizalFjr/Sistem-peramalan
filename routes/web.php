<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\BarangController;
use App\Http\Controllers\Backend\PenjualanController;
use App\Http\Controllers\Backend\PeramalanController;

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

Route::middleware(['auth:sanctum', 'role:admin'])
     ->group(function (){
         Route::get('/', [DashboardController::class, 'index']);
         Route::resource('users', UserController::class);
         Route::resource('role', RoleController::class);
         Route::resource('barang', BarangController::class);
         Route::resource('penjualan', PenjualanController::class);
         Route::post('penjualan/detail', [PenjualanController::class, 'detail'])->name('penjualan.detail');
         Route::get('penjualan/data-detail/{tahun}/{barang_id}', [PenjualanController::class, 'dataDetail'])->name('penjualan.data-detail');

         Route::get('peramalan', [PeramalanController::class, 'index'])->name('peramalan');
         Route::post('peramalan/hitung', [PeramalanController::class, 'hitung'])->name('hitung');
     });



require __DIR__.'/auth.php';
