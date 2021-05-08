@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Tambah subkategori'">
    <x-_admin_form_alert />
    <form action="javascript:getToken(tambahSubkategori, '{{csrf_token()}}')" method="POST">
        @csrf
        <x-_admin_subkategori_form :subkategori='null'
          :listKategori='$list_kategori'>
          <x-slot name="middle_button">
            <button type="reset" id="reset-button" class="btn btn-warning mb-3 col-12">Reset</button>
          </x-slot>
          <x-slot name="right_button">
            <button type="submit" id="tambah-button" class="btn btn-primary mb-3 col-12">Tambahkan</button>
          </x-slot>
        </x-_admin_subkategori_form>
    </form>
</x-_content_container>
@endsection