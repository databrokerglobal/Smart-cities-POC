@extends('auth.auth_app')

@section('title', 'Sign up for our NewsBytes | Databroker')
@section('description', "Get the latest Databroker updates, announcements, use cases, and more, delivered straight to your inbox. Sign up for our NewsBytes!")

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper bg-pattern-side">
    <div class="container">
        <div class="row justify-content-center auth-section">
            <div class="col-md-8" id="register_nl_section">
                <h1 class="text-primary text-center text-bold">Want to stay up-to-date on the latest {{APPLICATION_NAME}} news?</h1>
                <h2 class="text-primary text-center text-bold">Now’s a good time to sign up for our NewsBytes!</h2>
                <p class="para">Our NewsBytes email brings you a whole host of inspiring content – updates about the {{APPLICATION_NAME}} marketplace, company announcements, use cases from our data communities, news from the world of data, and more!</p>
                <br>
                <form method="POST" action="{{ route('create_nl') }}">
                    @csrf
                    <input type="hidden" name="userIdx" value="{{$userData->userIdx}}">
                    <input type="hidden" name="firstname" value="{{$userData->firstname}}">
                    <input type="hidden" name="lastname" value="{{$userData->lastname}}">
                    <input type="hidden" name="email" value="{{$userData->email}}">
                    <input type="hidden" name="companyName" value="{{$userData->companyName}}">
                    <input type="hidden" name="regionIdx" value="{{$userData->regionIdx}}">
                    <input type="hidden" name="businessName" value="{{$userData->businessName}}">
                    <input type="hidden" name="role" value="{{$userData->role}}">

                    <p class="text-bold fs-20">
                        We’d love to know a little more about your interests.<br/>
                        Which data communities are most relevant for you?
                    </p>
                    <div class="row mt-30">
                        @foreach ($communities as $community)
                        <div class="col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="community[]" value="{{$community['communityIdx']}}">
                                    <p class="text-black">{{$community['communityName']}}</p>
                                    <span class="form-check-sign">
                                        <span class="custom-check check"></span>
                                    </span>                                                        
                                </label>
                            </div>                             
                        </div>    
                        @endforeach
                        @error('community')
                            <span class="invalid-feedback pl-15" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>    
                    <br>      
                    <p class="para">
                        We’re committed to your privacy. Your details are collected and stored so we can provide you with information about our marketplace and other relevant content. You can unsubscribe or update your details at any time via a link in the emails you’ll receive. By clicking the button below, you consent to us storing and processing the details entered above, and to receiving our updates.
                    </p>                 
                    
                    <div class="form-group row mb-0">                        
                        <div class="col-md-12 flex-row justify-content-between align-items-center">                                
                            <button type="submit" class="customize-btn">Sign Up</button>
                            <a class="text-grey" href="{{ $next_url }}">
                                {{ trans("pages.not_right_now") }}
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
@endsection