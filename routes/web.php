<?php

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

Route::get('/', [HomeController::class, 'show']);

Route::get('/item', function (Request $request) {
    $itemcontroller = new ItemController;
    if($request->input('kategori') != '')
        return $itemcontroller->show_items_by_category($request);
    // else return $itemcontroller->get_all_items();
});

Route::get('/kategori', [KategoriController::class, 'show_all']);

Route::get('/simulasi', [SimulasiController::class, 'simulasi']);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');