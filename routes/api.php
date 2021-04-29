<?php

use Illuminate\Database\QueryException;
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
Route::get('/subkategori', function(Request $request) {
    try {
        $tabel_subkategori = DB::table('subcategories')->select(['id','nama']);
        $id_kategori = $request->input('id_kategori');
    
        if($id_kategori != '')
            $tabel_subkategori->where('id_kategori', '=', $id_kategori);
    
        $tabel_subkategori = $tabel_subkategori->get();
    
        return $tabel_subkategori;
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::get('/items', function (Request $request) {
    try {
        $items = DB::table('items');
        $kategori_query = $request->input('kategori');
        if($kategori_query != '') {
            $id_kategori = DB::table('kategoris')->where('url', $kategori_query)->get()[0]->id;
            $items->where('id_kategori', '=', $id_kategori)->get();
        }
        return $items->get();
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::get('/kategori', function () {
    try {
        return DB::table('kategoris')->get();
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::post('/admin/tambah-kategori', function(Request $request) {
    try {
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
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }

});

Route::patch('/admin/edit-kategori', function(Request $request) {
    try {
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
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
    
});

Route::post('/admin/tambah-subkategori', function(Request $request) {
    try {
        $nama = $request->nama;
        $slug = Str::slug($nama);
        $deskripsi = $request->deskripsi;
        $id_kategori = $request->idKategori;
        $tabel_subkategori = DB::table('subcategories');
        if($tabel_subkategori->where('slug', '=', $slug)->get()->count() > 0)
            return response()->json(['message' => 'Subcategory already exists.'], 400);
        if($deskripsi == NULL)
            $deskripsi = '-';
            
        $tabel_subkategori->upsert(
            [
                'nama' => $nama,
                'slug' => $slug,
                'deskripsi' => $deskripsi,
                'id_kategori' => $id_kategori
            ],
            ['slug']
        );
        return response()->json(['message' => 'Subcategory added.'], 200);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::post('/admin/tambah-brand', function(Request $request) {
    try {
        $nama = $request->nama;
        $deskripsi = $request->deskripsi;
        $tabel_brand = DB::table('brands');
        if($tabel_brand->where('nama', '=', $nama)->get()->count() > 0)
            return response()->json(['message' => 'Brand already exists.'], 400);
    
        if($deskripsi == NULL)
            $deskripsi = '-';
            
        $tabel_brand->upsert(
            [
                'nama' => $nama,
                'deskripsi' => $deskripsi
            ],
            ['nama']
        );
        return response()->json(['message' => 'Brand added.'], 200);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::post('/admin/tambah-produk', function(Request $request) {
    $nama = $request->nama;
    $berat = $request->berat;
    $harga = $request->harga;
    $stok = $request->stok;
    $URL_gambar = $request->URLGambar;
    $id_kategori = $request->kategori;
    $id_brand = $request->brand;
    $id_subkategori = $request->subkategori;
    $id_socket = $request->socket;
    $deskripsi = $request->deskripsi;
    try {
        $tabel_item = DB::table('items');
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }

    if($nama == null)
        return response()->json(['message' => "Nama can't be empty"], 400);
    if($berat == null)
        return response()->json(['message' => "Berat can't be empty"], 400);
    if($harga == null)
        return response()->json(['message' => "Harga can't be empty"], 400);
    if($stok == null)
        return response()->json(['message' => "Stok can't be empty"], 400);
    if($URL_gambar == null)
        return response()->json(['message' => "Gambar can't be empty"], 400);
    if($id_kategori == null)
        return response()->json(['message' => "Kategori can't be empty"], 400);
    if($id_brand == null)
        return response()->json(['message' => "Brand can't be empty"], 400);
    if($id_subkategori == null)
        return response()->json(['message' => "Subkategori can't be empty"], 400);
    try {
        $url_kategori = DB::table('kategoris')->where('id', '=', $id_kategori)->get()[0]->url;
        if($id_socket == null && ($url_kategori == 'prosesor' || $url_kategori == 'motherboard'))
            return response()->json(['message' => "Socket can't be empty if this is a processor or motherboard"], 400);
    
        if($tabel_item->where('nama', '=', $nama)->get()->count() > 0)
            return response()->json(['message' => 'Product already exists.'], 400);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }

    if($deskripsi == NULL)
        $deskripsi = '-';

    $obj = [
        'nama' => $nama,
        'berat' => $berat,
        'harga' => $harga,
        'stok' => $stok,
        'URL_gambar' => $URL_gambar,
        'id_kategori' => $id_kategori,
        'id_brand' => $id_brand,
        'id_subkategori' => $id_subkategori,
        'id_socket' => $id_socket,
        'deskripsi' => $deskripsi
    ];
        
    try {
        $tabel_item->upsert($obj, ['nama']);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }

    return response()->json(['message' => 'Product added.'], 200);
});

Route::patch('/admin/edit-produk', function(Request $request) {
    $id = $request->id;
    $nama = $request->nama;
    $berat = $request->berat;
    $harga = $request->harga;
    $stok = $request->stok;
    $URL_gambar = $request->URLGambar;
    $id_kategori = $request->kategori;
    $id_brand = $request->brand;
    $id_subkategori = $request->subkategori;
    $id_socket = $request->socket;
    $deskripsi = $request->deskripsi;
    try {
        $tabel_item = DB::table('items');
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }

    if($id == null)
        return response()->json(['message' => "ID can't be empty"], 400);
    if($nama == null)
        return response()->json(['message' => "Nama can't be empty"], 400);
    if($berat == null)
        return response()->json(['message' => "Berat can't be empty"], 400);
    if($harga == null)
        return response()->json(['message' => "Harga can't be empty"], 400);
    if($stok == null)
        return response()->json(['message' => "Stok can't be empty"], 400);
    if($URL_gambar == null)
        return response()->json(['message' => "Gambar can't be empty"], 400);
    if($id_kategori == null)
        return response()->json(['message' => "Kategori can't be empty"], 400);
    if($id_brand == null)
        return response()->json(['message' => "Brand can't be empty"], 400);
    if($id_subkategori == null)
        return response()->json(['message' => "Subkategori can't be empty"], 400);
    try {
        $url_kategori = DB::table('kategoris')->where('id', '=', $id_kategori)->get()[0]->url;
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
    if($id_socket == null && ($url_kategori == 'prosesor' || $url_kategori == 'motherboard'))

    if($deskripsi == NULL)
        $deskripsi = '-';

    $obj = [
        'id' => $id,
        'nama' => $nama,
        'berat' => $berat,
        'harga' => $harga,
        'stok' => $stok,
        'URL_gambar' => $URL_gambar,
        'id_kategori' => $id_kategori,
        'id_brand' => $id_brand,
        'id_subkategori' => $id_subkategori,
        'id_socket' => $id_socket,
        'deskripsi' => $deskripsi
    ];
    try {
        $item = $tabel_item->select(['id'])->where('id', '=', $id)->get()->count();
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
    if($item == 0)
        return response()->json(['message' => "Couldn\'t find product with id = ".strval($id)], 400);
    
    try {
        $tabel_item->upsert($obj, ['id'], [
            'nama', 'berat', 'harga', 'stok', 'URL_gambar', 'id_kategori',
            'id_brand', 'id_subkategori', 'id_socket', 'deskripsi'
        ]);
    } catch (QueryException $e) {
        return response()->json(['message' => 'Couldn\'t connect to database.'], 500);
    }

    return response()->json(['message' => 'Product changed.'], 200);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
