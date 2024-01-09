<?php

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

Route::controller(App\Http\Controllers\PageController::class)->group(function(){
    Route::get('/', 'home');
    Route::get('/detail/{id}', 'detail');
    Route::get('/peminjaman', 'peminjaman')->middleware('auth');
    Route::get('/tambah', 'viewTambah')->can('admin');
});

Route::controller(App\Http\Controllers\UserController::class)->group(function(){
    Route::middleware(['guest'])->group(function () {
        Route::post('/login', 'login');
        Route::get('/login', 'viewLogin')->name('login');
        Route::post('/register', 'register');
        Route::get('/register', 'viewRegister');
    });
    Route::post('/logout', 'logout')->middleware('auth');
});

Route::controller(App\Http\Controllers\FeatureController::class)->group(function(){
    Route::middleware(['can:admin'])->group(function () {
        Route::post('/confirm/{id}', 'confirm');
        Route::post('/tambah', 'tambah');
        Route::post('/delete/{id}', 'delete');
        Route::post('/update/{id}', 'update');
    });
    Route::post('/detail/{id}', 'pinjam')->middleware('auth');
    Route::post('/cancel/{id}', 'cancel');
    Route::get('/baca/{id}', 'read');
});
