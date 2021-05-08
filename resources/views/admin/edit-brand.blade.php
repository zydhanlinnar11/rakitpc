@extends('layouts.app')

@section('main-content')
<x-_modal_two_buttons :id="'delete-modal'" :title="'Hapus brand?'"
    :prompt="'Yakin ingin menghapus '.$brand->nama.'? Tindakan ini tidak dapat dibatalkan setelah dieksekusi.'">
    <x-slot name="button_action">
        <button onclick="deleteBrand()" type="button" class="btn btn-danger delete-modal-btn">Hapus</button>
    </x-slot>
</x-_modal_two_buttons>
<x-_content_container :pageTitle="'Edit brand '.$brand->nama">
    @if (!$is_deletable)
    <div class="alert alert-info" role="alert">
        Brand tidak dapat dihapus karena ada item yang termasuk brand ini!
    </div>   
    @endif
    <x-_admin_form_alert />
    <form action="javascript:editBrand()">
        @csrf
        <x-_admin_brand_form :brand='$brand'>
            <x-slot name="middle_button">
                <button type="button" id="hapus-button" class="btn btn-danger mb-3 col-12"
                data-bs-toggle="modal" data-bs-target="#delete-modal"
                {{($is_deletable ? '' : 'disabled')}}>Hapus</button>
            </x-slot>
            <x-slot name="right_button">
                <button type="submit" id="tambah-button" class="btn btn-primary mb-3 col-12">Edit</button>
            </x-slot>
        </x-_admin_brand_form>
    </form>

<script>
    const xhr = new XMLHttpRequest()

    function changeModalToSuccessOrFail(status = 200, text) {
        const modalLabel = document.getElementById('delete-modal-label')
        const modalBody = document.getElementById('delete-modal-body')
        const modalButtons = document.getElementsByClassName('delete-modal-btn')
        modalLabel.innerText = (status == 200 ? 'Brand terhapus' : 'Brand gagal terhapus')
        modalBody.innerText = (status == 200 ?
        'Brand telah terhapus dari database. Anda akan diarahkan ke halaman sebelumnya' :
        `Brand gagal terhapus dari database. Halaman ini akan refresh.\nPesan: ${JSON.parse(text).message}`)
        for(let i=0; i<modalButtons.length; i++)
            modalButtons[i].disabled = true
        setTimeout(() => {
            if (status == 200) window.open('/admin/daftar-brand', '_self')
            else location.reload()
        }, 5000)
    }

    xhr.onreadystatechange = () => {
        if (xhr.readyState == xhr.DONE) {
            changeModalToSuccessOrFail(xhr.status, xhr.response)
        }
    };
    
    function deleteBrand() {
        const id = (new URLSearchParams(window.location.search)).get('id')
        xhr.open("DELETE", "/api/admin/edit-brand", true)
        xhr.setRequestHeader("Content-Type", "application/json")
        xhr.send(JSON.stringify({id}))
    }

    function editBrand() {
        const id = (new URLSearchParams(window.location.search)).get('id')
        const nama = document.getElementById("nama").value;
        const deskripsi = document.getElementById("deskripsi").value;
        const urlLogo = document.getElementById("url_logo").value;

        ajax.open("PATCH", "/api/admin/edit-brand", true);

        closeAlert();
        ajax.setRequestHeader("Content-Type", "application/json");
        ajax.send(JSON.stringify({ id, nama, deskripsi, urlLogo }));
    }
</script>
</x-_content_container>
@endsection