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
            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama item">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Berat barang:</span>
            <input type="number" name="berat" id="berat" class="form-control" min="0" placeholder="Berat barang (kg)">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Harga barang:</span>
            <input type="number" name="harga" id="harga" class="form-control" min="0" placeholder="Harga barang">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Stok barang:</span>
            <input type="number" name="stok" id="stok" class="form-control" min="0" placeholder="Stok barang">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">URL gambar:</span>
            <input type="text" id="url-gambar" name="url-gambar" class="form-control" placeholder="URL gambar">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Kategori:</span>
            <select onchange="onchangeKategori()" name="kategori" id="kategori" class="form-select">
                <option value="">Pilih kategori</option>
                @foreach ($list_kategori as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Brand:</span>
            <select name="brand" id="brand" class="form-select">
                <option value="">Pilih brand</option>
                @foreach ($list_brand as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Socket:</span>
            <select name="socket" id="socket" class="form-select">
                <option value="">Pilih socket prosesor</option>
            </select>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Subkategori:</span>
            <select name="subkategori" id="subkategori" class="form-select">
                <option value="">Pilih subkategori</option>
            </select>
        </div>
        <label for="deskripsi" class="mb-2">Deskripsi:</label>
        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control mb-3"></textarea>
        <button type="submit" id="tambah-button" class="btn btn-primary mb-3">Tambahkan</button>
    </form>
</div>
@endsection