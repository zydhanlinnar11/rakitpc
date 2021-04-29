@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Daftar produk'">
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

    @if ($item_count > 0)
    <div class="row">
        @foreach ($list_produk as $key)
        <x-_list_item_card :key="$key">
            <x-slot name="button1">
                <a href="/admin/edit-produk?id={{$key->id}}" class="btn btn-primary">Edit produk</a>
                <a href="/item?item_id={{$key->id}}" class="btn btn-secondary mt-2">Lihat produk</a>
            </x-slot>
        </x-_list_item_card>
        @endforeach
    </div>
    @else
    <x-tidak_ada_apapun />
    @endif
</x-_content_container>
@endsection