@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Login'">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail :</label>
            <input id="email" placeholder="E-mail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>

        <div class="form-group mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password :</label>
            <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </div>

        <div class="form-group mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                Ingat saya
            </label>
        </div>
        
        <div class="row mb-3">
            <h6>Belum punya akun? <a href="{{route('register')}}">Daftar sekarang</a></h6>
        </div>

        <div class="row">
            <div class="col-12 mb-5">
                <button class="btn btn-primary col-12" type="submit" class="btn btn-primary">
                    Login
                </button>
            </div>
        </div>
    </form>
</x-_content_container>
@endsection
