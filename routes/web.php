<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


Route::get('/products', function() {
   return view('partials.products');
});

Route::get('/price-update', function() {
    return view('partials.price-update');
});


Route::controller(ShopifyController::class)->prefix('Shopify')->group(function() {
    Route::post('/products','createProduct');
    Route::get('/products', 'getProductList');
    Route::get('/products/{id}',  'getProduct');
    Route::put('/products/{id}', 'updateProduct');
});


