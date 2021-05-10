@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle='$item->nama'>
  <div class="row mb-3">
    <div class="col-xl-6 text-center">
        <img src="{{$item->url_gambar}}" class="img-fluid" alt="Gambar dari {{$item->nama}}" style="max-height: 350px">
    </div>
    <div class="col-xl-6">
      <table class="table col-xl-6">
        <thead>
          <tr>
            <th scope="col">Spesifikasi</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Nama produk:</th>
            <td>{{$item->nama}}</td>
          </tr>
          <tr>
            <th scope="row">Brand:</th>
            <td>{{$nama_brand}}</td>
          </tr>
          <tr>
            <th scope="row">Kategori:</th>
            <td>{{$nama_kategori}}</td>
          </tr>
          <tr>
            <th scope="row">Subkategori:</th>
            <td>{{$nama_subkategori}}</td>
          </tr>
          @if ($is_this_processor_or_motherboard)
          <tr>
            <th scope="row">Socket prosesor:</th>
            <td>{{$nama_socket}}</td>
          </tr>
          @endif
          <tr>
            <th scope="row">Berat produk:</th>
            <td>{{$item->berat}} kg</td>
          </tr>
          <tr>
            <th scope="row">Harga produk:</th>
            <td>Rp. {{number_format($item->harga, 2, ',', '.')}}</td>
          </tr>
          <tr>
            <th scope="row">Jumlah stok:</th>
            <td>{{$item->stok}} unit</td>
          </tr>
        </tbody>
      </table>
      @if (Auth::check())
      <div>
        <h6>Stok di keranjang : <span id="jumlah-di-keranjang" data-jumlah="{{$number_in_cart}}" data-maks="{{$item->stok}}">{{$number_in_cart}}</span></h6>
        <div class="row">
          <form class="col-4" action="javascript:getToken(kurangiFromKeranjang, '{{csrf_token()}}')">
            <input type="text" name="id_produk" id="id" value="{{$item->id}}" hidden>
            <button id="kurangi-button" type="submit" class="btn btn-warning col-12"
            @if ($number_in_cart == 0)
                disabled
            @endif
            >Kurangi</button>
          </form>
          <form class="col-4" action="javascript:getToken(hapusFromKeranjang, '{{csrf_token()}}')">
            <input type="text" name="id_produk" id="id" value="{{$item->id}}" hidden>
            <button id="hapus-button" type="submit" class="btn btn-danger col-12"
            @if ($number_in_cart == 0)
              disabled
            @endif
            >Hapus</button>
          </form>
          <form class="col-4" action="javascript:getToken(addToKeranjang, '{{csrf_token()}}')">
            <input type="text" name="id_produk" id="id" value="{{$item->id}}" hidden>
            <button id="tambah-button" type="submit" class="btn btn-primary col-12"
            @if ($number_in_cart >= $item->stok)
                disabled
            @endif
            >Tambah</button>
          </form>
        </div>
      </div>
      @else
      <div>
        <h6>Silahkan <a href="{{route('login')}}">Login</a> atau <a href="{{route('register')}}">Daftar</a> untuk menambahkan ke keranjang.</h6>
      </div>
      @endif
    </div>
  </div>
  <x-_admin_form_alert />

  <hr>

  <div class="row mb-3">
      <h4 class="mt-1 mb-3">Deskripsi</h4>
      @foreach ($deskripsi as $par)
      <p>{{$par}}</p>
      @endforeach
  </div>
</x-_content_container>

<script>  
  function addToKeranjang(token) {
      const id_produk = document.getElementById("id").value
      ajax.onreadystatechange = () => {
        if(ajax.readyState == ajax.DONE) {
          showAlert(ajax.status == 200 ? "success" : "danger", ajax.status == 200 ?
          "Produk berhasil ditambahkan ke keranjang" : "Produk gagal ditambahkan ke keranjang")
        }
        if(ajax.readyState == ajax.DONE && ajax.status == 200) {
          document.getElementById('hapus-button').disabled = false
          document.getElementById('kurangi-button').disabled = false
          document.getElementById('jumlah-di-keranjang').dataset.jumlah = parseInt(document.getElementById('jumlah-di-keranjang').dataset.jumlah) + 1
          document.getElementById('jumlah-di-keranjang').innerText = document.getElementById('jumlah-di-keranjang').dataset.jumlah
        }
        if(parseInt(document.getElementById('jumlah-di-keranjang').dataset.jumlah) >=
          parseInt(document.getElementById('jumlah-di-keranjang').dataset.maks)) {
          document.getElementById('tambah-button').disabled = true
        }
      }
      closeAlert()
      ajax.open("PATCH", "{{route('user.keranjang.tambah')}}", true)
      ajax.setRequestHeader("Content-Type", "application/json")
      ajax.setRequestHeader("Authorization", `Bearer ${token}`)
      ajax.send(JSON.stringify({id_produk}))
  }

  function kurangiFromKeranjang(token) {
      const id_produk = document.getElementById("id").value
      ajax.onreadystatechange = () => {
        if(ajax.readyState == ajax.DONE) {
          showAlert(ajax.status == 200 ? "success" : "danger", ajax.status == 200 ?
          "Produk berhasil dikurangi dari keranjang" : "Produk gagal dikurangi dari keranjang")
        }
        if(ajax.readyState == ajax.DONE && ajax.status == 200) {
          document.getElementById('jumlah-di-keranjang').dataset.jumlah = parseInt(document.getElementById('jumlah-di-keranjang').dataset.jumlah) - 1
          document.getElementById('jumlah-di-keranjang').innerText = document.getElementById('jumlah-di-keranjang').dataset.jumlah
        }
        if(document.getElementById('jumlah-di-keranjang').dataset.jumlah == 0) {
          document.getElementById('hapus-button').disabled = true
          document.getElementById('kurangi-button').disabled = true
        }
        if(parseInt(document.getElementById('jumlah-di-keranjang').dataset.jumlah) <
          parseInt(document.getElementById('jumlah-di-keranjang').dataset.maks)) {
          document.getElementById('tambah-button').disabled = false
        }
      }
      closeAlert()
      ajax.open("PATCH", "{{route('user.keranjang.kurangi')}}", true)
      ajax.setRequestHeader("Content-Type", "application/json")
      ajax.setRequestHeader("Authorization", `Bearer ${token}`)
      ajax.send(JSON.stringify({id_produk}))
  }

  function hapusFromKeranjang(token) {
      const id_produk = document.getElementById("id").value
      ajax.onreadystatechange = () => {
        if(ajax.readyState == ajax.DONE) {
          showAlert(ajax.status == 200 ? "success" : "danger", ajax.status == 200 ?
          "Produk berhasil dihapus dari keranjang" : "Produk gagal dihapus dari keranjang")
        }
        if(ajax.readyState == ajax.DONE && ajax.status == 200) {
          document.getElementById('jumlah-di-keranjang').dataset.jumlah = 0
          document.getElementById('jumlah-di-keranjang').innerText = document.getElementById('jumlah-di-keranjang').dataset.jumlah
        }
        if(document.getElementById('jumlah-di-keranjang').dataset.jumlah == 0) {
          document.getElementById('hapus-button').disabled = true
          document.getElementById('kurangi-button').disabled = true
        }
        if(parseInt(document.getElementById('jumlah-di-keranjang').dataset.jumlah) <
          parseInt(document.getElementById('jumlah-di-keranjang').dataset.maks)) {
          document.getElementById('tambah-button').disabled = false
        }
      }
      closeAlert()
      ajax.open("DELETE", "{{route('user.keranjang.hapus')}}", true)
      ajax.setRequestHeader("Content-Type", "application/json")
      ajax.setRequestHeader("Authorization", `Bearer ${token}`)
      ajax.send(JSON.stringify({id_produk}))
  }
</script>
@endsection