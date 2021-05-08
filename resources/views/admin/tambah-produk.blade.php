@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Tambah produk'">
    <x-_admin_form_alert />
    <form action="javascript:getToken(tambahItem, '{{csrf_token()}}')" method="POST">
        <x-_admin_produk_form :listKategori='$list_kategori' :listBrand='$list_brand'
        :processorCategoryId='$prosesor_kategori_id' :motherboardCategoryId="$motherboard_kategori_id"
        :listSocket='$list_socket' :produk='null' :isThisProcessorOrMotherboard='false'>
        <x-slot name="button_mid">
            <button type="reset" id="reset-button" class="btn btn-warning mb-3 col-12">Reset</button>
        </x-slot>
        <x-slot name="button_right">
            <button type="submit" id="tambah-button" class="btn btn-primary mb-3 col-12">Tambahkan</button>
        </x-slot>
    </x-_admin_produk_form>
    </form>
</x-_content_container>
@endsection