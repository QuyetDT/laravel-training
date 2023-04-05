<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\ProductController;
// use App\Http\Middleware\AdminRole;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [HomeController::class, 'show_login']);
Route::post('/login', [HomeController::class, 'login']);
Route::get('/signup', [HomeController::class, 'show_signup']);
Route::post('/signup', [HomeController::class, 'signup']);
Route::get('/logout', [HomeController::class, 'logout']);
Route::get('/add_to_cart/{product_id}', [HomeController::class, 'add_to_cart']);
Route::get('/shopping_cart', [HomeController::class, 'shopping_cart']);
Route::get('/email_verify', [HomeController::class, 'verify_email'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware(['AdminRole', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
    Route::get('/products', [ProductController::class, 'get_list']);
    Route::get('/add_product', [ProductController::class, 'add']);
    Route::post('/create_product', [ProductController::class, 'create']);
    Route::get('/edit_product/{product_id}', [ProductController::class, 'edit']);
    Route::post('/update_product/{product_id}', [ProductController::class, 'update']);
    Route::get('/delete_product/{product_id}', [ProductController::class, 'delete']);
});