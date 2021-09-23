@extends('layouts.app')

@section('title', 'Share your feedback with us | Databroker ')
@section('description', 'Your opinion is important to us, and we’d love to hear your feedback on what we’re doing well and what we could do better.')

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
                        <h1>How can we make Databroker even better?</h1>
                        <p class="para">We’re always striving to improve our marketplace, and we love to hear your feedback on what we’re doing well and what we could do better.</p>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="pull-right">
                            <p class="h3 text-right"></p>
                            <br/>
                            <br/>
                            <!-- <a href="{{ route('contact') }}"><button class="customize-btn">GIVE FEEDBACK</button></a> -->
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
                <div id="usecase-list" class="mgh30">
                @if(count($topics) > 0)
                    @foreach($topics as $topic)
                    <div class="row">                
                        <div class="col-md-12">
                            <h2 class="text-bold fs-30 lh-1">{{$topic->title}}</h2>
                            <p class="fs-18">{!! $topic->description !!}</p>
                        </div>                
                    </div> 
                    @endforeach
                @endif
                    <div class="row">                
                        <div class="col-md-12">
                            <br/>
                            <br/>
                            <a href="{{ route('contact') }}"><button class="customize-btn">GIVE FEEDBACK</button></a>
                        </div>                
                    </div>  
                </div>
            </div>
        </div>  
    </div>  
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/imageuploadify.min.js') }}"></script>        
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>        
@endsection

