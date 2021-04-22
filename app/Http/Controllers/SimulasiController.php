<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimulasiController extends Controller
{
    //

    public function simulasi() {
        $list_kategori = DB::table('kategoris')->select('id', 'nama', 'url')->get();
        $list_barang = [];

        foreach ($list_kategori as $kategori) {
            $list_barang[$kategori->id] = DB::table('items')->where('id_kategori', '=', $kategori->id)->get();
        }

        // return $list_kategori;
        return view('simulasi', compact('list_kategori', 'list_barang'));
    }
}
