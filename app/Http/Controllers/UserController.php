<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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

    public function show_keranjang() {
        $user = Auth::user();
        try {
            $keranjang = Cart::where('id', '=', $user['id'])->first()['data'];
            return view('user.keranjang', compact('keranjang'));
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function add_item_to_keranjang(int $id_item, int $jumlah_item) {
        if($jumlah_item == null) $jumlah_item = 1;
        try {
            $cart = Cart::find(Auth::user()['id']);
            if($cart['data'] == null) $cart['data'] = [];
            if(!array_key_exists($id_item, $cart['data']))
                $cart['data'][$id_item] = 0;
            $cart['data'][$id_item] += $jumlah_item;
            $cart->save();
            return response();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function tambah(Request $request) {
        $id_item = $request->id_produk;
        if($id_item == null) return response('', 400);
        $jumlah_item = $request->jumlah_produk;
        return $this->add_item_to_keranjang($id_item, $jumlah_item);
    }

    public function tambah_from_simulasi(Request $request) {
        try {
            $kode_simulasi = $request->query('kode_simulasi');
            $tabel_data_simulasi = DB::table('data_simulasi')->where('id_simulasi', '=', $kode_simulasi)->get();
            $slug_nama_barang = SimulasiController::$slug_nama_barang;
            if($tabel_data_simulasi->count() != 1)
                return response('', 400);
            foreach ($slug_nama_barang as $key) {
                $id_item = $tabel_data_simulasi[0]->{'id_'.$key};
                $jumlah_item = $tabel_data_simulasi[0]->{'jumlah_'.$key};
                $this->add_item_to_keranjang($id_item, $jumlah_item);
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function kurangi(Request $request) {
        $id_item = $request->id_produk;
        if($id_item == null) return response('', 400);
        try {
            $cart = Cart::find(Auth::user()['id']);
            if($cart['data'] == null || !array_key_exists($id_item, $cart['data']))
                return response('', 400);
            if($cart['data'][$id_item] == 1)
                return $this->hapus_item_from_keranjang($id_item);
            $cart['data'][$id_item]--;
            $cart->save();
            return response();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function hapus_item_from_keranjang(int $id_item) {
        try {
            $cart = Cart::find(Auth::user()['id']);
            if($cart['data'] == null || !array_key_exists($id_item, $cart['data']))
                return response('', 400);
            array_splice($cart, $id_item, 1);
            $cart->save();
            return response();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function hapus(Request $request) {
        $id_item = $request->id_produk;
        if($id_item == null) return response('', 400);
        return $this->hapus_item_from_keranjang($id_item);
    }
}
