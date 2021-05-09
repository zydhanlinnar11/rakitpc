@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Transaksi : '.$transaksi['id_transaksi']">
    <h6>ID Transaksi : {{$transaksi['id_transaksi']}}</h6>
    <h6>Metode pembayaran : {{$payment_processor['nama']}}</h6>
    <h6>Status pembayaran : {{$transaksi['done'] ? 'Pembayaran diterima' : 'Pembayaran pending'}}</h6>
    <h6>Waktu pembelian : {{date_format($transaksi['created_at'],"D, d M Y H.i")}}</h6>
    @if ($transaksi['done'])
    <h6>Waktu pembayaran : {{date_format($transaksi['created_at'],"D, d M Y H.i")}}</h6>
    @endif

    <h6>Produk yang dibeli :</h6>

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

    <div class="text-end mb-3">
        <h6>Total pembayaran : Rp {{number_format($transaksi['total_harga'], 2)}}</h6>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{route('user.transaksi.all')}}" class="btn btn-success col-12">Kembali ke laman daftar transaksi</a>
        </div>
    </div>
</x-_content_container>
@endsection