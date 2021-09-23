@extends('layouts.app')

@section('title', 'No Access | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
    <div class="container">
        <div class="row justify-content-center mt-50 auth-section">
            <div class="col-md-8">
                <div class="success-msg">
                   
                    <h1 class="text-primary text-center text-bold">{{trans('data.no_access_page')}}</h1>
                    <p class="para text-bold text-center fs-20">{{trans('data.no_access_page')}}</p>
                    <p class="text-center">
                        <a href="{{route('home')}}">
                            <button type="button" class="customize-btn">{{trans('data.go_to_home')}}</button>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>                        
@endsection