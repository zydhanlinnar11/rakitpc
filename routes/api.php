<?php

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use GpsLab\Component\Base64UID\Base64UID;

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

Route::delete('/admin/edit-kategori', function(Request $request) {
    $id = $request->id;
    try {
        $kategori = DB::table('kategoris')->where('id', '=', $id);
        if($kategori->count() == 0)
            return response()->json(["message" => "Kategori id ".strval($id)." tidak ditemukan"], 400);
        if($kategori->count() > 1)
            return response()->json(["message" => "Kategori id ".strval($id)." terdapat duplikat"], 400);
        $produk_count = DB::table('items')->where('id_kategori', '=', $kategori->get()[0]->id)->get()->count();
        if($produk_count != 0)
            return response()->json(["message" => "Masih ada produk di kategori ini."], 400);
        $subkategori_count = DB::table('subcategories')->where('id_kategori', '=', $kategori->get()[0]->id)->get()->count();
        if($subkategori_count != 0)
            return response()->json(["message" => "Masih ada subkategori di kategori ini."], 400);
        
        $kategori->delete();
    } catch (QueryException $e) {
        if($e->getCode() == 2002) return response()->json(["message" => "Couldn't connect to database."], 500);
        return response()->json(["message" => $e->getMessage()], 500); 
    }
    return response()->json(["message" => "Kategori deleted."], 200);
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
        if($nama == NULL)
            return response()->json(['message' => 'Nama tidak boleh null.'], 400);
        if($id_kategori == NULL)
            return response()->json(['message' => 'ID kategori tidak boleh null.'], 400);
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

Route::patch('/admin/edit-subkategori', function(Request $request) {
    try {
        $nama = $request->nama;
        $slug = Str::slug($nama);
        $deskripsi = $request->deskripsi;
        $id = $request->id;
        $id_kategori = $request->idKategori;
        $tabel_subkategori = DB::table('subcategories');
        if($id == NULL || $tabel_subkategori->where('id', '=', $id)->get()->count() == 0)
            return response()->json(['message' => 'ID tidak valid.'], 400);
        if($nama == NULL)
            return response()->json(['message' => 'Nama tidak boleh null.'], 400);
        if($id_kategori == NULL)
            return response()->json(['message' => 'ID kategori tidak boleh null.'], 400);
        if($deskripsi == NULL)
            $deskripsi = '-';
            
        $tabel_subkategori->upsert(
            [
                'id' => $id,
                'nama' => $nama,
                'slug' => $slug,
                'deskripsi' => $deskripsi,
                'id_kategori' => $id_kategori
            ],
            ['id']
        );
        return response()->json(['message' => 'Subcategory edited.'], 200);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::delete('/admin/edit-subkategori', function(Request $request) {
    $id = $request->id;
    try {
        $subkategori = DB::table('subcategories')->where('id', '=', $id);
        if($subkategori->count() == 0)
            return response()->json(["message" => "Subkategori id ".strval($id)." tidak ditemukan"], 400);
        if($subkategori->count() > 1)
            return response()->json(["message" => "Subkategori id ".strval($id)." terdapat duplikat"], 400);
        $produk_count = DB::table('items')->where('id_subkategori', '=', $subkategori->get()[0]->id)->get()->count();
        if($produk_count != 0)
            return response()->json(["message" => "Masih ada produk di subkategori ini."], 400);
        
        $subkategori->delete();
    } catch (QueryException $e) {
        if($e->getCode() == 2002) return response()->json(["message" => "Couldn't connect to database."], 500);
        return response()->json(["message" => $e->getMessage()], 500); 
    }
    return response()->json(["message" => "Subkategori deleted."], 200);
});

Route::post('/admin/tambah-socket', function(Request $request) {
    try {
        $nama = $request->nama;
        $id_brand = $request->idBrand;
        $tabel_socket = DB::table('processor_sockets');
        if($tabel_socket->where('nama', '=', $nama)->get()->count() > 0)
            return response()->json(['message' => 'Socket already exists.'], 400);
    
        if($nama == NULL)
            return response()->json(['message' => 'Nama tidak boleh null.'], 400);
        if($id_brand == NULL)
            return response()->json(['message' => 'ID Brand tidak boleh null.'], 400);
            
        $tabel_socket->upsert(
            [
                'nama' => $nama,
                'id_brand' => $id_brand
            ],
            ['nama']
        );
        return response()->json(['message' => 'Socket added.'], 200);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::patch('/admin/edit-socket', function(Request $request) {
    try {
        $id = $request->id;
        $nama = $request->nama;
        $id_brand = $request->idBrand;
        $tabel_socket = DB::table('processor_sockets');
        if($id == null || $tabel_socket->where('id', '=', $id)->get()->count() == 0)
            return response()->json(['message' => 'ID Socket tidak valid.'], 400);
    
        if($nama == NULL)
            return response()->json(['message' => 'Nama tidak boleh null.'], 400);
        if($id_brand == NULL)
            return response()->json(['message' => 'ID Brand tidak boleh null.'], 400);
            
        $tabel_socket->upsert(
            [
                'id' => $id,
                'nama' => $nama,
                'id_brand' => $id_brand
            ],
            ['id']
        );
        return response()->json(['message' => 'Socket edited.'], 200);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::delete('/admin/edit-socket', function(Request $request) {
    try {
        $id = $request->id;
        $tabel_socket = DB::table('processor_sockets');
        if($id == null || $tabel_socket->where('id', '=', $id)->get()->count() == 0)
            return response()->json(['message' => 'ID Socket tidak valid.'], 400);
            
        $tabel_socket->where('id', '=', $id)->delete();
        return response()->json(['message' => 'Socket deleted.'], 200);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::post('/admin/tambah-brand', function(Request $request) {
    try {
        $nama = $request->nama;
        $url_logo = $request->urlLogo;
        $deskripsi = $request->deskripsi;
        $tabel_brand = DB::table('brands');
        if($tabel_brand->where('nama', '=', $nama)->get()->count() > 0)
            return response()->json(['message' => 'Brand already exists.'], 400);
    
        if($deskripsi == NULL)
            $deskripsi = '-';
            
        $tabel_brand->upsert(
            [
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'url_logo' => $url_logo
            ],
            ['nama']
        );
        return response()->json(['message' => 'Brand added.'], 200);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::patch('/admin/edit-brand', function(Request $request) {
    try {
        $id = $request->id;
        $nama = $request->nama;
        $url_logo = $request->urlLogo;
        $deskripsi = $request->deskripsi;
        $tabel_brand = DB::table('brands');
        if($id == null || $tabel_brand->where('id', '=', $id)->get()->count() == 0)
            return response()->json(['message' => 'Brand tidak valid.'], 400);
    
        if($deskripsi == NULL)
            $deskripsi = '-';
            
        $tabel_brand->upsert(
            [
                'id' => $id,
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'url_logo' => $url_logo
            ],
            ['id']
        );
        return response()->json(['message' => 'Brand edited.'], 200);
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
});

Route::delete('/admin/edit-brand', function(Request $request) {
    $id = $request->id;
    try {
        $brand = DB::table('brands')->where('id', '=', $id);
        if($brand->count() == 0)
            return response()->json(["message" => "Brand id ".strval($id)." tidak ditemukan"], 400);
        if($brand->count() > 1)
            return response()->json(["message" => "Brand id ".strval($id)." terdapat duplikat"], 400);
        $produk_count = DB::table('items')->where('id_brand', '=', $brand->get()[0]->id)->get()->count();
        if($produk_count != 0)
            return response()->json(["message" => "Masih ada produk di brand ini."], 400);
        
        $brand->delete();
    } catch (QueryException $e) {
        if($e->getCode() == 2002) return response()->json(["message" => "Couldn't connect to database."], 500);
        return response()->json(["message" => $e->getMessage()], 500); 
    }
    return response()->json(["message" => "Brand deleted."], 200);
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

Route::delete('/admin/edit-produk', function(Request $request) {
    $id = $request->id;
    try {
        $produk = DB::table('items')->where('id', '=', $id);
        if($produk->count() == 0)
            return response()->json(["message" => "Produk id ".strval($id)." tidak ditemukan"], 400);
        if($produk->count() > 1)
            return response()->json(["message" => "Produk id ".strval($id)." terdapat duplikat"], 400);
        $produk->delete();
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
    return response()->json(["message" => "Item deleted."], 200);
});

Route::get('/socket', function(Request $request) {
    $id_brand = $request->id_brand;
    try {
        $list_socket = DB::table('processor_sockets')->select(['id', 'nama']);
        if($id_brand != null)
            $list_socket = $list_socket->where('id_brand', '=', $id_brand);
        $list_socket = $list_socket->get();
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
    
    return $list_socket;
});

Route::get('/prosesor', function(Request $request) {
    $id_socket = $request->id_socket;
    try {
        $list_prosesor = DB::table('items')->select(['id', 'nama', 'harga', 'stok'])->where('id_kategori', '=', 12);
        if($id_socket != null)
            $list_prosesor = $list_prosesor->where('id_socket', '=', $id_socket);
        $list_prosesor = $list_prosesor->get();
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
    
    return $list_prosesor;
});

Route::get('/motherboard', function(Request $request) {
    $id_socket = $request->id_socket;
    try {
        $list_motherboard = DB::table('items')->select(['id', 'nama', 'harga', 'stok'])->where('id_kategori', '=', 13);
        if($id_socket != null)
            $list_motherboard = $list_motherboard->where('id_socket', '=', $id_socket);
        $list_motherboard = $list_motherboard->get();
    } catch (QueryException $e) {
        return response()->json(["message" => "Couldn't connect to database."], 500);
    }
    
    return $list_motherboard;
});

Route::get('/simulasi-kompatibilitas', function(Request $request) {
    $kode_simulasi = $request->query('kode_simulasi');
    if($kode_simulasi == '')
        return response()->json(["message" => "Kode simulasi salah."], 400);

    try {
        $data_simulasi = DB::table('data_simulasi')->select(['id_brand', 'id_socket', 'id_prosesor', 'id_motherboard'])->where('id_simulasi', '=', $kode_simulasi)->get();
        if($data_simulasi->count() != 1)
            return response()->json(["message" => "Kode simulasi salah."], 400);
    } catch (QueryException $e) {
        return response()->json(["message" => "Database error."], 500);
    }
    return response()->json($data_simulasi[0], 200);
})->name('api.simulasi.kompatibilitas');

Route::post('/simulasi', function(Request $request) {
    $uid = Base64UID::generate(11);
    $slug_barang = ['prosesor', 'motherboard', 'ram', 'hard_disk', 'ssd', 'casing'
                        , 'graphics_card', 'power-supply', 'keyboard', 'mouse', 'monitor', 'cpu_cooler', 'software'];

    $array_simulasi = [
        'id_simulasi' => $uid,
        'kompatibilitas' => $request->input('kompatibilitas') == "true",
        'id_brand' => $request->input('brandProcessor'),
        'id_socket' => $request->input('socketProcessor'),
    ];

    foreach ($slug_barang as $key) {
        if(array_key_exists($key, $request->input())) {
            $array_simulasi['id_'.$key] = $request->input($key)['id'];
            $array_simulasi['jumlah_'.$key] = $request->input($key)['jumlah'];
        }
    }

    try {
        $tabel_data_simulasi = DB::table('data_simulasi');
        $array_simulasi['created_at'] = DB::raw('now()');
        $array_simulasi['updated_at'] = DB::raw('now()');
        $tabel_data_simulasi->upsert($array_simulasi, ['id']);
    } catch (QueryException $e) {
        return response()->json(["message" => "Database error."], 500);
    }
    return response()->json(["kodeSimulasi" => $uid], 200);
});

Route::patch('/simulasi', function(Request $request) {
    $uid = $request->query('kode_simulasi');
    $slug_barang = ['prosesor', 'motherboard', 'ram', 'hard_disk', 'ssd', 'casing'
                        , 'graphics_card', 'power_supply', 'keyboard', 'mouse', 'monitor', 'cpu_cooler', 'software'];

    $array_simulasi = [
        'id_simulasi' => $uid,
        'kompatibilitas' => $request->input('kompatibilitas') == "true",
        'id_brand' => $request->input('brandProcessor'),
        'id_socket' => $request->input('socketProcessor'),
    ];

    $update_column = ['kompatibilitas', 'id_brand', 'id_socket', 'updated_at']; 

    foreach ($slug_barang as $key) {
        if(array_key_exists($key, $request->input())) {
            array_push($update_column, 'id_'.$key);
            array_push($update_column, 'jumlah_'.$key);
            $array_simulasi['id_'.$key] = $request->input($key)['id'];
            $array_simulasi['jumlah_'.$key] = $request->input($key)['jumlah'];
        } else {
            array_push($update_column, 'id_'.$key);
            array_push($update_column, 'jumlah_'.$key);
            $array_simulasi['id_'.$key] = null;
            $array_simulasi['jumlah_'.$key] = null;
        }
    }

    try {
        $tabel_data_simulasi = DB::table('data_simulasi');
        $array_simulasi['updated_at'] = DB::raw('now()');
        $tabel_data_simulasi->upsert($array_simulasi, ['id'], $update_column);
    } catch (QueryException $e) {
        return response()->json(["message" => "Database error."], 500);
    }
    return response()->json(["kodeSimulasi" => $uid], 200);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
