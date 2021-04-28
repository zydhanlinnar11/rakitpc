@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">
        <a href="javascript:history.back()" class="fas fa-arrow-left" style="text-decoration: none; color: #212529"></a>
        {{$title}}
    </h1>
    <hr>
    @if ($item_count == 0)
    <x-tidak_ada_apapun />
    @else
    <div class="row">
        @foreach ($list_item as $key)
            <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-4 col-sm-6">
                <div class="card text-center col-12" style="margin-bottom: 16px">
                    <img src="{{$key->url_gambar}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$key->nama}}</h5>
                            <a href="/item?item_id={{$key->id}}" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
            </div>
        @endforeach
    </div>
    @endif
</div>
@endsection