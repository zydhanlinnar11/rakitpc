@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Keranjang'">
  <div class="modal fade" id="pembayaranModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih metode pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="javascript:getToken(checkOut, '{{csrf_token()}}')">
          @csrf
          <div class="modal-body">
            <ul class="list-group">
              <li class="list-group-item">
                <input class="form-check-input payment-radio" type="radio" name="1" id="1" data-id="1" checked>
                Saldo : Rp {{number_format(Auth::user()['saldo'], 2)}} 
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @if (!$checkoutable && !$is_stok_enough)
  <div class="alert alert-danger" role="alert">
    <i class="fas fa-exclamation-circle"></i> Beberapa produk mungkin telah berubah stok, silahkan sesuaikan jumlah produk kembali.
  </div>
  @endif
  @if (!$checkoutable && $is_stok_enough)
  <div class="alert alert-warning" role="alert">
    Tidak ada produk yang dibeli! Tidak dapat melakukan checkout
  </div>
  @endif
    <form action="javascript:(new bootstrap.Modal(document.getElementById('pembayaranModal'))).toggle()">
      @csrf
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Pilih</th>
            <th scope="col">Kategori</th>
            <th scope="col"></th>
            <th scope="col">Produk</th>
            <th scope="col">Harga Satuan</th>
            <th scope="col">Jumlah Barang</th>
            <th scope="col">Subtotal Harga</th>
            <th scope="col">Ubah</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $item)
          <tr>
            <td><input class="form-check-input item-checkbox" type="checkbox" data-jumlah="{{$item['jumlah']}}"
              data-id="{{$item['id']}}"
            @if (!$item['is_stok_enough'])
            disabled
            @endif
            ></td>
            <th scope="row">{{$item['kategori']}}</th>
            <td><img src="{{$item['url_gambar']}}" alt="Gambar dari {{$item['nama']}}" style="max-height: 50px;"></td>
            <td><a href="{{route('item.view')}}?item_id={{$item['id']}}">{{$item['nama']}}</a></td>
            <td>Rp {{number_format($item['harga'], 2)}}</td>
            <td>{{$item['jumlah']}} 
            @if (!$item['is_stok_enough'])
            <i style="color: red" class="fas fa-exclamation-circle"></i>
            @endif
            </td>
            <td>Rp {{number_format($item['harga'] * $item['jumlah'], 2)}}</td>
            <td><button class="btn btn-info" onclick="window.open('{{route('item.view')}}?item_id={{$item['id']}}', '_self')">Ubah</button></td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div class="text-end mb-3">
        <h6>Total pembayaran : Rp {{number_format($jumlah_total_harga, 2)}}</h6>
      </div>
      <div class="row mb-3">
        <div class="col-12">
            <button type="reset" class="btn btn-warning col-12"
            @if ($jumlah_total_produk == 0)
                disabled
            @endif
            >Batalkan semua pilihan</button>
        </div>
      </div>
      <div class="row mb-3">
          <div class="col-12">
              <button type="submit" class="btn btn-primary col-12"
              @if (!$checkoutable)
                  disabled
              @endif
              >Checkout</button>
          </div>
      </div>
    </form>
</x-_content_container>
<script>
  function addSelectedItemToArray(data) {
    const checkboxes = document.getElementsByClassName('item-checkbox')
    for(let i=0; i<checkboxes.length; i++) {
      const checkbox = checkboxes[i];
      if(checkbox.checked) {
        const item = {  }
        item[`${checkbox.dataset.id}`] = checkbox.dataset.jumlah
        data.push(item)
      }
    }
  }

  function getPaymentId() {
    const radios = document.getElementsByClassName('payment-radio')
    for(let i=0; i<radios.length; i++) {
      const radio = radios[i];
      if(radio.checked) {
        return radio.dataset.id
      }
    }
  }

  function checkOut(token) {
    const data = []
    addSelectedItemToArray(data)
    makeTransaction({
      'paymentId': getPaymentId(),
      data
    }, token)
  }

  function makeTransaction(transaction, token) {
    const xhr = new XMLHttpRequest()

    xhr.onreadystatechange = () => {
      if (xhr.readyState == xhr.DONE && xhr.status == 200 && 'redirectURL' in JSON.parse(xhr.response)) {
          window.open(JSON.parse(xhr.response).redirectURL, '_self')
      }
    };

    xhr.open("POST", "{{route('user.transaksi.new')}}", true)
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.setRequestHeader("Authorization", `Bearer ${token}`)
    xhr.send(JSON.stringify(transaction))
  }
</script>
@endsection