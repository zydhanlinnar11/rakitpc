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
                'title' => 'Tambah Kategori',
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
            ]
        ];

        return view('admin-dashboard', compact('dashboard'));
    }

    public function daftar_produk(Request $request) {
        $list_produk = DB::table('items');
        $list_kategori = kategori::all()->sortBy("id");
        $selected_kategori = $request->input('filter-kategori');

        if($selected_kategori != '')
            $list_produk->where('id_kategori', '=', $selected_kategori)->get();

        $list_produk = $list_produk->get();
        return view('admin-daftar-item', compact('list_produk', 'list_kategori', 'selected_kategori'));
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
}
