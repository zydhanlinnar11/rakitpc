<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">Nama subkategori:</span>
    <input
    @isset($subkategori)
    value="{{$subkategori->nama}}"
    @endisset
    type="text" id="nama" name="nama" class="form-control" placeholder="Nama subkategori" aria-label="nama" aria-describedby="basic-addon1">
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Kategori:</span>
    <select name="kategori" id="kategori" class="form-select">
        <option value="">Pilih kategori</option>
        @foreach ($listKategori as $item)
        <option value="{{$item->id}}"
            @isset($subkategori)
            {{$subkategori->id_kategori == $item->id ? 'selected' : ''}}
            @endisset
        >{{$item->nama}}</option>
        @endforeach
    </select>
</div>
<label for="deskripsi" class="mb-2">Deskripsi:</label>
<textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control mb-3">@isset($subkategori){{$subkategori->deskripsi}}@endisset
</textarea>
<div class="row mb-3">
    <div class="col-4">
        <a href="./" class="btn btn-secondary col-12">Back</a>
    </div>
    <div class="col-4">
        {{$middle_button}}
    </div>
    <div class="col-4">
        {{$right_button}}
    </div>
</div>