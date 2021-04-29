@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Edit kategori '.$kategori->nama">
    <x-_admin_form_alert />
    <form action="javascript:editKategori()" >
        @csrf
        <x-_admin_kategori_form :kategori='$kategori' />
    </form>
</x-_content_container>
@endsection