@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">Simulasi</h1>
    <hr>
    {{-- {{print_r($list_barang[$kategori->id])}} --}}
    <form action="">
        @foreach ($list_kategori as $kategori)
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text">{{$kategori->nama}}</span>
                    <select onchange="hitungHarga(this)" id="{{$kategori->url}}" class="form-select">
                        <option data-harga="0" value="null" selected>Pilih {{$kategori->nama}}</option>
                        @foreach ($list_barang[$kategori->id] as $barang)
                        <option data-harga="{{$barang->harga}}" value="{{$barang->id}}">{{$barang->nama}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <input type="number" min="0" max="99" value="0" name="{{$kategori->url}}" id="{{$kategori->url}}" class="form-control">
            </div>
            <div class="col-md-2">
                <input type="text" value="Rp 0,00" name="{{$kategori->url}}-harga" id="{{$kategori->url}}-harga" class="form-control" readonly>
            </div>
        </div>
        @endforeach
        <div class="input-group mb-3">
            <span class="input-group-text">Total harga:</span>
            <input type="text" value="Rp 0,00" name="total-harga" id="total-harga" class="form-control" readonly>
        </div>
        <button type="reset" class="btn btn-warning mb-3" id="reset-simulasi">Reset simulasi</button>
        <button class="btn btn-primary mb-3" id="preview-simulasi">Preview simulasi</button>
    </form>
    <script src="{{asset('js/simulasi.js')}}" defer></script>
</div>
@endsection
