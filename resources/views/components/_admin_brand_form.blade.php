<div class="input-group mb-3">
    <span class="input-group-text" id="nama-label">Nama brand:</span>
    <input type="text" id="nama" name="nama" class="form-control"
        placeholder="Nama brand" aria-label="nama" aria-describedby="nama-label"
        @isset($brand)
        value="{{$brand->nama}}"
        @endisset
        >
</div>
<div class="input-group mb-3">
    <span class="input-group-text" id="url_logo-label">URL logo brand:</span>
    <input type="text" id="url_logo" name="url_logo" class="form-control"
        placeholder="URL logo brand" aria-label="url_logo" aria-describedby="url_logo-label"
        @isset($brand)
        value="{{$brand->url_logo}}"
        @endisset
        >
</div>
<label for="deskripsi" class="mb-2">Deskripsi:</label>
<textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control mb-3">@isset($brand){{$brand->deskripsi}}@endisset
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