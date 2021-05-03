<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimulasiController extends Controller
{
    //

    public function simulasi() {
        try {
            $brand_processor = DB::table('brands')->select('id', 'nama')->where('nama', '=', 'AMD')->orWhere('nama', '=', 'Intel')->get();
            $list_ram = DB::table('items')->select(['id', 'nama', 'harga'])->where('id_kategori', '=', 14)->get();
            $kategori_lain = DB::table('kategoris')->select(['id', 'nama', 'url'])->whereNotIn('url', ['prosesor', 'motherboard', 'memory-ram'])->get();
            $list_item = DB::table('items')->select(['id', 'nama', 'harga', 'id_kategori'])->get();
        } catch (QueryException $e) {
            return view('database-error');
        }

        return view('simulasi', compact('brand_processor', 'list_ram', 'kategori_lain', 'list_item'));
    }
}
