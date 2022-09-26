@extends('layouts.image')

@section('page_title')
    Show image
@endsection

@section('content')
    <img src="{{ $url }}">
    <div class="pr-3 my-5 pl-2 text-sm opacity-75 text-gray-30">{{ $imageupload->views }} views</div>
@endsection
