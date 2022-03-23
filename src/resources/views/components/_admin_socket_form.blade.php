<div class="input-group mb-3">
    <span class="input-group-text" id="nama-label">Nama socket:</span>
    <input
        @isset($socket)
            value="{{$socket->nama}}"
        @endisset
        type="text" id="nama" name="nama" class="form-control" placeholder="Nama socket" aria-label="nama" aria-describedby="nama-label">
</div>
<div class="input-group mb-3">
    <span class="input-group-text" id="brand-label">Brand:</span>
    <select name="brand" id="brand" class="form-select">
        <option value="">Pilih brand</option>
        @foreach ($listBrand as $item)
        <option value="{{$item->id}}"
            @isset($socket)
            {{$socket->id_brand == $item->id ? 'selected' : ''}}
            @endisset
        >{{$item->nama}}</option>
        @endforeach
    </select>
</div>
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
