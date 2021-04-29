@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Couldn\'t connect to the database.'">
    <div class="row">
        <i class="fas fa-ban fa-5x text-center mb-3 mt-3"></i>
        <p class="text-center mb-4"><strong>Please refresh the page.</strong></p>
    </div>
</x-_content_container>
@endsection