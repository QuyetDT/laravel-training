<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;

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

//frontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

//admin
Route::get('/login', [AdminController::class, 'login']);
Route::get('/dashboard', [AdminController::class, 'index']);
Route::post('/dashboard', [AdminController::class, 'dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);

//product
Route::get('/products', [ProductController::class, 'get_list']);
Route::get('/add_product', [ProductController::class, 'add']);
Route::post('/create_product', [ProductController::class, 'create']);
Route::get('/delete_product', [ProductController    ::class, 'delete_product']);


