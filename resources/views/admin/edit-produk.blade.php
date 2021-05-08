@extends('layouts.app')

@section('main-content')
<x-_modal_two_buttons :id="'delete-modal'" :title="'Hapus produk?'"
    :prompt="'Yakin ingin menghapus '.$produk->nama.'? Tindakan ini tidak dapat dibatalkan setelah dieksekusi.'">
    <x-slot name="button_action">
        <button onclick="getToken(deleteProduk, '{{csrf_token()}}')" type="button" class="btn btn-danger delete-modal-btn">Hapus</button>
    </x-slot>
</x-_modal_two_buttons>
<x-_content_container :pageTitle="'Edit produk ('.$produk->nama.')'">
    <x-_admin_form_alert />
    <form action="javascript:getToken(editItem, '{{csrf_token()}}')" method="POST">
        <input type="text" name="id" id="id" style="height: 0; width: 0; visibility: hidden; position: fixed" value="{{$produk->id}}" readonly>
        <x-_admin_produk_form :listKategori='$list_kategori' :listBrand='$list_brand'
        :processorCategoryId='$prosesor_kategori_id' :motherboardCategoryId="$motherboard_kategori_id"
        :listSocket='$list_socket'
        :listSubkategori='$list_subkategori' :produk='$produk' :isThisProcessorOrMotherboard='$is_this_processor_or_motherboard'>
            <x-slot name="button_mid">
                <button type="button" class="btn btn-danger col-12"
                    data-bs-toggle="modal" data-bs-target="#delete-modal">
                    Hapus
                </button>
            </x-slot>
            <x-slot name="button_right">
                <button type="submit" id="tambah-button" class="btn btn-primary col-12">Edit produk</button>
            </x-slot>
        </x-_admin_produk_form>
    </form>
</x-_content_container>

<script>
    const kategoriSelect = document.getElementById("kategori")
    const subkategoriSelect = document.getElementById("subkategori")
    fetch(`/api/subkategori?id_kategori=${kategoriSelect.value}`)
        .then((res) => res.json())
        .then((subcategories) =>
            subcategories.forEach((subcategory) => {
                const option = document.createElement("option");
                option.text = subcategory.nama
                option.value = subcategory.id
                if(option.value == subkategoriSelect.dataset.selectedSub)
                    option.selected = true
                subkategoriSelect.add(option)
            })
        );

    const xhr = new XMLHttpRequest()

    function changeModalToSuccessOrFail(status = 200, text) {
        const modalLabel = document.getElementById('delete-modal-label')
        const modalBody = document.getElementById('delete-modal-body')
        const modalButtons = document.getElementsByClassName('delete-modal-btn')
        modalLabel.innerText = (status == 200 ? 'Produk terhapus' : 'Produk gagal terhapus')
        modalBody.innerText = (status == 200 ?
        'Produk telah terhapus dari database. Anda akan diarahkan ke halaman sebelumnya' :
        `Produk gagal terhapus dari database. Halaman ini akan refresh.\nPesan: ${JSON.parse(text).message}`)
        for(let i=0; i<modalButtons.length; i++)
            modalButtons[i].disabled = true
        setTimeout(() => {
            if (status == 200) window.open('/admin/daftar-produk', '_self')
            else location.reload()
        }, 5000)
    }

    xhr.onreadystatechange = () => {
        if (xhr.readyState == xhr.DONE) {
            changeModalToSuccessOrFail(xhr.status, xhr.response)
        }
    };
    
    function deleteProduk(token) {
        const id = document.getElementById("id").value
        xhr.open("DELETE", "/api/admin/edit-produk", true)
        xhr.setRequestHeader("Content-Type", "application/json")
        xhr.setRequestHeader("Authorization", `Bearer ${token}`)
        xhr.send(JSON.stringify({id}))
    }
</script>
@endsection