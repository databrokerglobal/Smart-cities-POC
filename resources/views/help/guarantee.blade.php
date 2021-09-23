@extends('layouts.app')

@section('title', 'Buy and sell with confidence | Databroker ')
@section('description', 'We want data buyers and sellers to have the best possible experience on Databroker. Find out how we ensure peace of mind for everyone.')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/imageuploadify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section app-reveal-section align-items-center usecases">
            <div class="blog-header mgt60">
                <div class="row">
                    <div class="col-lg-9 col-sm-12">
                        <h1>Buy and sell with confidence</h1>
                        <p class="para">Databroker is a unique marketplace that brings together buyers and sellers of data from all industries and sectors, and from all over the world. Through our platform, we want to make sure that our community of users has the best possible experience.</p>
                        <p class="fs-18">An important part of this is ensuring peace of mind, so you can buy and sell with confidence.</p>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="pull-right">
                            <p class="h3 text-right">Questions?</p>
                            <a href="{{ route('contact') }}"><button class="customize-btn">CONTACT US</button></a>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="blog-content">
                <div class="row">
                    <div class="col-lg-4 flex-vcenter mgh30">
                        <!-- <h4 class="h4_intro">FOR BUYERS: 30-day warranty</h4> -->
                    </div>
                </div>
                @if(count($topics) > 0)
                <div id="usecase-list" class="mgh30">
                    @foreach($topics as $topic)
                    <div class="row">                
                        <div class="col-md-12">
                            <h2 class="text-bold fs-30 lh-1">{{$topic->title}}</h2>
                            <p class="fs-18">{!! $topic->description !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>  
    </div>  
    <div id="sub-footer" class="sub-footer mgh30">
        <div class="section_splitor_gray"></div>
        <div class="bg-pattern1-both flex-center flex-vertical">
            <div class="divider-green mgb30"></div> 
            <div class="h1-small">Discover how Databroker works</div> 
            <br/>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                <a href="{{route('help.buying_data')}}"><button type="button" class="customize-btn button mgt15">How to buy data</button></a>
                </div>
                <div class="col-md-6 col-sm-12">
                <a href="{{route('help.selling_data')}}"><button type="button" class="customize-btn button mgt15">How to sell data</button></a>
                </div>
            </div>
        </div>
        <div class="section_splitor_gray h713"></div>
    </div>    
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/imageuploadify.min.js') }}"></script>        
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>        
@endsection

