@extends('layouts.app')

@section('title', $topic->meta_title)
@section('description', $topic->meta_description)

@section('content')
<div class="container-fluid app-wapper help buying-data">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section align-items-center">
            <div class="blog-header mgt60">
                <h1>{{ $topic->title }}</h1>
            </div>  
            <div class="blog-content">
                {!! $topic->description !!}
            </div>
        </div>  
    </div>
</div>

@endsection

