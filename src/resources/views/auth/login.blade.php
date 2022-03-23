@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Login'">
    <div class="row">
        <div class="col-12 mb-5">
            <a href="{{route('login')}}" class="btn btn-secondary col-12">
                Login with Google
            </a>
        </div>
    </div>
</x-_content_container>
@endsection
