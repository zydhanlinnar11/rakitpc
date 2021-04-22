<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
        $id_kategori = DB::table('kategoris')->where('url', $kategori_query)->get()[0]->id;
        $items->where('id_kategori', '=', $id_kategori)->get();
    }

    return $items->get();
});

Route::get('/kategori', function () {
    return DB::table('kategoris')->get();
});

Route::post('/admin/tambah-kategori', function(Request $request) {
    $nama = $request->nama;
    $slug = Str::slug($nama);
    $fa_class = $request->faClass;
    $tabel_kategori = DB::table('kategoris');

    if($nama == 'NULL')
        return response()->json(['message' => "Nama can't be empty."], 400);
    if($fa_class == 'NULL')
        return response()->json(['message' => "Fa class can't be empty."], 400);

    if($tabel_kategori->where('url', '=', $slug)->count() > 0)
        return response()->json([
            'message' => 'Row has already exists.'
        ], 400);

    $tabel_kategori->upsert(
        ['nama' => $nama, 'url' => $slug,  'fa_class' => $fa_class], ['url']
    );

    return response()->json([
        'message' => 'Category added.'
    ], 200);
});

Route::patch('/admin/edit-kategori', function(Request $request) {
    $nama = $request->nama;
    $slug = Str::slug($nama);
    $fa_class = $request->faClass;
    $id_kategori = $request->idKategori;
    $tabel_kategori = DB::table('kategoris');
    $kategori = $tabel_kategori->where('id', '=', $id_kategori);

    if($kategori->count() != 1)
        return response()->json(['message' => "Category doesn't exist."], 400);
    if($nama == 'NULL')
        return response()->json(['message' => "Nama can't be empty."], 400);
    if($fa_class == 'NULL')
        return response()->json(['message' => "Fa class can't be empty."], 400);

    $tabel_kategori->upsert(
        ['id' => $id_kategori, 'nama' => $nama, 'url' => $slug, 'fa_class' => $fa_class],
        ['id_kategori'],
        ['nama', 'url', 'fa_class']
    );
    
    return response()->json([
        'message' => 'Category edited.'
    ], 200);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
