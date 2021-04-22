<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SimulasiController;
use Illuminate\Http\Request;
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

Route::get('/', function() {
    return redirect('/kategori');
});

Route::get('/item', function (Request $request) {
    $itemcontroller = new ItemController;
    if($request->input('kategori') != '')
        return $itemcontroller->show_items_by_category($request);
    // else return $itemcontroller->get_all_items();
});

Route::get('/kategori', [KategoriController::class, 'show_all']);

Route::get('/simulasi', [SimulasiController::class, 'simulasi']);

Route::get('/admin', [AdminController::class, 'dashboard']);

Route::get('/admin/daftar-produk', [AdminController::class, 'daftar_produk']);

Route::get('/admin/tambah-kategori', [AdminController::class, 'tambah_kategori']);

Route::get('/admin/daftar-kategori', [AdminController::class, 'daftar_kategori']);

Route::get('/admin/edit-kategori', [AdminController::class, 'edit_kategori']);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');