<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    //

    public function show_items_by_category(Request $request) {
        $current_kategori = DB::table('kategoris')->select(['id', 'nama'])->where('url', $request->input('kategori'))->get();
        $list_item = DB::table('items')->select(['id', 'nama', 'url_gambar'])->where('id_kategori', $current_kategori[0]->id)->get();
        $title = $current_kategori[0]->nama;
        $item_count = $list_item->count();
        
        return view('list_item', compact('list_item', 'title', 'item_count'));
    }

    public function get_all_items() {
        $list_item = DB::table('items')->get();
        $title = 'Semua produk';
        $item_count = $list_item->count();

        return view('list_item', compact('list_item', 'title', 'item_count'));
    }

    public function show_an_item(Request $request) {
        $item = DB::table('items')->where('id', $request->input('item_id'))->get();
        
        if(count($item) == 0) return abort(404);
        if(count($item) > 1) return abort(500);
        
        $item = $item[0];
        $nama_kategori = DB::table('kategoris')->select(['nama'])->where('id', '=', $item->id_kategori)->get()[0]->nama;
        $nama_subkategori = DB::table('subcategories')->select(['nama'])->where('id', '=', $item->id_subkategori)->get()[0]->nama;
        $nama_brand = DB::table('brands')->select(['nama'])->where('id', '=', $item->id_brand)->get()[0]->nama;
        $deskripsi = explode("\n", $item->deskripsi);
        $is_this_processor_or_motherboard = ($nama_kategori == 'Prosesor' || $nama_kategori == 'Motherboard'); 
        $nama_socket = DB::table('processor_sockets')->select(['nama'])->where('id', '=', $item->id_socket)->get();
        if($nama_socket->count() != 1) $nama_socket = '-';
        else $nama_socket = $nama_socket[0]->nama;
        $cart = (Auth::check() ? Cart::find($request->user()['id'])['data'] : NULL);
        $number_in_cart = 0;
        if($cart != NULL && isset($cart[$item->id])) {
            $number_in_cart = $cart[$item->id];
        }

        // return print_r($item);
        return view('item', compact('item', 'nama_kategori', 'nama_subkategori', 'nama_brand', 'deskripsi',
                'is_this_processor_or_motherboard', 'nama_socket', 'number_in_cart'));
    }
}
