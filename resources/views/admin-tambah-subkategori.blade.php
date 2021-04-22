@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">
        <a href="./" class="fas fa-arrow-left" style="text-decoration: none; color: #212529"></a>
    Tambah subkategori</h1>
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
    <form action="javascript:tambahSubkategori()" method="POST">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nama subkategori:</span>
            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama subkategori" aria-label="nama" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Kategori:</span>
            <select name="kategori" id="kategori" class="form-select">
                <option value="">Pilih kategori</option>
                @foreach ($list_kategori as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
                @endforeach
            </select>
        </div>
        <label for="deskripsi" class="mb-2">Deskripsi:</label>
        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control mb-3"></textarea>
        <button type="submit" id="tambah-button" class="btn btn-primary mb-3">Tambahkan</button>
    </form>
</div>
@endsection