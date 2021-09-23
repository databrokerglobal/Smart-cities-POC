@extends('auth.auth_app')

@section('title', 'Sign up for our NewsBytes | Databroker ')
@section('description', 'Get the latest Databroker updates, announcements, use cases, and more, delivered straight to your inbox. Sign up for our NewsBytes!')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper bg-pattern-side">
    <div class="container">
        <div class="row justify-content-center auth-section">
            <div class="col-md-8" id="register_nl_section">
                <h1 class="text-primary text-center text-bold">Sign up for NewsBytes!</h1>
                <h2 class="text-primary text-center text-bold">The latest updates delivered straight to your inbox!</h2>
                <p class="para">Our NewsBytes email brings you a whole host of inspiring content – updates about the {{APPLICATION_NAME}} marketplace, company announcements, use cases from our data communities, news from the world of data, and more!</p>
                <br>
               <!--  <form method="POST" action="{{ route('create_nl') }}">
                    @csrf
                    
                    <label class="pure-material-textfield-outlined">
                        <input type="text" id="firstname" name="firstname" class="form-control input_data @error('firstname') is-invalid @enderror" placeholder=" "  value="{{ old('firstname') }}" autocomplete="firstname" autofocus>
                        <span>{{ trans('contact.first_name') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'First Name']) }}</div>
                        @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        <input type="text" id="lastname" name="lastname" class="form-control input_data @error('lastname') is-invalid @enderror" placeholder=" "  value="{{ old('lastname') }}" autocomplete="lastname" autofocus>
                        <span>{{ trans('contact.last_name') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Last Name']) }}</div>
                        @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        <input type="text" id="email" name="email" class="form-control input_data @error('email') is-invalid @enderror" placeholder=" "  value="{{ old('email') }}" autocomplete="email" autofocus>
                        <span>{{ trans('contact.email_address') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Email Address']) }}</div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        <input type="text" id="company" name="companyName" class="form-control input_data @error('companyName') is-invalid @enderror" placeholder=" "  value="{{ old('companyName') }}" autocomplete="company" autofocus>
                        <span>{{ trans('contact.company') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Company']) }}</div>
                        @error('companyName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <div class="dropdown-container">
                        <div class="dropdown2 region_list" tabindex="1">                                
                            <div class="adv-combo-wrapper">
                                <select id="regionIdx" class="@error('regionIdx') is-invalid @enderror" name="regionIdx" placeholder="Country">
                                    <option></option>
                                    @foreach ($countries as $country)
                                        @if( $country->regionIdx == old('regionIdx') )
                                        <option value="{{$country->regionIdx}}" selected>{{ $country->regionName }}</option>
                                        @else
                                        <option value="{{$country->regionIdx}}">{{ $country->regionName }}</option>
                                        @endif
                                    @endforeach
                                 </select>
                                 @error('regionIdx')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>                              
                        </div>
                    </div>  

                    <div class="dropdown-container">
                        <div class="dropdown2 business_list" tabindex="1">                                
                            <div class="adv-combo-wrapper">
                                <select id="businessName2" class="@error('businessName2') is-invalid @enderror" name="businessName2" placeholder="Which industry are you in?">
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
                        <input type="text" id="businessName" name="businessName" class="form-control input_data @error('businessName') is-invalid @enderror" placeholder=" " value="{{ old('businessName') }}" autocomplete="businessName" autofocus>
                        <span>{{ trans('auth.enter_your_industry') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Other industry']) }}</div>
                        @error('businessName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <div class="dropdown-container">
                        <div class="dropdown2 role_list" tabindex="1">                                
                            <div class="adv-combo-wrapper">
                                <select id="role2" name="role2" class="@error('role2') is-invalid @enderror" placeholder="What kind of role do you have?">
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
                        <input type="text" id="role" name="role" class="form-control input_data @error('role') is-invalid @enderror" placeholder=" "  value="{{ old('role') }}" autocomplete="role" autofocus>
                        <span>{{ trans('auth.enter_your_role') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Role']) }}</div>
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <p class="text-bold fs-20">We’d love to know a little more about your interests.<br/>Which data communities are most relevant for you?</p>
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
                        <div class="col-md-6">                                
                            <button type="submit" class="customize-btn">Sign Up</button>
                        </div>
                    </div>

                </form> -->
                <!--[if lte IE 8]>
                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
                <![endif]-->
                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
                <script>
                hbspt.forms.create({
                    region: "na1",
                    portalId: "8639589",
                    formId: "1fe4f897-d825-43a1-83ff-dde485ec56d8"
                });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
@endsection