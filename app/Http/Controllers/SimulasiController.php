<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimulasiController extends Controller
{
    //

    public function simulasi(Request $request) {
        $edit_kode_simulasi = $request->query('kode_simulasi');
        $edit_kode_invalid = $edit_kode_simulasi == '' || $edit_kode_simulasi == null;
        try {
            $tabel_data_simulasi = DB::table('data_simulasi')->where('id_simulasi', '=', $edit_kode_simulasi)->get();
            $data_simulasi = $tabel_data_simulasi;
            if($edit_kode_simulasi != '' && $tabel_data_simulasi->count() != 1) {
                $edit_kode_invalid = true;
            } else {
                $data_simulasi = $data_simulasi[0];
            }
            $brand_processor = DB::table('brands')->select('id', 'nama')->where('nama', '=', 'AMD')->orWhere('nama', '=', 'Intel')->get();
            $list_ram = DB::table('items')->select(['id', 'nama', 'harga'])->where('id_kategori', '=', 14)->get();
            $kategori_lain = DB::table('kategoris')->select(['id', 'nama', 'url'])->whereNotIn('url', ['prosesor', 'motherboard', 'memory-ram'])->get();
            $list_item = DB::table('items')->select(['id', 'nama', 'harga', 'id_kategori'])->get();
        } catch (QueryException $e) {
            return view('database-error');
        }
        // return var_dump($data_simulasi);
        return view('simulasi.simulasi', compact('brand_processor', 'list_ram', 'kategori_lain', 'list_item', 'edit_kode_simulasi', 'edit_kode_invalid', 'data_simulasi'));
    }

    public function preview_simulasi(Request $request) {
        $slug_nama_barang = ['prosesor' => 'Prosesor', 'motherboard' => 'Motherboard', 'ram' => 'Memory RAM', 'hard_disk' => 'Hard disk', 'ssd' => 'SSD', 'casing' => 'Casing'
                        ,'graphics_card' => "Graphics card" , 'power_supply' => 'Power Supply', 'keyboard' => 'Keyboard', 'mouse' => 'Mouse',
                        'monitor' => 'Monitor', 'cpu_cooler' => 'CPU Cooler', 'software' => 'Software'];
        $kode_simulasi = $request->query('kode_simulasi');
        $array_simulasi = [];
        $total_harga = 0;
        
        try {
            $tabel_data_simulasi = DB::table('data_simulasi')->where('id_simulasi', '=', $kode_simulasi)->get();
            if($tabel_data_simulasi->count() != 1)
                return response()->json(["message" => "Kode simulasi tidak valid."], 500);
            $tabel_item = DB::table('items')->select(['id', 'nama', 'harga', 'url_gambar'])->get();
            $kompatibilitas = $tabel_data_simulasi[0]->kompatibilitas;
            $created_at = $tabel_data_simulasi[0]->created_at;
            $updated_at = $tabel_data_simulasi[0]->updated_at;
            foreach($slug_nama_barang as $key => $value) {
                $id_item = $tabel_data_simulasi[0]->{'id_'.$key};
                $jumlah_item = $tabel_data_simulasi[0]->{'jumlah_'.$key};
                $items = $tabel_item->where('id', '=', $id_item);
                if($items->count() == 1) {
                    foreach($items as $item) {
                        array_push($array_simulasi, ['kategori' => $value, 'id' => $item->id, 'nama' => $item->nama,
                            'harga' => $item->harga, 'url_gambar' => $item->url_gambar, 'jumlah' => $jumlah_item]);
                        $total_harga += $jumlah_item * $item->harga;
                    }
                }
            }

            $id_brand = $tabel_data_simulasi[0]->id_brand;
            $id_socket = $tabel_data_simulasi[0]->id_socket;
            $tabel_brand = DB::table('brands')->select(['nama'])->where('id', '=', $id_brand)->get();
            $tabel_socket = DB::table('processor_sockets')->select(['nama'])->where('id', '=', $id_socket)->get();
            if($tabel_brand->count() == 1 && $tabel_socket->count() == 1) {
                $brand = $tabel_brand[0]->nama;
                $socket = $tabel_socket[0]->nama;
            }
        } catch (QueryException $e) {
            return response()->json(["message" => "Database error."], 500);
        }
        return view('simulasi.preview', compact('array_simulasi', 'kompatibilitas', 'kode_simulasi', 'brand', 'socket', 'total_harga', 'created_at', 'updated_at'));
    }
}
