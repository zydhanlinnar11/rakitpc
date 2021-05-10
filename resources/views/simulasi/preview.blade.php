@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Preview simulasi ('.$kode_simulasi.')'" :href="'./'">
    <div class="alert alert-info" role="alert">
      Simulasi dibuat pada {{$created_at}} dan terakhir diubah pada {{$updated_at}}. Harga yang ditampilkan menunjukkan harga saat ini yang dapat berubah sewaktu-waktu.
    </div>
    <x-_admin_form_alert />
    <h6>Menggunakan kompatibilitas: {{$kompatibilitas ? "Ya" : "Tidak"}}</h6>
    @if ($kompatibilitas && isset($brand) && isset($socket))
    <h6>Setup kompatibilitas: {{$brand}} ({{$socket}})</h6>
    @endif
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Kategori</th>
            <th scope="col"></th>
            <th scope="col">Produk</th>
            <th scope="col">Harga Satuan</th>
            <th scope="col">Jumlah Barang</th>
            <th scope="col">Subtotal Harga</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($array_simulasi as $item)
          <tr>
            <th scope="row">{{$item['kategori']}}</th>
            <td><img src="{{$item['url_gambar']}}" alt="Gambar dari {{$item['nama']}}" style="max-height: 50px;"></td>
            <td><a href="{{route('item.view')}}?item_id={{$item['id']}}">{{$item['nama']}}</a></td>
            <td>Rp {{number_format($item['harga'], 2)}}</td>
            <td>{{$item['jumlah']}}</td>
            <td>Rp {{number_format($item['harga'] * $item['jumlah'], 2)}}</td>
          </tr>
          @endforeach
        </tbody>
    </table>
    <div class="text-end mb-3">
        <h6>Total harga : Rp {{number_format($total_harga, 2)}}</h6>
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <button onclick="window.open(`{{route('simulasi')}}?kode_simulasi=${new URLSearchParams(window.location.search).get('kode_simulasi')}`, '_self')"
                class="btn btn-secondary col-12">Ubah</button>
        </div>
        <form action="javascript:getToken(addToKeranjang, '{{csrf_token()}}')" class="col-6">
            @if (Auth::check())
            <button class="btn btn-primary col-12">Tambahkan semua ke keranjang</button>
            @else
            {{Session::put('url.intended', URL::full())}}
            <a href="{{route('auth.google.redirect')}}" class="btn btn-primary col-12">Login untuk menambahkan ke keranjang</a>
            @endif
        </form>
    </div>
</x-_content_container>
<script>
  function addToKeranjang(token) {
      const kode_simulasi = new URLSearchParams(window.location.search).get('kode_simulasi')
      ajax.onreadystatechange = () => {
        if(ajax.readyState == ajax.DONE) {
          showAlert(ajax.status == 200 ? "success" : "danger", ajax.status == 200 ?
          "Produk berhasil ditambahkan ke keranjang" : "Produk gagal ditambahkan ke keranjang")
        }
      }
      closeAlert()
      ajax.open("POST", "{{route('user.keranjang.tambah-from-simulasi')}}", true)
      ajax.setRequestHeader("Content-Type", "application/json")
      ajax.setRequestHeader("Authorization", `Bearer ${token}`)
      ajax.send(JSON.stringify({kode_simulasi}))
  }
</script>
@endsection