@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Tambah brand'">
    <x-_admin_form_alert />
    <form action="javascript:tambahBrand()" method="POST">
        @csrf
        <x-_admin_brand_form :brand='null' />
    </form>
</x-_content_container>
@endsection