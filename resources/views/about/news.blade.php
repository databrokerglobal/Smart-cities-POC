@extends('layouts.app')

@section('title', 'Databroker news | Databroker')
@section('description', 'Read about the latest Databroker developments, news, events and products. Sign up for our NewsBytes to get the latest updates straight in your inbox!')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/imageuploadify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div id="background-image-mobile"></div>
<div class="container-fluid app-wapper">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section app-reveal-section align-items-center usecases">
            <div class="blog-header row">                
                <div class="col-md-8">
                    <h1 class="h1-small">{{env("APP_NAME")}} news</h1>
                </div>                
            </div>          
            <div class="blog-content">
                <div class="row">
                    <div class="col-lg-6 flex-vcenter mgh30 col-sm-12" id="usecase-whole">
                        <h4 class="h4_intro">Explore news in</h4>                  
                            <div class="mgl30 adv-combo-wrapper custom-select2 geocommunity-wrapper">
                                <select name="geocommunity" id="geocommunity" class="no-search">
                                    <option value="all">All Communities</option>
                                    @foreach ( $communities as $community )
                                    <option value="{{$community->communityIdx}}">{{ $community->communityName }} Community</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>                    
                </div>
                <div id="usecase-list" class="mgh30">
                    <div class="row" id="load-data">
                        @if($updates)
                            @foreach ( $updates as $update )
                            <div class="col-md-4">
                                <a href="{{ route('about.news_detail',  ['title' => $update->slug] ) }}">
                                    <div class="card card-profile card-plain">                  
                                        <div class="card-header holder" id="resposive-card-header">        
                                            <img class="img" src="{{ asset('uploads/usecases/tiny/'.$update->image) }}" id="responsive-card-img"/>
                                        </div>
                                        <div class="card-body text-left">
                                            <div class="para-small">
                                                <!-- <span class="color-green"><b>- By&nbsp;{{ $update->author }}&nbsp;|&nbsp;{{ date_format($update->published,"F d, Y") }}</b></span> -->
                                                <span class="color-green"><b>{{$update->category ??""}}</b></span>
                                            </div>
                                            <h4 class="offer-title card-title">{{ $update->articleTitle }}</h4>
                                        </div>
                                    </div>  
                                </a>
                            </div>  
                            @endforeach         
                        @endif
                    </div>
                </div>
                <div class="flex-center" id="remove-row">
                    @if(isset($updates[14]))
                    <button type="button" class="button blue-outline w225" id="btn-more" data-id="{{ $updates[14]->published }}">LOAD MORE</button>
                    @endif
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
            <div class="h2">Sign up for our NewsBytes!</div>
            <div class="para mgb40">The latest updates delivered straight to your inbox!</div>
            <a href="{{route('register_nl')}}"><button type="button" class="customize-btn button mgt15">SIGN UP</button></a>
        </div>
        <!-- <div class="section_splitor_gray h713"></div> -->
    </div> 
</div>  

@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/imageuploadify.min.js') }}"></script>        
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>   
    <script src="{{ asset('js/updates_loadmore.js') }}"></script>     
@endsection

