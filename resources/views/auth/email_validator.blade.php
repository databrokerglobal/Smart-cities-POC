@extends('auth.auth_app')

@section('title', 'Email Validate | Databroker')
@section('description', 'Sign in to your account to enjoy all the features of the Databroker marketplace. Don’t have an account yet? Then register now to buy or sell data. It’s free.')

@section('content')
<div class="container-fluid app-wapper">
    <div class="container">
        <div class="row justify-content-center auth-section">
            <div class="col-xl-6 col-lg-6 col-md-10" id="login_section">
                <h2 class="h1-smaller color-primary text-center text-primary" id="login_title">Please verify your email </h2>
                <p class="text-center  mb-50">Please enter the OTP which is shared to your email. </p>
                <form method="POST" action="{{ route('validate_otp') }}" onsubmit="return validate()">
                    @csrf

                    <label class="pure-material-textfield-outlined">
                        <input type='hidden' id='userIds' value="{{$userData->userIdx}}" >
                        <input type='hidden' id='enteredOtp' value="{{$userData->otp}}" >
                        <input type="text" id="otp" name="email" class="form-control input_data " placeholder=""  value="{{ old('email') }}" autocomplete="email" autofocus>
                        <span>Enter OTP</span>
                        <div class="error_notice"> This field is required</div>
                        @error('otp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <div class="form-group row mb-0">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button type="submit" class="customize-btn">verify</button>
                        </div>
                        <div class="col-md-6 text-right flex-column align-items-end justify-content-center">
                          
                        </div>
                    </div>

                    <hr>
                    <p class="h4-intro">Don’t have an account yet?</p>
                    <p class="paragraph-small text-bold">Then let’s get you set up!</p>
                    <div class="row mb-0 flex-row align-items-center">
                        <div class="col-md-6">
                            <a id="register_link" href="{{ route('register') }}">
                                <button type="button" class="secondary-btn w225 pure-material-button-outlined">{{ __('REGISTER NOW') }}</button>
                            </a>
                            <label class="ml-30">It’s free!</label>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function validate(){
        console.log('in validate function');
        return false;
    }
</script>