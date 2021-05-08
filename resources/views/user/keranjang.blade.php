@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Keranjang'">
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
          @foreach ($list as $item)
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
    {{-- <div class="text-end mb-3">
        <h6>Total harga : Rp {{number_format($total_harga, 2)}}</h6>
    </div> --}}
    <div class="row mb-3">
        <div class="col-6">
            <button onclick="window.open(`{{route('simulasi')}}?kode_simulasi=${new URLSearchParams(window.location.search).get('kode_simulasi')}`, '_self')"
                class="btn btn-secondary col-12">Ubah</button>
        </div>
        <div class="col-6">
            <button class="btn btn-primary col-12">Checkout</button>
        </div>
    </div>
</x-_content_container>
@endsection