@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">Kategori</h1>
    <hr>
    <div class="row">

        @foreach ($list_kategori as $key)
            <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card text-center col-12" style="margin-bottom: 16px">
                    <img src="https://storage.googleapis.com/zydhan-web.appspot.com/gambar-biner.webp" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$key["nama"]}}</h5>
                        <a href="kategori/{{$key["url"]}}" class="btn btn-primary streched-link">{{$key["nama"]}}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection