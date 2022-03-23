@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="$title">
    @if ($item_count == 0)
    <x-tidak_ada_apapun />
    @else
    <div class="row">
        @foreach ($list_item as $key)
            <x-_list_item_card :key="$key">
                <x-slot name="button1">
                    <a href="/item?item_id={{$key->id}}" class="btn btn-primary">Lihat</a>
                </x-slot>
            </x-_list_item_card>
        @endforeach
    </div>
    @endif
</x-_content_container>
@endsection