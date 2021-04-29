<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function dashboard() {
        $contoh_image_url = 'https://storage.googleapis.com/zydhan-web.appspot.com/gambar-biner.webp';
        $dashboard = [
            [
                'imageURL' => $contoh_image_url,
                'title' => 'Tambah produk',
                'description' => 'Tambahkan produk ke database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-produk'
            ],
            [
                'imageURL' => $contoh_image_url,
                'title' => 'Daftar produk',
                'description' => 'Lihat atau ubah produk di database toko.',
                'buttonTitle' => 'Produk',
                'slug' => 'daftar-produk'
            ],
            [
                'imageURL' => $contoh_image_url,
                'title' => 'Tambah kategori',
                'description' => 'Tambahkan kategori di database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-kategori'
            ],
            [
                'imageURL' => $contoh_image_url,
                'title' => 'Daftar kategori',
                'description' => 'Lihat atau ubah kategori di database toko.',
                'buttonTitle' => 'Kategori',
                'slug' => 'daftar-kategori'
            ],
            [
                'imageURL' => $contoh_image_url,
                'title' => 'Tambah subkategori',
                'description' => 'Tambahkan subkategori di database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-subkategori'
            ],
            [
                'imageURL' => $contoh_image_url,
                'title' => 'Tambah brand',
                'description' => 'Tambahkan brand di database toko.',
                'buttonTitle' => 'Tambah',
                'slug' => 'tambah-brand'
            ]
        ];

        return view('admin-dashboard', compact('dashboard'));
    }

    public function tambah_produk() {
        $list_kategori = DB::table('kategoris')->get();
        $list_brand = DB::table('brands')->get();
        $list_socket = DB::table('processor_sockets')->get();
        $list_subkategori = DB::table('subcategories')->get();
        $prosesor_kategori_id = DB::table('kategoris')->select('id')->where('url', '=', 'prosesor')->get()[0]->id;
        $motherboard_kategori_id = DB::table('kategoris')->select('id')->where('url', '=', 'motherboard')->get()[0]->id;

        return view('admin-tambah-produk', compact('list_kategori', 'list_subkategori', 'list_brand',
            'prosesor_kategori_id', 'list_socket', 'motherboard_kategori_id'));
    }

    public function edit_produk(Request $request) {
        $list_kategori = DB::table('kategoris')->get();
        $list_brand = DB::table('brands')->get();
        $list_socket = DB::table('processor_sockets')->get();
        $list_subkategori = DB::table('subcategories')->get();
        $prosesor_kategori_id = DB::table('kategoris')->select('id')->where('url', '=', 'prosesor')->get()[0]->id;
        $motherboard_kategori_id = DB::table('kategoris')->select('id')->where('url', '=', 'motherboard')->get()[0]->id;
        $produk = DB::table('items')->where('id', '=', $request->query('id'))->get();
        
        if($produk->count() == 0) return abort(404);
        $produk = $produk[0];
        $is_this_processor_or_motherboard = $produk->id_kategori == $motherboard_kategori_id || $produk->id_kategori == $prosesor_kategori_id;

        return view('admin-edit-produk', compact('list_kategori', 'list_subkategori',
            'list_brand', 'prosesor_kategori_id', 'list_socket', 'produk', 'motherboard_kategori_id'
            , 'is_this_processor_or_motherboard'));
    }

    public function daftar_produk(Request $request) {
        $list_produk = DB::table('items');
        $list_kategori = kategori::all()->sortBy("id");
        $selected_kategori = $request->input('filter-kategori');
        
        if($selected_kategori != '')
            $list_produk->where('id_kategori', '=', $selected_kategori)->get();
        
        $item_count = $list_produk->count();
        $list_produk = $list_produk->get();
        return view('admin-daftar-item', compact('list_produk', 'list_kategori', 'selected_kategori', 'item_count'));
    }

    public function tambah_kategori() {
        return view('admin-tambah-kategori');
    }

    public function daftar_kategori() {
        $list_kategori = DB::table('kategoris')->get();
        return view('admin-daftar-kategori',compact('list_kategori'));
    }

    public function edit_kategori(Request $request) {
        $kategori_slug = $request->query('slug');
        $tabel_kategori = DB::table('kategoris');
        $kategori = $tabel_kategori->where('url', '=', $kategori_slug)->get();

        if($kategori->count() != 1)
            return abort(404);

        $kategori = $kategori[0];
        return view('admin-edit-kategori', compact('kategori'));
    }

    public function tambah_subkategori() {
        $list_kategori = DB::table('kategoris')->get();

        return view('admin-tambah-subkategori', compact('list_kategori'));
    }

    public function tambah_brand() {
        return view('admin-tambah-brand');
    }
}
