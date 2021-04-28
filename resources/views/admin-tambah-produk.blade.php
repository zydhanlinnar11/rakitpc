@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">
        <a href="./" class="fas fa-arrow-left" style="text-decoration: none; color: #212529"></a>
    Tambah produk</h1>
    <hr>
    <div
      id="alert"
      class="alert alert-dismissible"
      role="alert"
      style="visibility: hidden; position: fixed"
    >
      <span id="alert-message"></span
      ><button
        type="button"
        id="alert-close-btn"
        class="btn-close"
        aria-label="Close"
      ></button>
    </div>
    <form action="javascript:tambahItem()" method="POST">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text">Nama item:</span>
            <input type="text" id="simulasi-nama" name="nama" class="form-control" placeholder="Nama item">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Berat barang:</span>
            <input type="number" name="berat" id="simulasi-berat" class="form-control" min="0" placeholder="Berat barang (kg)">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Harga barang:</span>
            <input type="number" name="harga" id="simulasi-harga" class="form-control" min="0" placeholder="Harga barang">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Stok barang:</span>
            <input type="number" name="stok" id="simulasi-stok" class="form-control" min="0" placeholder="Stok barang">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">URL gambar:</span>
            <input type="text" id="simulasi-url-gambar" name="url-gambar" class="form-control" placeholder="URL gambar">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Kategori:</span>
            <select onchange="onchangeKategori()" name="kategori" id="simulasi-kategori" class="form-select">
                <option value="" selected>Pilih kategori</option>
                @foreach ($list_kategori as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Brand:</span>
            <select name="brand" id="simulasi-brand" class="form-select">
                <option value="" selected>Pilih brand</option>
                @foreach ($list_brand as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Socket:</span>
            <select
            data-on-if-kategori-id="{{ $prosesor_kategori_id }}"
            name="socket"
            id="simulasi-socket"
            class="form-select" disabled>
                <option value="" selected>Pilih socket prosesor</option>
                @foreach ($list_socket as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Subkategori:</span>
            <select name="subkategori" id="simulasi-subkategori" class="form-select">
                <option value="" selected>Pilih subkategori</option>
            </select>
        </div>
        <label for="deskripsi" class="mb-2">Deskripsi:</label>
        <textarea name="deskripsi" id="simulasi-deskripsi" cols="30" rows="10" class="form-control mb-3"></textarea>
        <button type="submit" id="simulasi-tambah-button" class="btn btn-primary mb-3">Tambahkan</button>
    </form>
</div>
@endsection