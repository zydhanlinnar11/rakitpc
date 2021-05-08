<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\data_simulasi;
use App\Models\item;
use App\Models\kategori;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function root() {
        return redirect(route('user.profile'));
    }

    public function show_profile() {
        // 
    }

    public function show_keranjang(Request $request) {
        $user = $request->user();
        try {
            $keranjang = Cart::where('id', '=', $user['id'])->first()['data'];
            $list = [];
            foreach ($keranjang as $key => $value) {
                $produk = item::find($key);
                $kategori = kategori::find($produk['id_kategori']);
                array_push($list, [
                    'id' => $produk['id'],
                    'url_gambar' => $produk['url_gambar'],
                    'kategori' => $kategori['nama'],
                    'nama' => $produk['nama'],
                    'harga' => $produk['harga'],
                    'jumlah' => $value
                ]);
            }
            // return $list;
            return view('user.keranjang', compact('list'));
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function add_item_to_keranjang(Request $request, int $id_item, int $jumlah_item) {
        try {
            $cart = Cart::find($request->user()['id']);
            $cart_data = $cart['data'];
            if($cart_data == NULL) $cart_data = [];
            if(!array_key_exists($id_item, $cart_data))
                $cart_data[$id_item] = 0;
            $cart_data[$id_item] += $jumlah_item;
            $cart['data'] = $cart_data;
            $cart->save();
            return response()->json([], 200);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function tambah(Request $request) {
        $id_item = $request->id_produk;
        if($id_item == NULL) return response()->json([], 400);
        $jumlah_item = $request->jumlah_produk;
        if($jumlah_item == NULL) $jumlah_item = 1;
        return $this->add_item_to_keranjang($request, $id_item, $jumlah_item);
    }

    public function tambah_from_simulasi(Request $request) {
        $kode_simulasi = $request->kode_simulasi;
        try {
            $data_simulasi = data_simulasi::where('id_simulasi', $kode_simulasi)->first();
            $slug_nama_barang = SimulasiController::$slug_nama_barang;
            foreach ($slug_nama_barang as $key => $value) {
                $id_item = $data_simulasi['id_'.$key];
                $jumlah_item = $data_simulasi['jumlah_'.$key];
                if($id_item == NULL) continue;
                $this->add_item_to_keranjang($request, $id_item, $jumlah_item);
            }
            return response()->json([], 200);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function kurangi(Request $request) {
        $id_item = $request->id_produk;
        if($id_item == NULL) return response()->json([], 400);
        try {
            $cart = Cart::find($request->user()['id']);
            $cart_data = $cart['data'];
            if($cart_data == NULL || !array_key_exists($id_item, $cart_data))
                return response()->json([], 400);
            if($cart_data[$id_item] == 1)
                return $this->hapus_item_from_keranjang($request, $id_item);
            $cart_data[$id_item]--;
            $cart['data'] = $cart_data;
            $cart->save();
            return response()->json([], 200);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function hapus_item_from_keranjang(Request $request, int $id_item) {
        try {
            $cart = Cart::find($request->user()['id']);
            $cart_data = $cart['data'];
            if($cart_data == NULL || !array_key_exists($id_item, $cart_data))
                return response()->json([], 400);
            array_splice($cart_data, $id_item, 1);
            if(count($cart_data) == 0)
                $cart_data = NULL;
            $cart['data'] = $cart_data;
            $cart->save();
            return response()->json([], 200);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function hapus(Request $request) {
        $id_item = $request->id_produk;
        if($id_item == NULL) return response()->json([], 400);
        return $this->hapus_item_from_keranjang($request, $id_item);
    }
}
