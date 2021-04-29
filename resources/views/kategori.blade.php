@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Kategori'">
    <div class="row">
        @foreach ($list_kategori as $key)
            <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-4 col-sm-6">
                <div class="card text-center col-12" style="margin-bottom: 16px">
                    <i class="{{$key["fa_class"]}} fa-3x mt-3"></i>
                    <div class="card-body">
                        <h5 class="card-title">{{$key["nama"]}}</h5>
                        <a href="items?kategori={{$key["url"]}}" class="btn btn-primary streched-link">{{$key["nama"]}}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-_content_container>
@endsection