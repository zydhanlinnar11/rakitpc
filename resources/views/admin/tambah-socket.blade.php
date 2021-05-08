@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Tambah socket'">
    <x-_admin_form_alert />
    <form action="javascript:getToken(tambahSocket, '{{csrf_token()}}')" method="POST">
        @csrf
        <x-_admin_socket_form :socket='null'
          :listBrand='$list_brand'>
          <x-slot name="button_mid">
            <button type="reset" id="reset-button" class="btn btn-warning mb-3 col-12">Reset</button>
          </x-slot>
          <x-slot name="button_right">
            <button type="submit" id="tambah-button" class="btn btn-primary mb-3 col-12">Tambahkan</button>
          </x-slot>
        </x-_admin_socket_form>
    </form>
</x-_content_container>
@endsection