@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">Dashboard</h1>
    <hr>
    <div class="row">
        @foreach ($dashboard as $item)
        <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="card col-12">
                <img src="{{ $item["imageURL"] }}" class="card-img-top" alt="{{ $item["slug"] }}-image">
                <div class="card-body">
                  <h5 class="card-title">{{ $item["title"] }}</h5>
                  <p class="card-text">{{ $item["description"] }}</p>
                  <a href="/admin/{{ $item["slug"] }}" class="btn btn-primary">{{ $item["buttonTitle"] }}</a>
                </div>
            </div>
        </div>
        @endforeach      
    </div>
</div>
@endsection