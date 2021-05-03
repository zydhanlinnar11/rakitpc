<?php

use App\Http\Controllers\AdminController;
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
    if($request->input('item_id') != '')
        return $itemcontroller->show_an_item($request);
    return abort(404);
});

Route::get('/items', function (Request $request) {
    $itemcontroller = new ItemController;
        return $itemcontroller->show_items_by_category($request);
    return $itemcontroller->get_all_items();
});

Route::get('/kategori', [KategoriController::class, 'show_all']);

Route::get('/simulasi', [SimulasiController::class, 'simulasi']);

Route::get('/admin', [AdminController::class, 'dashboard']);

Route::get('/admin/tambah-produk', [AdminController::class, 'tambah_produk']);

Route::get('/admin/edit-produk', [AdminController::class, 'edit_produk']);

Route::get('/admin/daftar-produk', [AdminController::class, 'daftar_produk']);

Route::get('/admin/tambah-kategori', [AdminController::class, 'tambah_kategori']);

Route::get('/admin/daftar-kategori', [AdminController::class, 'daftar_kategori']);

Route::get('/admin/edit-kategori', [AdminController::class, 'edit_kategori']);

Route::get('/admin/tambah-subkategori', [AdminController::class, 'tambah_subkategori']);

Route::get('/admin/daftar-subkategori', [AdminController::class, 'daftar_subkategori']);

Route::get('/admin/edit-subkategori', [AdminController::class, 'edit_subkategori']);

Route::get('/admin/daftar-brand', [AdminController::class, 'daftar_brand']);

Route::get('/admin/edit-brand', [AdminController::class, 'edit_brand']);

Route::get('/admin/tambah-brand', [AdminController::class, 'tambah_brand']);

Route::get('/admin/tambah-socket', [AdminController::class, 'tambah_socket']);

Route::get('/admin/edit-socket', [AdminController::class, 'edit_socket']);

Route::get('/admin/daftar-socket', [AdminController::class, 'daftar_socket']);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');