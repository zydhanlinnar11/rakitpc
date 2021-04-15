<?php

namespace App\Http\Controllers;

use App\Models\kategori;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        $list_kategori = kategori::all();
        return view('home', compact('list_kategori'));
    }
}
