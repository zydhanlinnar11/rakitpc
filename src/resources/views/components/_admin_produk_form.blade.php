@csrf
<div class="input-group mb-3">
    <span class="input-group-text">Nama item:</span>
    <input
    @isset($produk)
    value="{{$produk->nama}}"
    @endisset
    type="text" id="nama" name="nama" class="form-control" placeholder="Nama item">
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Berat barang:</span>
    <input
    @isset($produk)
    value="{{$produk->berat}}"
    @endisset
    type="number" name="berat" id="berat" class="form-control" min="0" placeholder="Berat barang (kg)">
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Harga barang:</span>
    <input
    @isset($produk)
    value="{{$produk->harga}}"
    @endisset
    type="number" name="harga" id="harga" class="form-control" min="0" placeholder="Harga barang">
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Stok barang:</span>
    <input
    @isset($produk)
    value="{{$produk->stok}}"
    @endisset
    type="number" name="stok" id="stok" class="form-control" min="0" placeholder="Stok barang">
</div>
<div class="input-group mb-3">
    <span class="input-group-text">URL gambar:</span>
    <input
    @isset($produk)
    value="{{$produk->url_gambar}}"
    @endisset
    type="text" id="url-gambar" name="url-gambar" class="form-control" placeholder="URL gambar">
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Kategori:</span>
    <select onchange="onchangeKategori()" name="kategori" id="kategori" class="form-select">
        <option value="" selected>Pilih kategori</option>
        @foreach ($listKategori as $item)
        <option value="{{$item->id}}"
            @isset($produk)
            {{$produk->id_kategori == $item->id ? 'selected' : ''}}
            @endisset
        >{{$item->nama}}</option>
        @endforeach
    </select>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Brand:</span>
    <select name="brand" id="brand" class="form-select">
        <option value="" selected>Pilih brand</option>
        @foreach ($listBrand as $item)
        <option value="{{$item->id}}"
            @isset($produk)
            {{$produk->id_brand == $item->id ? 'selected' : ''}}
            @endisset
        >{{$item->nama}}</option>
        @endforeach
    </select>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Socket:</span>
    <select
    data-processor-category-id="{{ $processorCategoryId }}"
    data-motherboard-category-id="{{ $motherboardCategoryId }}"
    name="socket"
    id="socket"
    class="form-select"
    @if (!$isThisProcessorOrMotherboard)
    disabled
    @endif
    >
        <option value="">Pilih socket prosesor</option>
        @foreach ($listSocket as $item)
        <option value="{{$item->id}}"
            @isset($produk)
            {{$produk->id_socket == $item->id ? 'selected' : ''}}
            @endisset
        >{{$item->nama}}</option>
        @endforeach
    </select>
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Subkategori:</span>
    <select name="subkategori" id="subkategori" class="form-select"
    @isset($produk)
        data-selected-sub="{{$produk->id_subkategori}}"
    @endisset
    >
        <option value="" selected>Pilih subkategori</option>
    </select>
</div>
<label for="deskripsi" class="mb-2">Deskripsi:</label>
<textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control mb-3">@isset($produk){{$produk->deskripsi}}@endisset</textarea>
<div class="row mb-3" style="row-gap: 8px">
    <div class="col-4">
        <button onclick="history.back()" type="button" class="btn btn-secondary col-12">Kembali</button>
    </div>
    <div class="col-4">
        @isset($button_mid)
        {{$button_mid}}
        @endisset
    </div>
    <div class="col-4">
        {{$button_right}}
    </div>
</div>