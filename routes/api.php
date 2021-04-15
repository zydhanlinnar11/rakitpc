<?php

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/items', function (Request $request) {
    $items = DB::table('items');
    
    $kategori_query = $request->input('kategori');
    if($kategori_query != '') {
        $id_kategori = kategori::where('url', $kategori_query)->get()[0]['id'];
        $items->where('id_kategori', '=', $id_kategori)->get();
    }

    return $items->get();
});

Route::get('/kategori', function () {
    return DB::table('kategoris')->get();
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
