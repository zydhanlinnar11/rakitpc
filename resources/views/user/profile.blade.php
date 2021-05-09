@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Profil dari '.$user['name']">
    <section id="informasi-umum" class="mb-3">
        <h6>Informasi umum:</h6>
        <p>Nama : {{$user['name']}}</p>
        <p>E-mail : {{$user['email']}}</p>
        <p>No. telepon : {{isset($user['no_telp']) ? $user['no_telp'] : '-'}}</p>
        <p>Saldo : Rp {{number_format($user['saldo'], 2)}}</p>
    </section>
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{route('user.transaksi.all')}}" class="btn btn-secondary col-12">Riwayat transaksi</a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <a class="btn btn-primary col-12" href="{{route('user.edit-profile')}}">Edit profil</a>
        </div>
    </div>
</x-_content_container>
@endsection