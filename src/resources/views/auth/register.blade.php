@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Daftar'">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-right">Nama</label>
            <input id="name" placeholder="Nama" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        </div>

        <div class="form-group mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail :</label>
            <input id="email" placeholder="E-mail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        </div>

        <div class="form-group mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password :</label>
            <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        </div>

        <div class="form-group mb-3">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password :</label>
            <input id="password-confirm" placeholder="Ulangi password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="row mb-3">
            <h6>Sudah punya akun? <a href="{{route('login')}}">Login sekarang</a></h6>
        </div>

        <div class="row">
            <div class="col-12 mb-5">
                <button class="btn btn-primary col-12" type="submit" class="btn btn-primary">
                    Register
                </button>
            </div>
        </div>
    </form>
</x-_content_container>
@endsection
