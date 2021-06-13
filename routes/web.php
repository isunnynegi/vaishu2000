<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
	'register' => false,
	'verify' => false,
]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('category', App\Http\Controllers\CategoryController::class);
    Route::resource('product', App\Http\Controllers\ProductController::class);
    Route::resource('customer', App\Http\Controllers\CustomerController::class);
});
