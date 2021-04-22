@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">
        <a href="./" class="fas fa-arrow-left" style="text-decoration: none; color: #212529"></a>
    Tambah kategori</h1>
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
    <form action="javascript:tambahKategori()" method="POST">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nama kategori:</span>
            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama kategori" aria-label="nama" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">Font awesome class:</span>
            <input type="text" id="fa-class" name="fa-class" class="form-control" placeholder="Font awesome class" aria-label="fa-class" aria-describedby="basic-addon2">
        </div>
        <button type="submit" id="tambah-button" class="btn btn-primary mb-3">Tambahkan</button>
    </form>
</div>
@endsection