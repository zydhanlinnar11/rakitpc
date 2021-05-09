@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Transaksi sukses ('.$transaksi['id_transaksi'].')'">
    <div class="text-center">
        <i style="color: green" class="fa fa-check-circle fa-7x mb-3"></i>
        <h6 class="mb-3">Transaksi sukses, anda akan segera diarahkan ke halaman transaksi.</h6>
        <h6>ID Transaksi: {{$transaksi['id_transaksi']}}</h6>
        <a href="{{route('user.transaksi.view')}}?id={{$transaksi['id_transaksi']}}" class="btn btn-success mb-3">Langsung ke laman transaksi</a>
    </div>
</x-_content_container>

<script>
    setTimeout(() => window.open(`{{route('user.transaksi.view')}}?id={{$transaksi['id_transaksi']}}`, '_self')
    , 5000)
</script>
@endsection