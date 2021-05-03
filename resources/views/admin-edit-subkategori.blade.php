@extends('layouts.app')

@section('main-content')
<x-_modal_two_buttons :id="'delete-modal'" :title="'Hapus subkategori?'"
    :prompt="'Yakin ingin menghapus '.$subkategori->nama.'? Tindakan ini tidak dapat dibatalkan setelah dieksekusi.'">
    <x-slot name="button_action">
        <button onclick="deleteSubkategori()" type="button" class="btn btn-danger delete-modal-btn">Hapus</button>
    </x-slot>
</x-_modal_two_buttons>
<x-_content_container :pageTitle="'Edit subkategori '.$subkategori->nama">
    @if (!$is_deletable)
    <div class="alert alert-info" role="alert">
        Subkategori tidak dapat dihapus karena ada item yang termasuk subkategori ini!
    </div>   
    @endif
    <x-_admin_form_alert />
    <form action="javascript:editSubkategori()" >
        @csrf
        <x-_admin_subkategori_form :subkategori='$subkategori'
            :listKategori='$list_kategori'>
          <x-slot name="middle_button">
            <button type="button" id="delete-button" class="btn btn-danger mb-3 col-12"
            {{($is_deletable ? '' : 'disabled')}} data-bs-toggle="modal" data-bs-target="#delete-modal"
            >Hapus</button>
          </x-slot>
          <x-slot name="right_button">
            <button type="submit" id="edit-button" class="btn btn-primary mb-3 col-12">Edit</button>
          </x-slot>
        </x-_admin_subkategori_form>
    </form>
</x-_content_container>

<script>
    const xhr = new XMLHttpRequest()

    function changeModalToSuccessOrFail(status = 200, text) {
        const modalLabel = document.getElementById('delete-modal-label')
        const modalBody = document.getElementById('delete-modal-body')
        const modalButtons = document.getElementsByClassName('delete-modal-btn')
        modalLabel.innerText = (status == 200 ? 'Subkategori terhapus' : 'Subkategori gagal terhapus')
        modalBody.innerText = (status == 200 ?
        'Subkategori telah terhapus dari database. Anda akan diarahkan ke halaman sebelumnya' :
        `Subkategori gagal terhapus dari database. Halaman ini akan refresh.\nPesan: ${JSON.parse(text).message}`)
        for(let i=0; i<modalButtons.length; i++)
            modalButtons[i].disabled = true
        setTimeout(() => {
            if (status == 200) window.open('/admin/daftar-subkategori', '_self')
            else location.reload()
        }, 5000)
    }

    xhr.onreadystatechange = () => {
        if (xhr.readyState == xhr.DONE) {
            changeModalToSuccessOrFail(xhr.status, xhr.response)
        }
    };
    
    function deleteSubkategori() {
        const id = (new URLSearchParams(window.location.search)).get('id')
        xhr.open("DELETE", "/api/admin/edit-subkategori", true)
        xhr.setRequestHeader("Content-Type", "application/json")
        xhr.send(JSON.stringify({id}))
    }

    function editSubkategori() {
        const id = (new URLSearchParams(window.location.search)).get('id')
        const nama = document.getElementById("nama").value;
        const idKategori = document.getElementById("kategori").value;
        const deskripsi = document.getElementById("deskripsi").value;

        ajax.open("PATCH", "/api/admin/edit-subkategori", true);

        closeAlert();
        ajax.setRequestHeader("Content-Type", "application/json");
        ajax.send(JSON.stringify({ id, nama, idKategori, deskripsi }));
    }
</script>
@endsection