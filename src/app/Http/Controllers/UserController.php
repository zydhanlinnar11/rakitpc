<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\data_simulasi;
use App\Models\item;
use App\Models\kategori;
use App\Models\PaymentProcessor;
use App\Models\PaymentRequest;
use App\Models\Transaction;
use App\Models\User;
use DateTimeZone;
use Exception;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Ui\Presets\React;

class UserController extends Controller
{
    //
    public function root() {
        return redirect(route('user.profile'));
    }

    public function show_profile() {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function edit_profile() {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }

    public function patch_edit_profile(Request $request) {
        try {
            $user = User::find($request->user()['id']);
            if($user == NULL) {
                return response()->json(['message' => 'Gagal memperbarui user'], 400);
            }
            $user['name'] = $request->input('name');
            $user['email'] = $request->input('email');
            $user['no_telp'] = $request->input('no_telp');
            $user->save();
        } catch (Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui user'], 500);
        }
        return response()->json(['message' => 'Berhasil memperbarui user']);
    }

    public function show_keranjang(Request $request) {
        $user = $request->user();
        try {
            $keranjang = Cart::where('id', '=', $user['id'])->first()['data'];
            $list = [];
            $jumlah_total_produk = 0;
            $jumlah_total_harga = 0;
            $is_stok_enough = true;
            $payment_processors = PaymentProcessor::all();
            if($keranjang == NULL) {
                $checkoutable = false;
                return view('user.keranjang', compact('jumlah_total_harga', 'list', 'checkoutable', 'is_stok_enough', 'jumlah_total_produk', 'payment_processors'));
            }
            foreach ($keranjang as $key => $value) {
                $produk = item::find($key);
                if($produk == NULL) continue;
                $kategori = kategori::find($produk['id_kategori']);
                $jumlah_total_produk = $value;
                array_push($list, [
                    'id' => $produk['id'],
                    'url_gambar' => $produk['url_gambar'],
                    'kategori' => $kategori['nama'],
                    'nama' => $produk['nama'],
                    'harga' => $produk['harga'],
                    'jumlah' => $value,
                    'is_stok_enough' => $produk['stok'] >= $value
                ]);
                $is_stok_enough &= $produk['stok'] >= $value;
                $jumlah_total_harga += $produk['harga'] * $value;
            }
            // return $list;
            $checkoutable = $jumlah_total_produk > 0 && $is_stok_enough;
            return view('user.keranjang', compact('jumlah_total_harga', 'list', 'checkoutable', 'is_stok_enough', 'jumlah_total_produk', 'payment_processors'));
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
            unset($cart_data[$id_item]);
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

    public function transaksi_baru(Request $request) {
        try {
            $data = $request->input();
            $transaksi = new Transaction();
            $payment_processor = PaymentProcessor::find($data['paymentId']);
            $payment_handler = new PaymentController();
            $transaksi['id_user'] = $request->user()['id'];
            $transaksi['done'] = false;
            $transaksi['data'] = $data['data'];
            $transaksi->save();
            $transaksi = Transaction::orderBy('created_at', 'desc')->first();

            $transaksi['id_payment_request'] = $payment_handler->createPayment($payment_processor, $request->user(), $transaksi);
            $transaksi->save();
            
            foreach ($transaksi['data'] as $produk) {
                foreach ($produk as $id => $jumlah) {
                    $item = item::find($id);
                    if($item == NULL) continue;
                    $this->hapus_item_from_keranjang($request, $id);
                }
            }

            return response()->json(['redirectURL' => route('user.transaksi.sukses').'?id='.$transaksi['id_transaksi']]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function show_transaksi_sukses(Request $request) {
        if($request->query('id') == NULL) return redirect('/');
        try {
            $transaksi = Transaction::where('id_transaksi', $request->query('id'))->first();
            return view('user.transaksi.sukses', compact('transaksi'));
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function show_transaksi(Request $request) {
        if($request->query('id') == NULL) return redirect('/');
        try {
            $transaksi = Transaction::where('id_transaksi', $request->query('id'))->first();
            $list = [];
            foreach ($transaksi['data'] as $produk) {
                foreach ($produk as $id => $jumlah) {
                    $item = item::find($id);
                    if($item == NULL) continue;
                    $item['jumlah'] = $jumlah;
                    $item['kategori'] = kategori::find($item['id_kategori'])['nama'];
                    array_push($list, $item);
                }
            }
            $payment_request = PaymentRequest::find($transaksi['id_payment_request']);
            $payment_processor = PaymentProcessor::find($payment_request['id_payment_processor']);
            return view('user.transaksi.view', compact('transaksi', 'payment_processor', 'list'));
        } catch (Exception $e) {
            dd($e);
        }
    }
    
    public function show_all_transaksi(Request $request) {
        try {
            $id_user = $request->user()['id'];
            $transaksi = Transaction::where('id_user', $id_user)->get();
            return view('user.transaksi.all', compact('transaksi'));
        } catch (Exception $e) {
            dd($e);
        }
    }

    function login_with_google(Request $request) {
        $user = Socialite::driver('google')->user();

        $user_on_db = User::where('email', $user->getEmail())->first();
        if($user_on_db == null) {
            $user_on_db = new User();
            $user_on_db['email'] = $user->getEmail();
            $user_on_db['password'] = Hash::make($user->getId());
        }
        $user_on_db['avatar_url'] = $user->getAvatar();
        $user_on_db['name'] = $user->getName();
        if(!isset($user_on_db['email_verified_at']) || $user_on_db['email_verified_at'] == NULL)
            $user_on_db['email_verified_at'] = now(new DateTimeZone('Asia/Jakarta'));
        $user_on_db->save();
        Auth::login($user_on_db, true);
        $request->session()->regenerate();
        return redirect()->intended();
    }

    function login_with_zydhan_web(Request $request) {
        $validated = $request->validate(['token' => 'required|string']);

        $res = Http::withHeaders([
            'accept' => 'application/json',
        ])->get("https://api.zydhan.xyz/apps/user-info?token=" . $validated['token']);

        if($res->status() !== 200) return response()->json($res->json(), $res->status());

        $user = $res->json();

        $user_on_db = User::where('email', $user['email'])->first();
        if($user_on_db == null) {
            $user_on_db = new User();
            $user_on_db['email'] = $user['email'];
            $user_on_db['password'] = Hash::make(Factory::create()->password(20));
        }
        $user_on_db['avatar_url'] = $user['avatar_url'];
        $user_on_db['name'] = $user['name'];
        if(!isset($user_on_db['email_verified_at']) || $user_on_db['email_verified_at'] == NULL)
            $user_on_db['email_verified_at'] = now(new DateTimeZone('Asia/Jakarta'));
        $user_on_db->save();
        Auth::login($user_on_db, true);
        $request->session()->regenerate();
        return redirect()->intended();
    }

    function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
