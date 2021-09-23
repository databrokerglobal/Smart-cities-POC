@extends('auth.auth_app')

@section('content')
<div class="container-fluid app-wapper app-wapper-register bg-pattern-side">
    <div class="container">
        <div class="row justify-content-center auth-section">
            <div class="col-md-8" id="register_section">
                <h1 class="h1-smaller text-primary text-center" id="register_title">Get started with {{env("APP_NAME")}}</h1>
                <br>
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    <label class="pure-material-textfield-outlined">
                        <input type="text" id="firstname" name="firstname" class="form-control input_data @error('firstname')  is-invalid @enderror" placeholder=" "  value="{{ old('firstname') }}" autocomplete="firstname" autofocus>
                        <span>{{ trans('auth.first_name') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'First Name']) }}</div>
                        @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        <input type="text" id="lastname" name="lastname" class="form-control input_data @error('lastname')  is-invalid @enderror" placeholder=" "  value="{{ old('lastname') }}" autocomplete="lastname" autofocus>
                        <span>{{ trans('auth.last_name') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Last Name']) }}</div>
                        @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        @if($email!='')
                        <input type="text" id="email" name="email" class="form-control input_data @error('email')  is-invalid @enderror" placeholder=" " value="{{$email}}" readonly autocomplete="email" autofocus>
                        @else
                        <input type="text" id="email" name="email" class="form-control input_data @error('email')  is-invalid @enderror" placeholder=" " value="{{ old('email') }}" autocomplete="email" autofocus>
                        @endif
                        <span>{{ trans('auth.email_address') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Email Address']) }}</div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        @if($business!='')
                        <input type="text" id="company" name="companyName" class="form-control input_data @error('companyName')  is-invalid @enderror" placeholder=" "  value="{{ $business }}" readonly autocomplete="company" autofocus>
                        @else
                        <input type="text" id="company" name="companyName" class="form-control input_data @error('companyName')  is-invalid @enderror" placeholder=" "  value="{{ old('companyName') }}" autocomplete="company" autofocus>
                        @endif
                        <span>{{ trans('auth.company') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Company']) }}</div>
                        @error('companyName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <div class="industry-dropdown dropdown-container">
                        <div class="dropdown" tabindex="1">
                            <div class="select">
                                @if(old('businessName2'))
                                <span class="chosen">{{ old('businessName2') }}</span>
                                @else
                                <span>Which industry are you in?</span>
                                @endif
                            </div>
                            <input type="hidden" id="businessName2" name="businessName2" value="Agriculture/Mining/Forestry">
                            <ul class="dropdown-menu" style="display: none;">
                                <li value="Agriculture/Mining/Forestry">Agriculture/Mining/Forestry</li>
                                <li value="Advertising/Media/Publishing">Advertising/Media/Publishing</li>
                                <li value="Automotive">Automotive</li>
                                <li value="Construction/Engineering/Infrstructure">Construction/Engineering/Infrstructure</li>
                                <li value="Chemicals">Chemicals</li>
                                <li value="Creative">Creative</li>
                                <li value="Education">Education</li>
                                <li value="Energy/Utilities">Energy/Utilities</li>
                                <li value="Financial services &amp; insurance">Financial services &amp; insurance</li>
                                <li value="Government/Non-profit">Government/Non-profit</li>
                                <li value="Healthcare">Healthcare</li>
                                <li value="Hospitality/Tourism">Hospitality/Tourism</li>
                                <li value="IT services">IT services</li>
                                <li value="Manufacturing">Manufacturing</li>
                                <li value="Pharmaceutical/Biotech">Pharmaceutical/Biotech</li>
                                <li value="Retail/Consumer goods">Retail/Consumer goods</li>
                                <li value="Telecommunications/Electronics">Telecommunications/Electronics</li>
                                <li value="Transportation/Logistics">Transportation/Logistics</li>
                                <li value="">Other industry</li>
                            </ul>
                        </div>
                        <div class="error_notice"> This field is required</div>
                    </div>

                    <label class="other-industry pure-material-textfield-outlined" style="display: none">
                        <input type="text" id="businessName" name="businessName" class="form-control input_data @error('businessName')  is-invalid @enderror" placeholder=" "  value="{{ old('businessName') }}" autocomplete="businessName" autofocus>
                        <span>{{ trans('auth.enter_your_industry') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Last Name']) }}</div>
                        @error('businessName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <div class="role-dropdown dropdown-container">
                        <div class="dropdown" tabindex="1">
                            <div class="select">
                                @if(old('jobTitle2'))
                                <span class="chosen">{{ old('jobTitle2') }}</span>
                                @else
                                <span>What role do you have?</span>
                                @endif
                            </div>
                            <input type="hidden" id="jobTitle2" name="jobTitle2" value="Technical">
                            <ul class="dropdown-menu" style="display: none;">
                                <li value="Business">Business</li>
                                <li value="Technical">Technical</li>
                                <li value="">Other</li>
                            </ul>
                        </div>
                        <div class="error_notice"> This field is required</div>
                    </div>

                    <label class="other-role pure-material-textfield-outlined" style="display: none">
                        <input type="text" id="jobTitle" name="jobTitle" class="form-control input_data @error('jobTitle')  is-invalid @enderror" placeholder=" "  value="{{ old('jobTitle') }}" autocomplete="jobTitle" autofocus>
                        <span>{{ trans('auth.enter_your_role') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Job title']) }}</div>
                        @error('jobTitle')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        <input type="password" id="password" name="password" class="form-control input_data @error('password') is-invalid @enderror" placeholder=" "  value="" autofocus>
                        <span>{{ trans('auth.password') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Password']) }}</div>
                        <span class="feedback @error('password') invalid-feedback @enderror" role="alert">
                            <strong>
                                @if($errors->has('password')) {{$errors->first('password')}}
                                @else
                                Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.
                                @endif
                            </strong>
                        </span>
                    </label>

                    <label class="pure-material-textfield-outlined">
                        <input type="password" id="password-confirm" name="password_confirmation" class="form-control input_data @error('password-confirm')  is-invalid @enderror" placeholder=" "  value="" autofocus>
                        <span>{{ trans('auth.confirm_password') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Confirm Password']) }}</div>
                        @error('password-confirm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <div class="form-check">
                        <label class="form-check-label">                
                            <input type="checkbox" class="form-check-input" name="term_conditions" value="true">
                            <p class="text-black fs-18 lh-27">Yes, I accept {{APPLICATION_NAME}}’s <a href="{{ route('about.terms_conditions') }}" target="_blank"><font style="color: #78E6D0;">terms and conditions</font></a> and <a href="{{ route('about.privacy_policy') }}" target="_blank"><font style="color: #78E6D0;">the privacy policy</font></a></p>
                            <span class="form-check-sign">
                                <span class="custom-check check @error('term_conditions') is-invalid @enderror"></span>
                            </span>                                                      
                        </label>  
                        @error('term_conditions')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror                                                  
                    </div> 
                    <br>                       
                    
                    <div class="register-actions form-group mb-0">
                        <button type="submit" class="customize-btn">CREATE ACCOUNT</button>
                        @if (Route::has('login'))
                            <a class="text-grey" id="login_link" href="{{ route('login') }}">
                                {{ __('Already have an account?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection