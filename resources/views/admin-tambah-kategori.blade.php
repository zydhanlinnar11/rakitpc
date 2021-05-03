@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Tambah kategori'">
    <x-_admin_form_alert />
    <form action="javascript:tambahKategori()" method="POST">
        @csrf
        <x-_admin_kategori_form :kategori='null'>
            <x-slot name="button_mid">
                <button type="reset" id="reset-button" class="btn btn-warning col-12 mb-3">Reset</button>
            </x-slot>
            <x-slot name="button_right">
                <button type="submit" id="tambah-button" class="btn btn-primary col-12 mb-3">Tambah</button>
            </x-slot>
        </x-_admin_kategori_form>
    </form>
</x-_content_container>
@endsection