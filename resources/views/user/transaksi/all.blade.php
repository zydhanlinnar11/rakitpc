@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Semua Transaksi'">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Total harga</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transaksi as $item)
          <tr>
            <th scope="row"><a href="{{route('user.transaksi.view')}}?id={{$item['id_transaksi']}}">{{$item['id_transaksi']}}</a></th>
            <td>{{$item['created_at']}}</td>
            <td>Rp {{number_format($item['total_harga'], 2)}}</td>
          </tr>
          @endforeach
        </tbody>
       
      </table>

      <div class="row mb-3">
          <div class="col-12">
              <a href="{{route('user.profile')}}" class="btn btn-primary col-12">Kembali ke profil</a>
          </div>
      </div>

    {{-- <div class="text-end mb-3">
        <h6>Total pembayaran : Rp {{number_format($transaksi['total_harga'], 2)}}</h6>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{route('user.transaksi.all')}}" class="btn btn-success col-12">Kembali ke laman daftar transaksi</a>
        </div>
    </div> --}}
</x-_content_container>
@endsection