@extends('layouts.app')

@section('main-content')
<x-_modal_two_buttons :id="'delete-modal'" :title="'Hapus socket?'"
    :prompt="'Yakin ingin menghapus '.$socket->nama.'? Tindakan ini tidak dapat dibatalkan setelah dieksekusi.'">
    <x-slot name="button_action">
        <button onclick="getToken(deleteSocket, '{{csrf_token()}}')" type="button" class="btn btn-danger delete-modal-btn">Hapus</button>
    </x-slot>
</x-_modal_two_buttons>
<x-_content_container :pageTitle="'Edit socket '.$socket->nama">
    @if (!$is_deletable)
    <div class="alert alert-info" role="alert">
        Socket tidak dapat dihapus karena ada item yang termasuk socket ini!
    </div>   
    @endif
    <x-_admin_form_alert />
    <form action="javascript:getToken(editSocket, '{{csrf_token()}}')" method="POST">
        @csrf
        <x-_admin_socket_form :socket='$socket'
          :listBrand='$list_brand'>
          <x-slot name="button_mid">
            <button type="reset" id="reset-button" class="btn btn-danger mb-3 col-12"
            {{$is_deletable ? '' : 'disabled'}} data-bs-toggle="modal" data-bs-target="#delete-modal"
            >Hapus</button>
          </x-slot>
          <x-slot name="button_right">
            <button type="submit" id="edit-button" class="btn btn-primary mb-3 col-12">Edit</button>
          </x-slot>
        </x-_admin_socket_form>
    </form>
</x-_content_container>
<script>
    const xhr = new XMLHttpRequest()

    function changeModalToSuccessOrFail(status = 200, text) {
        const modalLabel = document.getElementById('delete-modal-label')
        const modalBody = document.getElementById('delete-modal-body')
        const modalButtons = document.getElementsByClassName('delete-modal-btn')
        modalLabel.innerText = (status == 200 ? 'Socket terhapus' : 'Socket gagal terhapus')
        modalBody.innerText = (status == 200 ?
        'Socket telah terhapus dari database. Anda akan diarahkan ke halaman sebelumnya' :
        `Socket gagal terhapus dari database. Halaman ini akan refresh.\nPesan: ${JSON.parse(text).message}`)
        for(let i=0; i<modalButtons.length; i++)
            modalButtons[i].disabled = true
        setTimeout(() => {
            if (status == 200) window.open('/admin/daftar-socket', '_self')
            else location.reload()
        }, 5000)
    }

    xhr.onreadystatechange = () => {
        if (xhr.readyState == xhr.DONE) {
            changeModalToSuccessOrFail(xhr.status, xhr.response)
        }
    };
    
    function deleteSocket(token) {
        const id = (new URLSearchParams(window.location.search)).get('id')
        xhr.open("DELETE", "/api/admin/edit-socket", true)
        xhr.setRequestHeader("Content-Type", "application/json")
        xhr.setRequestHeader("Authorization", `Bearer ${token}`)
        xhr.send(JSON.stringify({id}))
    }

    function editSocket(token) {
      const id = (new URLSearchParams(window.location.search)).get('id')
      const nama = document.getElementById("nama").value;
      const idBrand = document.getElementById("brand").value;

      ajax.open("PATCH", "/api/admin/edit-socket", true);

      closeAlert();
      ajax.setRequestHeader("Content-Type", "application/json");
      ajax.setRequestHeader("Authorization", `Bearer ${token}`)
      ajax.send(JSON.stringify({ id, nama, idBrand }));
    }
</script>
@endsection