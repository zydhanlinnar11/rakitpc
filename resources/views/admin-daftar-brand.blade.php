@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Daftar brand'">
    <div class="row mt-3">
        @foreach ($list_brand as $key)
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
            <div class="card text-center col-12" style="margin-bottom: 16px">
                <div class="text-center card-img-top mt-1">
                    <img src="{{$key->url_logo}}"
                    alt="Gambar dari {{$key->nama}}" style="max-height: 120px; max-width: 100%">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{$key->nama}}</h5>
                    <a href="/admin/edit-brand?id={{$key->id}}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-_content_container>
@endsection