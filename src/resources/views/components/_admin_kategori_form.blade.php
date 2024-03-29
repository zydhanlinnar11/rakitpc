<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">Nama kategori:</span>
    <input
        @isset($kategori)
            value="{{$kategori->nama}}"
        @endisset
        type="text" id="nama" name="nama" class="form-control" placeholder="Nama kategori" aria-label="nama" aria-describedby="basic-addon1">
</div>
<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon2">Font awesome class:</span>
    <input
        @isset($kategori)
        value="{{$kategori->fa_class}}"
        @endisset
    type="text" id="fa-class" name="fa-class" class="form-control" placeholder="Font awesome class" aria-label="fa-class" aria-describedby="basic-addon2">
</div>
<input
@isset($kategori)
value="{{$kategori->id}}"
@endisset
type="text" name="id_kategori" id="id_kategori" style="width: 0; height: 0; visibility: hidden; position: absolute">
<div class="row">
    <div class="col-4">
        <button onclick="history.back()" type="button" id="back-button" class="btn btn-secondary col-12 mb-3">Kembali</button>
    </div>
    <div class="col-4">
        {{$button_mid}}
    </div>
    <div class="col-4">
        {{$button_right}}
    </div>
</div>
