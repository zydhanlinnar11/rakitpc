<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SimulasiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/kategori');
});

Route::get('/item', function (Request $request) {
    $itemcontroller = new ItemController;
    if($request->input('item_id') != '')
        return $itemcontroller->show_an_item($request);
    return abort(404);
})->name('item.view');

Route::get('/items', function (Request $request) {
    $itemcontroller = new ItemController;
        return $itemcontroller->show_items_by_category($request);
    return $itemcontroller->get_all_items();
});

Route::get('/kategori', [KategoriController::class, 'show_all']);

Route::get('/simulasi', [SimulasiController::class, 'simulasi'])->name('simulasi');

Route::get('/simulasi/preview', [SimulasiController::class, 'preview_simulasi'])->name('simulasi.preview');

Route::name('admin.')->prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    $admin_cru_routes = ['produk', 'kategori', 'subkategori', 'brand', 'socket'];
    foreach ($admin_cru_routes as $route) {
        Route::get('/daftar-'.$route, [AdminController::class, 'daftar_'.$route])->name('daftar.'.$route);
        Route::get('/tambah-'.$route, [AdminController::class, 'tambah_'.$route])->name('tambah.'.$route);
        Route::get('/edit-'.$route, [AdminController::class, 'edit_'.$route])->name('edit.'.$route);
    }
});

Route::middleware(['auth'])->name('user.')->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'root'])->name('root');

    $user_get_routes = ['keranjang', 'profile'];
    foreach ($user_get_routes as $route) {
        Route::get('/'.$route, [UserController::class, 'show_'.$route])->name($route);
    }

    Route::middleware(['auth'])->name('transaksi.')->prefix('transaksi')->group(function() {
        Route::get('/sukses', [UserController::class, 'show_transaksi_sukses'])->name('sukses');
        Route::get('/view', [UserController::class, 'show_transaksi'])->name('view');
        Route::get('/', [UserController::class, 'show_all_transaksi'])->name('all');
    });

    Route::get('/edit-profile', [UserController::class, 'edit_profile'])->name('edit-profile');

    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken('web-api-token');

        return ['token' => $token->plainTextToken];
    });
});

Route::get('/login', function(){
    return redirect("https://zydhan.xyz/apps/authorize?response_type=token&app_id=" . config('app.id') . "&redirect_uri=https%3A%2F%2Frakitpc.zydhan.xyz%2Fauth%2Fzydhan-web%2Fcallback");
})->name('login');

Route::get('/auth/zydhan-web/callback', [UserController::class, 'login_with_zydhan_web'])->name('auth.login.zydhan_web');

Route::get('/auth/logout', [UserController::class, 'logout'])->name('logout');

// Auth::routes();

Route::get('/logout', function(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->intended('/');
});