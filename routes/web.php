<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

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

/** rutas de la aplicación */
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/order/create/{product}', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/resume/{order}', [OrderController::class, 'resume'])->name('order.resume');
Route::get('/order/callback/{order}', [OrderController::class, 'callback'])->name('order.callback');
Route::get('/order/send/{order}', [OrderController::class, 'sendToPay'])->name('order.sendtopay');


/** Rutas del sitio admin */
require __DIR__.'/auth.php';
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
