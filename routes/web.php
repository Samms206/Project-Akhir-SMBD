<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TransactionController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/', [RouteController::class, 'index'])->name('dashboard');
Route::get('/login', [RouteController::class, 'login'])->name('login');
Route::get('/charts', [RouteController::class, 'gotoCharts'])->name('charts');
Route::get('/barang', [RouteController::class, 'gotoBarang'])->name('barang');
Route::get('/rollback-product', [RouteController::class, 'gotoRollbackProduct'])->name('rollback-product');
Route::get('/rollback-customer', [RouteController::class, 'gotoRollbackCustomer'])->name('rollback-customer');
Route::get('/transaksi', [RouteController::class, 'gotoTransaksi'])->name('transaction');
Route::get('/customer', [RouteController::class, 'gotoUser'])->name('customer');
Route::get('/report-transaction', [RouteController::class, 'gotoReportTransaction'])->name('report-transaction');
Route::get('/report-transaction/{id}', [RouteController::class, 'gotoDetailReportTransaction'])->name('detail-report-transaction');
Route::get('/report-product', [RouteController::class, 'gotoReportProduct'])->name('report-product');
Route::get('/report-product/{id}', [RouteController::class, 'gotoDetailReportProduct'])->name('detail-report-product');
Route::get('/export-report-transaction', [RouteController::class, 'exportReportTransaction'])->name('export-report-transaction');

//Auth
Route::post('/login-process', [AuthController::class, 'loginProses'])->name('login-process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//CRUD Barang
Route::get('/get-product-name/{id}', [ProductController::class, 'show'])->name('get-product-name');
Route::post('/add-product', [ProductController::class, 'store'])->name('add-product');
Route::put('/update-product/{id}', [ProductController::class, 'update'])->name('update-product');
Route::put('/rollback-product/{id}', [ProductController::class, 'rollbackProduct'])->name('rollback-product-execute');
Route::put('/delete-product/{id}', [ProductController::class, 'delete'])->name('delete-product');
Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('destroy-product');

//Transaction
Route::get('/add-to-cart/{id}', [TransactionController::class, 'addToCart'])->name('add-to-chart');
Route::post('/save-transaction', [TransactionController::class, 'store'])->name('save-transaction');
//validasi
Route::post('/check-stock', [TransactionController::class, 'checkStok'])->name('check-stock');


//CRUD User
Route::post('/add-customer', [CustomerController::class, 'store'])->name('add-customer');
Route::put('/update-customer/{id}', [CustomerController::class, 'update'])->name('update-customer');
Route::put('/rollback-customer/{id}', [CustomerController::class, 'rollbackCustomer'])->name('rollback-customer-execute');
Route::delete('/delete-customer/{id}', [CustomerController::class, 'destroy'])->name('delete-customer');

