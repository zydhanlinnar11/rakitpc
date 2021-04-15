<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\kategori;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //

    public function show_items_by_category(Request $request) {
        $current_kategori = kategori::where('url', $request->input('kategori'))->get();
        $list_item = item::where('id_kategori', $current_kategori[0]['id'])->get();
        
        return view('item', compact('list_item', 'current_kategori'));
    }
}
