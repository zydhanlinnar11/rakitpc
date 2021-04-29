@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Edit produk ('.$produk->nama.')'">
    <x-_admin_form_alert />
    <form action="javascript:editItem()" method="POST">
        <input type="text" name="id" id="id" style="height: 0; width: 0; visibility: hidden; position: fixed" value="{{$produk->id}}">
        <x-_admin_produk_form :listKategori='$list_kategori' :listBrand='$list_brand'
        :processorCategoryId='$prosesor_kategori_id' :motherboardCategoryId="$motherboard_kategori_id"
        :listSocket='$list_socket'
        :listSubkategori='$list_subkategori' :produk='$produk' :isThisProcessorOrMotherboard='$is_this_processor_or_motherboard'>
            <x-slot name="button_mid">
                <button type="button" class="btn btn-danger col-12">Hapus produk</button>
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
</script>
@endsection