@extends('layouts.app')

@section('title', trans('about.usecases_overview_meta_title'))
@section('description', trans('about.usecases_overview_meta_desc'))

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
                    <h1 class="h1-small">Get inspired by real-life use cases for data</h1>
                    <p class="fs-18">Looking for inspiration for how data can help supercharge your business? Browse our use cases to discover practical and innovative ways that data can solve real-life challenges, lead to better decision-making and drive more strategic business moves.</p>
                </div>                
            </div>          
            <div class="blog-content">
                <div class="row">
                    <div class="col-lg-6 flex-vcenter mgh30 col-sm-12" id="usecase-whole">
                        <h4 class="h4_intro">Explore use cases in</h4>                  
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
                        @foreach ($usecases as $usecase)
                        <div class="col-md-4">
                            <a href="{{ route('about.usecase_detail',  ['title' => $usecase->slug])}}">
                                <div class="card card-profile card-plain">                  
                                    <div class="card-header holder" id="resposive-card-header">        
                                        <img class="img" src="{{ asset('uploads/usecases/tiny/'.$usecase->image) }}" id="responsive-card-img" />
                                    </div>
                                    <div class="card-body text-left">
                                        <div class="para-small">
                                            <span class="color-green"><b>{{ $usecase->community->communityName }}</b></span>
                                        </div>
                                        <h4 class="offer-title card-title">{{ $usecase->articleTitle }}</h4>
                                    </div>
                                </div>  
                            </a>
                        </div>  
                        @endforeach         
                    </div>
                </div>
                <div class="flex-center" id="remove-row">
                    @if(isset($usecases[14]))
                        <button type="button" class="button blue-outline w225" id="btn-more" data-id="{{ $usecases[14]->published }}">LOAD MORE</button>
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
            <div class="h2">Find out about new use cases</div>
            <div class="para mgb40">Sign up for our NewsBytes!</div>
            <a href="{{route('register_nl')}}"><button type="button" class="customize-btn button mgt15">SIGN UP</button></a>
        </div>
        <!-- <div class="section_splitor_gray h713"></div> -->
    </div>  
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/imageuploadify.min.js') }}"></script>        
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>   
    <script src="{{ asset('js/usecases_loadmore.js') }}"></script>          
@endsection

