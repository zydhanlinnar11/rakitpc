@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Daftar subkategori'">
    <form style="display: flex">
        <div class="col-md-4">
            <div class="input-group mb-3">
                <span class="input-group-text">Kategori:</span>
                <select name="filter-kategori" id="filter-kategori" class="form-select">
                    <option value="" {{$selected_kategori == '' ? 'selected' : ''}}>Semua kategori</option>
                    @foreach ($list_kategori as $kategori)
                    <option value="{{$kategori->id}}" {{$selected_kategori == $kategori->id ? 'selected' : ''}}>
                        {{$kategori->nama}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-outline-primary mb-3 ms-2">Filter</button>
    </form>
    @if ($list_subkategori->count() == 0)
        <x-tidak_ada_apapun />
    @endif
    <div class="row mt-3">
        @foreach ($list_subkategori as $key)
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
            <div class="card text-center col-12" style="margin-bottom: 16px">
                <div class="card-body">
                    <h5 class="card-title">{{$key->nama}}</h5>
                    <a href="/admin/edit-subkategori?id={{$key->id}}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-_content_container>
@endsection