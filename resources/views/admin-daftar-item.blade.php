@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">
        <a href="./" class="fas fa-arrow-left" style="text-decoration: none; color: #212529"></a>
        Daftar produk:
    </h1>
    <hr>
    <form style="display: flex">
        <div class="col-md-4">
            <div class="input-group mb-3">
                <span class="input-group-text">Kategori:</span>
                <select name="filter-kategori" id="filter-kategori" class="form-select">
                    <option value="" {{$selected_kategori == '' ? 'selected' : ''}}>Semua kategori</option>
                    @foreach ($list_kategori as $kategori)
                    <option value="{{$kategori["id"]}}" {{$selected_kategori == $kategori["id"] ? 'selected' : ''}}>
                        {{$kategori["nama"]}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-outline-primary mb-3 ms-2">Filter</button>
    </form>

    <div class="row">
        @foreach ($list_produk as $key)
        <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-4 col-sm-6">
            <div class="card text-center col-12" style="margin-bottom: 16px">
                <img src="https://storage.googleapis.com/zydhan-web.appspot.com/gambar-biner.webp" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$key->nama}}</h5>
                        <h6 class="card-text">{{$key->deskripsi}}</h6>
                        <a href="/admin/edit-produk?id={{$key->id}}" class="btn btn-primary">Edit produk</a>
                    </div>
                </div>
        </div>
        @endforeach
    </div>
</div>
@endsection