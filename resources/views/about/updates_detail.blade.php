@extends('layouts.app')

@section('title')
{{ $update->meta_title }}
@stop
@section('description')
{{ $update->meta_desc }}
@stop

@section('additional_css')
        <link rel="stylesheet" href="{{ asset('css/imageuploadify.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('databroker/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('databroker/css/v4-shims.css') }}">
        <link rel="stylesheet" href="{{ asset('databroker/css/contact.css') }}">
@endsection

@section('content')
<div id="background-image-mobile"></div>
<div class="container-fluid app-wapper">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section app-reveal-section align-items-center usecases detail">
            <div class="article-body">
                <div class="blog-header row">  
                    <a href="javascript:history.go(-1)" class="back-icon text-grey"><i class="material-icons">keyboard_backspace</i><span>Back to Updates</span></a>              
                    <div class="col-md-12">
                        <h1 class="h1-small">{{$update->articleTitle}}</h1>
                        <h4 class="color-green"><b>- By&nbsp;{{ $update->author }}&nbsp;|&nbsp;{{ date_format($update->published,"F d, Y") }}</b></h4>
                    </div>                
                </div>  
                <br>
                <div class="blog-content cms-content">
                    <div class="row">
                            <div class="col-md-12 col-sm-12">
                                    <div class="card card-profile card-plain">                  
                                        <div class="card-header holder" id="detail-cms-image">        
                                            <img class="img" src="{{ asset('uploads/usecases/large/'.$update->image) }}"  id="news_detail_img"/>
                                        </div>
                                    </div>  
                            </div>  
                    </div>
                    <div class="row">                
                            <div class="col-md-12" id="updates-article-content-sec">
                                {!! $update->articleContent !!}
                            </div>                
                    </div> 
                    <a href="javascript:history.go(-1)" class="back-icon text-grey"><i class="material-icons">keyboard_backspace</i><span>Back to Updates</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid app-wapper" id="update-detail-mobile-spliter">
    <div id="sub-footer" class="sub-footer mgh30">
        <!-- <div class="section_splitor_gray"></div> -->
        <div class="bg-pattern1-both flex-center flex-vertical">
            <div class="divider-green mgb30"></div>
            <div class="h2">Find out about new updates</div>
            <div class="para mgb40">Sign up for our NewsBytes!</div>
            <a href="{{route('register_nl')}}"><button type="button" class="customize-btn button mgt15">SIGN UP</button></a>
        </div>
        <!-- <div class="section_splitor_gray h713"></div> -->
    </div> 
</div>  
<div class="container-fluid app-wapper">
    <div class="container">
        <div class="app-section app-reveal-section align-items-center usecases">
            <div id="usecase-list2" class="mgh30">
            <h1 class="fs-18"><b>More updates to discover</b></h1>
                <div class="row">
                    @foreach ( $updates2 as $update )
                    <div class="col-md-4">
                        <a href="{{ route('about.news_detail',  ['title' => $update->slug]) }}">
                            <div class="card card-profile card-plain">                  
                                <div class="card-header holder" id="resposive-card-header">        
                                    <img class="img" src="{{ asset('uploads/usecases/tiny/'.$update->image) }}" id="responsive-card-img"/>
                                </div>
                                <div class="card-body text-left">
                                    <div class="para-small">
                                        <span class="color-green"><b>- By&nbsp;{{ $update->author }}&nbsp;|&nbsp;{{ date_format($update->published,"F d, Y") }}</b></span>
                                    </div>
                                    <h4 class="offer-title card-title">{{ $update->articleTitle }}</h4>
                                </div>
                            </div>  
                        </a>
                    </div>  
                    @endforeach         
                </div>
            </div>
            <div class="flex-center">
                <a href="{{ route('about.news') }}"><button type="button" class="button blue-outline w225">LOAD MORE</button></a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/imageuploadify.min.js') }}"></script>        
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>    
@endsection

