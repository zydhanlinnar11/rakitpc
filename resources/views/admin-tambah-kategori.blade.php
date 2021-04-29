@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Tambah kategori'">
    <x-_admin_form_alert />
    <form action="javascript:tambahKategori()" method="POST">
        @csrf
        <x-_admin_kategori_form :kategori='null' />
    </form>
</x-_content_container>
@endsection