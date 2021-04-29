@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Tambah subkategori'">
    <x-_admin_form_alert />
    <form action="javascript:tambahSubkategori()" method="POST">
        @csrf
        <x-_admin_subkategori_form :subkategori='null'
          :listKategori='$list_kategori' />
    </form>
</x-_content_container>
@endsection