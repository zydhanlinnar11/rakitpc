<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function dashboard() {
        $dashboard = [
            [
                'title' => 'Tambah produk',
                'description' => 'Tambahkan produk ke database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-produk'
            ],
            [
                'title' => 'Daftar produk',
                'description' => 'Lihat atau ubah produk di database toko.',
                'buttonTitle' => 'Produk',
                'slug' => 'daftar-produk'
            ],
            [
                'title' => 'Tambah kategori',
                'description' => 'Tambahkan kategori di database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-kategori'
            ],
            [
                'title' => 'Daftar kategori',
                'description' => 'Lihat atau ubah kategori di database toko.',
                'buttonTitle' => 'Kategori',
                'slug' => 'daftar-kategori'
            ],
            [
                'title' => 'Tambah subkategori',
                'description' => 'Tambahkan subkategori di database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-subkategori'
            ],
            [
                'title' => 'Daftar subkategori',
                'description' => 'Lihat atau ubah subkategori di database toko.',
                'buttonTitle' => 'Subkategori',
                'slug' => 'daftar-subkategori'
            ],
            [
                'title' => 'Tambah brand',
                'description' => 'Tambahkan brand di database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-brand'
            ],
            [
                'title' => 'Daftar brand',
                'description' => 'Lihat atau ubah brand di database toko.',
                'buttonTitle' => 'Brand',
                'slug' => 'daftar-brand'
            ],
            [
                'title' => 'Tambah socket',
                'description' => 'Tambahkan socket prosesor di database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-socket'
            ],
            [
                'title' => 'Daftar socket',
                'description' => 'Lihat atau ubah socket prosesor di database toko.',
                'buttonTitle' => 'Socket',
                'slug' => 'daftar-socket'
            ]
        ];

        return view('admin-dashboard', compact('dashboard'));
    }

    public function tambah_produk() {
        try {
            $list_kategori = DB::table('kategoris')->get();
            $list_brand = DB::table('brands')->get();
            $list_socket = DB::table('processor_sockets')->get();
            $list_subkategori = DB::table('subcategories')->get();
            $prosesor_kategori_id = DB::table('kategoris')->select('id')->where('url', '=', 'prosesor')->get()[0]->id;
            $motherboard_kategori_id = DB::table('kategoris')->select('id')->where('url', '=', 'motherboard')->get()[0]->id;
        } catch (QueryException $e) {
            return view('database-error');
        }

        return view('admin-tambah-produk', compact('list_kategori', 'list_subkategori', 'list_brand',
            'prosesor_kategori_id', 'list_socket', 'motherboard_kategori_id'));
    }

    public function edit_produk(Request $request) {
        try {
            $list_kategori = DB::table('kategoris')->get();
            $list_brand = DB::table('brands')->get();
            $list_socket = DB::table('processor_sockets')->get();
            $list_subkategori = DB::table('subcategories')->get();
            $prosesor_kategori_id = DB::table('kategoris')->select('id')->where('url', '=', 'prosesor')->get()[0]->id;
            $motherboard_kategori_id = DB::table('kategoris')->select('id')->where('url', '=', 'motherboard')->get()[0]->id;
            $produk = DB::table('items')->where('id', '=', $request->query('id'))->get();
        } catch (QueryException $e) {
            return view('database-error');
        }
        
        if($produk->count() == 0) return abort(404);
        $produk = $produk[0];
        $is_this_processor_or_motherboard = $produk->id_kategori == $motherboard_kategori_id || $produk->id_kategori == $prosesor_kategori_id;

        return view('admin-edit-produk', compact('list_kategori', 'list_subkategori',
            'list_brand', 'prosesor_kategori_id', 'list_socket', 'produk', 'motherboard_kategori_id'
            , 'is_this_processor_or_motherboard'));
    }

    public function daftar_produk(Request $request) {
        try {
            $list_produk = DB::table('items');
            $list_kategori = kategori::all()->sortBy("id");
        } catch (QueryException $e) {
            return view('database-error');
        }
        $selected_kategori = $request->input('filter-kategori');
        
        if($selected_kategori != '')
            $list_produk->where('id_kategori', '=', $selected_kategori)->get();
        
        $item_count = $list_produk->count();
        $list_produk = $list_produk->get();
        return view('admin-daftar-item', compact('list_produk', 'list_kategori', 'selected_kategori', 'item_count'));
    }

    public function tambah_kategori() {
        try {
            DB::table('kategoris')->get();
        } catch (QueryException $e) {
            return view('database-error');
        }
        return view('admin-tambah-kategori');
    }

    public function daftar_kategori() {
        try {
            $list_kategori = DB::table('kategoris')->get();
        } catch (QueryException $e) {
            return view('database-error');
        }
        return view('admin-daftar-kategori',compact('list_kategori'));
    }

    public function edit_kategori(Request $request) {
        $kategori_slug = $request->query('slug');
        try {
            $tabel_kategori = DB::table('kategoris');
            $kategori = $tabel_kategori->where('url', '=', $kategori_slug)->get();
            if($kategori->count() != 1)
                return abort(404);
    
            $kategori = $kategori[0];
            $is_deletable = DB::table('items')->where('id_kategori', '=', $kategori->id)->count() == 0;
            $is_any_subkategori_here = DB::table('subcategories')->where('id_kategori', '=', $kategori->id)->count() > 0;
        } catch (QueryException $e) {
            return view('database-error');
        }

        return view('admin-edit-kategori', compact('kategori', 'is_deletable', 'is_any_subkategori_here'));
    }

    public function tambah_subkategori() {
        try {
            $list_kategori = DB::table('kategoris')->get();
        } catch (QueryException $e) {
            return view('database-error');
        }

        return view('admin-tambah-subkategori', compact('list_kategori'));
    }

    public function daftar_subkategori(Request $request) {
        $selected_kategori = ($request->query('filter-kategori') != null ? $request->query('filter-kategori') : '');
        try {
            $list_subkategori = DB::table('subcategories');
            if($selected_kategori != '') 
                $list_subkategori = $list_subkategori->where('id_kategori', '=', $selected_kategori);
            $list_subkategori = $list_subkategori->get();
            $list_kategori = DB::table('kategoris')->get();
        } catch (QueryException $e) {
            return view('database-error');
        }
        return view('admin-daftar-subkategori',compact('list_subkategori', 'list_kategori', 'selected_kategori'));
    }

    public function edit_subkategori(Request $request) {
        $subkategori_id = $request->query('id');
        try {
            $tabel_subkategori = DB::table('subcategories');
            $subkategori = $tabel_subkategori->where('id', '=', $subkategori_id)->get();
            $list_kategori = DB::table('kategoris')->get();
            if($subkategori->count() != 1)
                return abort(404);
    
            $subkategori = $subkategori[0];
            $is_deletable = DB::table('items')->where('id_subkategori', '=', $subkategori->id)->count() == 0;
        } catch (QueryException $e) {
            return view('database-error');
        }

        return view('admin-edit-subkategori', compact('subkategori', 'is_deletable', 'list_kategori'));
    }

    public function tambah_brand() {
        try {
            DB::table('brands')->get();
        } catch (QueryException $e) {
            return view('database-error');
        }
        return view('admin-tambah-brand');
    }

    public function daftar_brand(Request $request) {
        try {
            $list_brand = DB::table('brands')->get();
        } catch (QueryException $e) {
            return view('database-error');
        }
        return view('admin-daftar-brand',compact('list_brand'));
    }

    public function edit_brand(Request $request) {
        $brand_id = $request->query('id');
        try {
            $tabel_brand = DB::table('brands');
            $brand = $tabel_brand->where('id', '=', $brand_id)->get();
            if($brand->count() != 1)
                return abort(404);
    
            $brand = $brand[0];
            $is_deletable = DB::table('items')->where('id_brand', '=', $brand->id)->count() == 0;
        } catch (QueryException $e) {
            return view('database-error');
        }

        return view('admin-edit-brand', compact('brand', 'is_deletable'));
    }

    public function tambah_socket() {
        try {
            $list_brand = DB::table('brands')->where('nama', '=', 'AMD')->orWhere('nama', '=', 'Intel')->get();
        } catch (QueryException $e) {
            return view('database-error');
        }

        return view('admin-tambah-socket', compact('list_brand'));
    }

    public function daftar_socket(Request $request) {
        $selected_brand = ($request->query('filter-brand') != null ? $request->query('filter-brand') : '');
        try {
            $list_socket = DB::table('processor_sockets');
            if($selected_brand != '') 
                $list_socket = $list_socket->where('id_brand', '=', $selected_brand);
            $list_socket = $list_socket->get();
            $list_brand = DB::table('brands')->where('nama', '=', 'AMD')->orWhere('nama', '=', 'Intel')->get();
        } catch (QueryException $e) {
            return view('database-error');
        }
        return view('admin-daftar-socket',compact('list_socket', 'list_brand', 'selected_brand'));
    }

    public function edit_socket(Request $request) {
        $socket_id = $request->query('id');
        try {
            $tabel_socket = DB::table('processor_sockets');
            $socket = $tabel_socket->where('id', '=', $socket_id)->get();
            $list_brand = DB::table('brands')->where('nama', '=', 'AMD')->orWhere('nama', '=', 'Intel')->get();
            if($socket->count() != 1)
                return abort(404);
    
            $socket = $socket[0];
            $is_deletable = DB::table('items')->where('id_socket', '=', $socket->id)->count() == 0;
        } catch (QueryException $e) {
            return view('database-error');
        }

        return view('admin-edit-socket', compact('socket', 'is_deletable', 'list_brand'));
    }
}
