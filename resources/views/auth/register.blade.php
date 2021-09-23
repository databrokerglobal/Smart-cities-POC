@extends('auth.auth_app')

@section('title', 'Register on '.env("APP_NAME").' | '. env("APP_NAME") )
@section('description', 'Join the biggest community of data buyers and sellers worldwide. Register now to list data you want to sell or share, or to find the data you need.')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper app-wapper-register bg-pattern-side" ng-app="signupApp" ng-cloak ng-controller="signupCtrl as ctrl">
    <div class="container">
        <div class="row justify-content-center auth-section">
            <div class="col-md-8" id="register_section">
                <h1 class="h1-smaller text-primary text-center" id="register_title">Get started with {{env("APP_NAME")}}</h1>
                <br>
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="companyIdx" value="{{$company?$company->companyIdx:0}}">
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
                        @if($company)
                        <input type="text" id="company" name="companyName" class="form-control input_data @error('companyName')  is-invalid @enderror" placeholder=" "  value="{{ $company->companyName }}" readonly autocomplete="company" autofocus>
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
                    <div class="dropdown-container">
                        <div class="dropdown2 business_list" tabindex="1">                                
                            <div class="adv-combo-wrapper">
                                <select id="businessName2" name="businessName2" class="@error('businessName2') is-invalid @enderror" placeholder="Which industry are you in?">
                                    <option></option>
                                @foreach ($businesses as $business)
                                    @if(old('businessName2')==$business->businessName)
                                    <option value="{{$business->businessName}}" selected>{{ $business->businessName }}</option>
                                    @else
                                    <option value="{{$business->businessName}}">{{ $business->businessName }}</option>
                                    @endif
                                @endforeach
                                 </select>
                                @error('businessName2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                              
                        </div>
                    </div>    

                    <label class="other-industry pure-material-textfield-outlined" style="display: none">
                        <input type="text" id="businessName" name="businessName" class="form-control input_data @error('businessName')  is-invalid @enderror" placeholder=" " value="{{ old('businessName') }}" autocomplete="businessName" autofocus>
                        <span>{{ trans('auth.enter_your_industry') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Industry']) }}</div>
                        @error('businessName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <div class="dropdown-container">
                        <div class="dropdown2 role_list" tabindex="1">                                
                            <div class="adv-combo-wrapper">
                                <select id="role2" name="role2" class="@error('role2') is-invalid @enderror" placeholder="What role do you have?">
                                    <option></option>
                                    @if(old('role2')=='Business')
                                    <option value="Business" selected>Business</option>
                                    @else
                                    <option value="Business">Business</option>
                                    @endif
                                    @if(old('role2')=='Technical')
                                    <option value="Technical" selected>Technical</option>
                                    @else
                                    <option value="Technical">Technical</option>
                                    @endif
                                    @if(old('role2')=='Other')
                                    <option value="Other" selected>Other</option>
                                    @else
                                    <option value="Other">Other</option>
                                    @endif
                                 </select>
                                @error('role2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                              
                        </div>
                    </div>    

                    <label class="other-role pure-material-textfield-outlined" style="display: none">
                        <input type="text" id="role" name="role" class="form-control input_data @error('role')  is-invalid @enderror" placeholder=" "  value="{{ old('role') }}" autocomplete="role" autofocus>
                        <span>{{ trans('auth.enter_your_role') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Role']) }}</div>
                        @error('role')
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
                                Your password must contain at least <span class="has8letters">8 characters</span>, including <span class="hasupperletter">1 uppercase letter</span> and <span class="hasdigit">1 digit</span>.
                            </strong>
                        </span>
                    </label>

                    <label class="pure-material-textfield-outlined">
                        <input type="password" id="password-confirm" name="password_confirmation" class="form-control input_data @error('password_confirmation')  is-invalid @enderror" placeholder=" "  value="" autofocus>
                        <span>{{ trans('auth.confirm_password') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Confirm Password']) }}</div>
                        <span class="feedback @error('password_confirmation') invalid-feedback @enderror" role="alert">
                            <strong>
                                @if($errors->has('password_confirmation')) {{$errors->first('password_confirmation')}} 
                                @endif
                            </strong>
                        </span>
                    </label>

                    <!-- captcha field  start -->                    
                    <div class='row' style='margin-left: 0.1%;'>
                        <label for="password"  style="padding-top: 2%;" class="col-md-12 control-label k fs-20 pl-0 text-black">
                        <span class='text-black text-bold'>Security Check: </span>{{$math_captcha}}
                        <div class="col-md-3 security-answer">                           
                                <input id="captcha" type="text" class="form-control" placeholder="Enter Answer" name="captcha">                               
                        </div>
                        @if ($errors->has('captcha'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
                         @if ($errors->has('recaptcha'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
                        </label>
                    </div>
                    <input type="hidden" name="recaptcha" id="recaptcha">
                   
                    <!-- captcha field  end -->
                    <br><br>   
                    
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
@section('additional_javascript')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script type="text/javascript">
        $("input[name='password']").on("keyup", function(e){
            var has8letters = false;
            var hasupperletter = false;
            var hasdigit = false;
            var text = $(this).val();
            if(text.length >= 8) has8letters = true;
            else has8letters = false;
            if(text.length!=0){
                for(var i=0; i<text.length; i++){
                    if(text[i]>='A' && text[i]<='Z')
                        hasupperletter = true;
                    if(text[i]>='0' && text[i]<='9')
                        hasdigit = true;
                }
            }
            if(has8letters) $(this).siblings('.feedback').find('.has8letters').addClass('passed');
            else $(this).siblings('.feedback').find('.has8letters').removeClass('passed');
            if(hasupperletter) $(this).siblings('.feedback').find('.hasupperletter').addClass('passed');
            else $(this).siblings('.feedback').find('.hasupperletter').removeClass('passed');
            if(hasdigit) $(this).siblings('.feedback').find('.hasdigit').addClass('passed');
            else $(this).siblings('.feedback').find('.hasdigit').removeClass('passed');
            if(has8letters && hasupperletter && hasdigit) $(this).siblings('.feedback').addClass('text-green');
            else $(this).siblings('.feedback').removeClass('text-green');
        });
        $("input[name='password_confirmation']").on("keyup", function(e){
            var password = $("input[name='password']").val();
            var confirm = $(this).val();
            console.log(password.indexOf(confirm));
            if(confirm == password) {
                $(this).siblings('.feedback').html("<strong class='text-green'>Passwords match.</strong>");
            }else if(password.indexOf(confirm)){
                $(this).siblings('.feedback').html("<strong class='text-red'>Passwords do not match.</strong>");
            }else{
                $(this).siblings('.feedback').html("<strong class='text-red'></strong>");
            }
        });
        grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
    </script>
    
@endsection