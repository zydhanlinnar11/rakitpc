@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Daftar socket'">
    <form style="display: flex">
        <div class="col-md-4">
            <div class="input-group mb-3">
                <span class="input-group-text">Brand:</span>
                <select name="filter-brand" id="filter-brand" class="form-select">
                    <option value="" {{$selected_brand == '' ? 'selected' : ''}}>Semua brand</option>
                    @foreach ($list_brand as $brand)
                    <option value="{{$brand->id}}" {{$selected_brand == $brand->id ? 'selected' : ''}}>
                        {{$brand->nama}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-outline-primary mb-3 ms-2">Filter</button>
    </form>
    @if ($list_socket->count() == 0)
        <x-tidak_ada_apapun />
    @endif
    <div class="row mt-3">
        @foreach ($list_socket as $key)
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
            <div class="card text-center col-12" style="margin-bottom: 16px">
                <div class="card-body">
                    <h5 class="card-title">{{$key->nama}}</h5>
                    <a href="/admin/edit-socket?id={{$key->id}}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-_content_container>
@endsection