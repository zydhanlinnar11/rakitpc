@extends('layouts.app')

@section('main-content')<!-- Modal -->
<div class="modal fade" id="warning-modal" tabindex="-1" aria-labelledby="warning-modal-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="warning-modal-label">Ganti kompatibilitas?</h5>
          <button type="button" onclick="undoKompatibilitas()" class="btn-close warning-modal-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="warning-modal-body">
            Penggantian ini akan mereset pilihan prosesor dan motherboard anda. Apakah anda yakin?
        </div>
        <div class="modal-footer">
          <button onclick="undoKompatibilitas()" type="button" class="btn btn-secondary warning-modal-btn" data-bs-dismiss="modal">Cancel</button>
          <button onclick="gantiKompatibilitas()" type="button" class="btn btn-warning warning-modal-btn" data-bs-dismiss="modal">Ganti</button>
        </div>
      </div>
    </div>
</div>
<div class="card-container">
    <h1 class="card-container-title">Simulasi</h1>
    <hr>
    <form action="">
        <h6>Opsi kompatibilitas:</h6>
        <div class="row mb-3" id="bagian-kompatibilitas">
            <div class="input-group">
                <span class="input-group-text">Sesuaikan kompatibilitas:</span>
                <select id="kompatibilitas" onchange="(new bootstrap.Modal(document.getElementById('warning-modal'))).toggle()" class="form-select">
                    <option value="true" selected>Ya</option>
                    <option value="false">Tidak</option>
                </select>
            </div>
        </div>
        <div class="row mb-3" id="bagian-brand-prosesor">
            <div class="input-group">
                <span class="input-group-text">Brand prosesor:</span>
                <select id="brand-prosesor" onchange="onChangeProcessorBrand(this)" class="form-select">
                    <option id="brand-default" value="">Pilih brand</option>
                    @foreach ($brand_processor as $brand)
                    <option value="{{$brand->id}}">{{$brand->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3" id="bagian-socket-prosesor">
            <div class="input-group">
                <span class="input-group-text">Socket prosesor:</span>
                <select id="socket-prosesor" onchange="onChangeProcessorSocket(this)" class="form-select">
                    <option id="socket-default" value="" selected>Pilih socket</option>
                </select>
            </div>
        </div>
        <h6>Komponen utama:</h6>
        <div class="row mb-3" id="bagian-prosesor">
            <div class="col-9">
                <div class="input-group">
                    <span class="input-group-text">Prosesor:</span>
                    <select id="prosesor" class="form-select" onchange="setHarga('prosesor')">
                        <option value="" data-harga="0">Pilih prosesor</option>
                    </select>
                </div>
            </div>
            <div class="col-1">
                <input type="number" class="form-control" name="jumlah-prosesor" id="jumlah-prosesor" min="0" value="1" onchange="setHarga('prosesor')">
            </div>
            <div class="col-2">
                <input type="text" class="form-control" name="harga-prosesor" id="harga-prosesor" value="Rp 0,00" readonly>
            </div>
        </div>
        <div class="row mb-3" id="bagian-motherboard">
            <div class="col-9">
                <div class="input-group">
                    <span class="input-group-text">Motherboard:</span>
                    <select id="motherboard" class="form-select" onchange="setHarga('motherboard')">
                        <option value="" data-harga="0">Pilih motherboard</option>
                    </select>
                </div>
            </div>
            <div class="col-1">
                <input type="number" class="form-control" name="jumlah-motherboard" id="jumlah-motherboard" value="1" min="0" onchange="setHarga('motherboard')">
            </div>
            <div class="col-2">
                <input type="text" class="form-control" name="harga-motherboard" value="Rp 0,00" id="harga-motherboard" readonly>
            </div>
        </div>
        <div class="row mb-3" id="bagian-ram">
            <div class="col-9">
                <div class="input-group">
                    <span class="input-group-text">Memori RAM:</span>
                    <select id="ram" class="form-select" onchange="setHarga('ram')">
                        <option value="" data-harga="0">Pilih Memori RAM</option>
                        @foreach ($list_ram as $item)
                        <option value="{{$item->id}}" data-harga="{{$item->harga}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-1">
                <input type="number" class="form-control" name="jumlah-ram" id="jumlah-ram" value="1" min="0" onchange="setHarga('ram')">
            </div>
            <div class="col-2">
                <input type="text" class="form-control" name="harga-ram" value="Rp 0,00" id="harga-ram" readonly>
            </div>
        </div>
        <h6>Komponen lainnya:</h6>
        @foreach ($kategori_lain as $kategori)
        <div class="row mb-3" id="bagian-{{$kategori->url}}">
            <div class="col-9">
                <div class="input-group">
                    <span class="input-group-text">{{$kategori->nama}}:</span>
                    <select id="{{$kategori->url}}" class="form-select" onchange="setHarga('{{$kategori->url}}')">
                        <option value="" data-harga="0">Pilih {{$kategori->nama}}</option>
                        @foreach ($list_item as $item)
                        @if ($item->id_kategori == $kategori->id)
                        <option value="{{$item->id}}" data-harga="{{$item->harga}}">{{$item->nama}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-1">
                <input type="number" class="form-control" name="jumlah-{{$kategori->url}}" id="jumlah-{{$kategori->url}}" value="1" min="0" onchange="setHarga('{{$kategori->url}}')">
            </div>
            <div class="col-2">
                <input type="text" class="form-control" name="harga-{{$kategori->url}}" value="Rp 0,00" id="harga-{{$kategori->url}}" readonly>
            </div>
        </div>
        @endforeach
        <div class="row mb-3">
            <div class="input-group">
                <span class="input-group-text">Total harga:</span>
                <input type="text" name="total-harga" id="total-harga"value="Rp 0,00" class="form-control" readonly>
            </div>
        </div>
        <div class="row" id="bagian-tombol">
            <div class="col-6 mb-3">
                <button type="reset" class="btn btn-warning mb-3 col-12" id="reset-simulasi">Reset simulasi</button>
            </div>
            <div class="col-6 mb-3">
                <button class="btn btn-primary mb-3 col-12" id="preview-simulasi">Preview simulasi</button>
            </div>
        </div>
    </form>
</div>
<script>
    let totalHarga = 0
    let harga = {}
    let kompatibilitas = document.getElementById('kompatibilitas').value

    function gantiKompatibilitas() {
        resetKomponenUtama()
        kompatibilitas = document.getElementById('kompatibilitas').value
        document.getElementById('socket-default').selected = true
        document.getElementById('brand-default').selected = true
        if(kompatibilitas == 'false') {
            document.getElementById('socket-prosesor').disabled = true
            document.getElementById('brand-prosesor').disabled = true
            fetchProsesorOrMotherboard('prosesor', false, -1, resetProsesor())
            fetchProsesorOrMotherboard('motherboard', false, -1, resetMotherboard())
        } else {
            document.getElementById('socket-prosesor').disabled = false
            document.getElementById('brand-prosesor').disabled = false
        }
    }

    function undoKompatibilitas() {
        document.getElementById('kompatibilitas').value = kompatibilitas
    }

    function formatHarga(value = 0) {
        return (new Intl.NumberFormat('ID', {style: 'currency', currency: 'IDR'})).format(value)
    }

    function onChangeProcessorBrand(selected) {
        const processorBrandSelect = document.getElementById('socket-prosesor')
        const url = `/api/socket?id_brand=${selected.value}`
        fetch(url).then(res => res.json()).then(socketList => {
            resetSocketProsesor()
            resetKomponenUtama()
            socketList.forEach(socket => {
                option = document.createElement('option')
                option.value = socket.id
                option.text = socket.nama
                processorBrandSelect.add(option)
            })
        }).catch(err => console.error(err))
    }

    function onChangeProcessorSocket(selected) {
        const useCompatibility = kompatibilitas
        let urlMotherboard = '/api/motherboard'

        if(useCompatibility) {
            const query = `?id_socket=${(selected.value == '' ? -1 : selected.value)}`
            urlMotherboard += query
        }
        
        resetKomponenUtama()
        fetchProsesorOrMotherboard('prosesor', useCompatibility, selected.value, resetProsesor())
        fetchProsesorOrMotherboard('motherboard', useCompatibility, selected.value, resetMotherboard())
    }

    function resetProsesor() {
        const processorSelect = document.getElementById('prosesor')
        for(let i=processorSelect.length - 1; i > 0; i--)
            processorSelect.remove(i)
        setHarga('prosesor')
    }

    function resetMotherboard() {
        const motherboardSelect = document.getElementById('motherboard')
        for(let i=motherboardSelect.length - 1; i > 0; i--)
            motherboardSelect.remove(i)
        setHarga('motherboard')
    }

    function fetchProsesorOrMotherboard(whatToFetch = '', useCompatibility = false, id = 0, resetCallback = (() => null)) {
        if(useCompatibility && !id) id = -1
        let url = `/api/${whatToFetch}${useCompatibility ? `?id_socket=${id}` : ''}`
        const select = document.getElementById(whatToFetch)
        fetch(url).then(res => res.json()).then(items => {
            resetCallback()
            items.forEach(item => {
                option = document.createElement('option')
                option.value = item.id
                option.text = item.nama
                option.dataset.harga = item.harga
                select.add(option)
            })
        }).catch(err => console.error(err))
    }

    function resetSocketProsesor() {
        const processorSocketSelect = document.getElementById('socket-prosesor')
        for(let i=processorSocketSelect.length - 1; i > 0; i--)
            processorSocketSelect.remove(i)
    }

    function resetKomponenUtama() {
        resetProsesor()
        resetMotherboard()
    }

    function updateTotalHarga() {
        const totalHargaInput = document.getElementById('total-harga')
        totalHargaInput.value = formatHarga(totalHarga)
    }

    function setHarga(nama = '') {
        totalHarga -= (nama in harga ? harga[nama] : 0)

        const selectProduk = document.getElementById(nama).children
        let hargaProduk = 0;
        for(let i=0; i<selectProduk.length; i++) {
            if(selectProduk[i].selected) {
                hargaProduk = selectProduk[i].dataset.harga
                break;
            }
        }
        const jumlahProduk = document.getElementById(`jumlah-${nama}`).value
        const totalHargaProduk = document.getElementById(`harga-${nama}`)
        if(hargaProduk == undefined || isNaN(hargaProduk)) return
        harga[nama] = hargaProduk * jumlahProduk
        totalHargaProduk.value = formatHarga(harga[nama])
        totalHarga += harga[nama]

        updateTotalHarga()
    }
</script>
@endsection
