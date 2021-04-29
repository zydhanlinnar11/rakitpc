@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle='$item->nama'>
  <div class="row mb-3">
    <div class="col-xl-6 text-center">
        <img src="{{$item->url_gambar}}" alt="Gambar dari {{$item->nama}}" style="max-height: 350px">
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
      </div>
  </div>

  <hr>

  <div class="row mb-3">
      <h4 class="mt-1 mb-3">Deskripsi</h4>
      @foreach ($deskripsi as $par)
      <p>{{$par}}</p>
      @endforeach
  </div>
</x-_content_container>
@endsection