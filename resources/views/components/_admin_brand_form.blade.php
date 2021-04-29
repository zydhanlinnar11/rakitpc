<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">Nama brand:</span>
    <input type="text" id="nama" name="nama" class="form-control"
        placeholder="Nama brand" aria-label="nama" aria-describedby="basic-addon1"
        @isset($brand)
        value="{{$brand->nama}}"
        @endisset
        >
</div>
<label for="deskripsi" class="mb-2">Deskripsi:</label>
<textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control mb-3">
    @isset($brand)
        value="{{$brand->deskripsi}}"
    @endisset    
</textarea>
<button type="submit" id="tambah-button" class="btn btn-primary mb-3">Tambahkan</button>