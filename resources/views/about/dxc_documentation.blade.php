@extends('layouts.app')

@section('title', $dxc_doc->title.' |  '.env("APP_NAME") )
@section('description', $dxc_doc->sub_title)

@section('content')
<div id="background-image-mobile"></div>
<div class="container-fluid app-wapper about">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section align-items-center">
            <div class="blog-header mgt60">
                <h1>{{$dxc_doc->title}}</h1>
                <div class="para">{{$dxc_doc->sub_title}}</div>
            </div>  
            <div class="divider-green mgt30"></div>
            {!!$dxc_doc->description!!}
        </div>  
    </div>
</div>

<div class="sub-footer container-fluid app-wapper" id="about-page-mobile">
    <div class="container">
        <div class="flex-vertical flex-vcenter">
            <div class="divider-green"></div>
            <div class="h2 mgt30">Don't miss any updates!</div>
            <div class="">Sign up to our newsletter</div>
            <a href="{{route('register_nl')}}"><button class="button customize-btn mgt60">SIGN UP</button></a>
        </div>
    </div>
</div>   

@endsection

