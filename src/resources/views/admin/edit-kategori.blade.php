@extends('layouts.app')

@section('main-content')
<x-_modal_two_buttons :id="'delete-modal'" :title="'Hapus kategori?'"
    :prompt="'Yakin ingin menghapus '.$kategori->nama.'? Tindakan ini tidak dapat dibatalkan setelah dieksekusi.'">
    <x-slot name="button_action">
        <button onclick="getToken(deleteKategori, '{{csrf_token()}}')" type="button" class="btn btn-danger delete-modal-btn">Hapus</button>
    </x-slot>
</x-_modal_two_buttons>
<x-_content_container :pageTitle="'Edit kategori '.$kategori->nama">
    @if (!$is_deletable)
    <div class="alert alert-info" role="alert">
        Kategori tidak dapat dihapus karena ada item yang termasuk kategori ini!
    </div>   
    @endif
    @if ($is_any_subkategori_here)
    <div class="alert alert-info" role="alert">
        Kategori tidak dapat dihapus karena ada subkategori yang termasuk kategori ini!
    </div>   
    @endif
    <x-_admin_form_alert />
    <form action="javascript:getToken(editKategori, '{{csrf_token()}}')" >
        @csrf
        <input type="text" name="id" id="id" style="height: 0; width: 0; visibility: hidden; position: fixed" value="{{$kategori->id}}" readonly>
        <x-_admin_kategori_form :kategori='$kategori'>
            <x-slot name="button_mid">
                <button type="button" class="btn btn-danger col-12 mb-3"
                    data-bs-toggle="modal" data-bs-target="#delete-modal" {{$is_deletable && !$is_any_subkategori_here ? '' : 'disabled'}}>
                    Hapus
                </button>
            </x-slot>
            <x-slot name="button_right">
                <button type="submit" id="tambah-button" class="btn btn-primary col-12 mb-3">Ubah</button>
            </x-slot>
        </x-_admin_kategori_form>
    </form>
</x-_content_container>

<script>
    const xhr = new XMLHttpRequest()

    function changeModalToSuccessOrFail(status = 200, text) {
        const modalLabel = document.getElementById('delete-modal-label')
        const modalBody = document.getElementById('delete-modal-body')
        const modalButtons = document.getElementsByClassName('delete-modal-btn')
        modalLabel.innerText = (status == 200 ? 'Kategori terhapus' : 'Kategori gagal terhapus')
        modalBody.innerText = (status == 200 ?
        'Kategori telah terhapus dari database. Anda akan diarahkan ke halaman sebelumnya' :
        `Kategori gagal terhapus dari database. Halaman ini akan refresh.\nPesan: ${JSON.parse(text).message}`)
        for(let i=0; i<modalButtons.length; i++)
            modalButtons[i].disabled = true
        setTimeout(() => {
            if (status == 200) window.open('/admin/daftar-kategori', '_self')
            else location.reload()
        }, 5000)
    }

    xhr.onreadystatechange = () => {
        if (xhr.readyState == xhr.DONE) {
            changeModalToSuccessOrFail(xhr.status, xhr.response)
        }
    };
    
    function deleteKategori(token) {
        const id = document.getElementById("id").value
        xhr.open("DELETE", "/api/admin/edit-kategori", true)
        xhr.setRequestHeader("Content-Type", "application/json")
        xhr.setRequestHeader("Authorization", `Bearer ${token}`)
        xhr.send(JSON.stringify({id}))
    }
</script>
@endsection