@extends('layouts.app')

@section('title', 'Databroker partner network | Databroker')
@section('description', 'Together with our network of trusted partners, we share the vision of turning data into real business value, for both buyers and sellers. Discover our partners.')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/imageuploadify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper partners">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section app-reveal-section align-items-center">
            <div class="blog-header">
                <h1>{{env("APP_NAME")}} partner network</h1>
                <div class="row">
                    <div class="col-lg-6 para">We are proud to work with a global network of trusted partners. Together we share the vision of transforming data into real business value, for both data buyers and sellers.</div>
                    <div class="col-lg-6 flex-end">
                        <div class="h4_intro text-right mgh30">Interested in teaming up with {{env("APP_NAME")}}?</div>
                        <a href="{{route('contact')}}"><button class="button customize-btn pull-right">LET’S CONNECT</button></a>
                    </div>
                </div>
            </div>  
         </div>  
    </div>  
    
    <div class="container">
        @foreach($partners as $key=>$partnersVal)
        <div class="app-section align-items-center">
            <h3 class="text-bold">{{PARTNER_TYPE[$key]}}</h3>
        </div>
        <div id="partner-list-{{$key}}" class="">
            <div class="row">
             @foreach ( $partnersVal as $partner )
             @if($partner['url']!="")        
                            <a href="{{$partner['url']}}" target="_blank" class="col-lg-2 partner-cell-wrapper flex-vfill pd15">
                                <div class="partner-cell pl-25 pr-25 flex-vfill @if($partner['logo']=='') partner-cell-empty @endif">
                                    <div class="partner-logo" style="background-image: url('{{asset('uploads/partners/'.$partner['logo'])}}');"></div>
                                </div>
                            </a>
                            @else
                            <div class="col-lg-2 partner-cell-wrapper flex-vfill pd15">
                                <div class="partner-cell pl-25 pr-25 flex-vfill @if($partner['logo']=='') partner-cell-empty @endif">
                                    <div class="partner-logo" style="background-image: url('{{asset('uploads/partners/'.$partner['logo'])}}');"></div>
                                </div>
                            </div>
                            @endif
            @endforeach
                
            </div>
        </div>
        <div class="divider-green mgt30"></div>
        @endforeach
    </div>
     <!-- <div id="sub-footer2" class="sub-footer mgt60 container-fluid">
        <div class="section_splitor_gray"></div>
        <div class="bg-pattern1-both blog-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 pd15 blog-cell-wrapper">
                        <div class="blog-cell pd40 flex-center flex-vertical">
                            <div class="double-quote mgb25"></div>
                            <div class="h4_intro text-center">"Here comes a quote of a dataprovider, illustrating the value. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet."</div>
                            <div class="h4_intro color-gray4 mg40">Name, role, company</div>
                        </div>
                    </div>
                    <div class="col-lg-6 pd15 blog-cell-wrapper">
                        <div class="blog-cell pd40 flex-center flex-vertical">
                            <div class="double-quote mgb25"></div>
                            <div class="h4_intro text-center">"Here comes a quote of a dataprovider, illustrating the value. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet."</div>
                            <div class="h4_intro color-gray4 mg40">Name, role, company</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div> -->
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/imageuploadify.min.js') }}"></script>        
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>        
@endsection

