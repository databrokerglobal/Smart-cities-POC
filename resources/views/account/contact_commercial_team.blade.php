@extends('layouts.app')

@section('title', 'Contact us | Databroker ')
@section('description', "Want to know more about getting started with Databroker? Or about becoming a partner? Or maybe you want to share your feedback? We'd love to hear from you.")

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')    
 
<div class="container-fluid app-wapper bg-pattern-side">
    <div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
                <h1 class="text-primary text-center text-bold">{{trans('contact.get_in_touch_woth_commercial_team')}}</h1>
                
                @error('google_captcha')
                            <span class="invalid-feedback" style='text-align:center' role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                <br>
                <form method="POST" action="{{ route('contact.contact_commercial_send') }}" id="contactForm">
                    @csrf
                   
                    <label class="pure-material-textfield-outlined">
                       <input type="text" id="full_name" name="full_name" class="form-control input_data @error('full_name')  is-invalid @enderror" placeholder=" "  value="{{ old('full_name', isset($userData['full_name'])?$userData['full_name']:'') }}" autocomplete="full_name" autofocus>
                        <span>{{ trans('contact.full_name') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Full Name']) }}</div>
                        @error('full_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        
                        <input type="text" id="email" name="email" class="form-control input_data @error('email')  is-invalid @enderror" placeholder=" "  value="{{ old('email', isset($userData['email'])?$userData['email']:'' ) }}" autocomplete="email" autofocus>
                        <span>{{ trans('contact.email_address') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Email Address']) }}</div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                        
                        <input type="text" id="company" name="companyName" class="form-control input_data @error('companyName')  is-invalid @enderror" placeholder=" "  value="{{ old('companyName', isset($userData['companyName'])?$userData['companyName']:'' ) }}" autocomplete="company" autofocus>
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
                                        @elseif($userData!=null && $country->regionIdx == $userData['regionIdx'])
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

                    
                     <label class="pure-material-textfield-outlined">
                       <input type="number" id="contact_number" name="contact_number" class="form-control input_data @error('contact_number')  is-invalid @enderror" placeholder=" "  value="{{ old('contact_number', isset($userData['contact_number'])?$userData['contact_number']:'') }}" autocomplete="contact_number" autofocus>
                        <span>{{ trans('contact.contact_number') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Contact Number']) }}</div>
                        @error('contact_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label> 

                     <label class="pure-material-textfield-outlined">
                       <input type="text" id="amount_to_be_redeemed" name="amount_to_be_redeemed" class="form-control input_data @error('amount_to_be_redeemed')  is-invalid @enderror" placeholder=" "  value="{{ old('amount_to_be_redeemed', isset($userData['amount_to_be_redeemed'])?$userData['amount_to_be_redeemed']:'') }}" autocomplete="amount_to_be_redeemed" autofocus>
                        <span>{{ trans('contact.amount_to_be_redeemed') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Amount to be redeeed']) }}</div>
                        @error('amount_to_be_redeemed')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                     <label class="pure-material-textfield-outlined">
                       <input type="text" id="bank_account_number" name="bank_account_number" class="form-control input_data @error('bank_account_number')  is-invalid @enderror" placeholder=" "  value="{{ old('bank_account_number', isset($userData['bank_account_number'])?$userData['bank_account_number']:'') }}" autocomplete="bank_account_number" autofocus>
                        <span>{{ trans('contact.bank_account_number') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Bank Account Number']) }}</div>
                        @error('bank_account_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label> 

                    
                     <label class="pure-material-textfield-outlined">
                       <input type="text" id="iban_number" name="iban_number" class="form-control input_data @error('iban_number')  is-invalid @enderror" placeholder=" "  value="{{ old('iban_number', isset($userData['iban_number'])?$userData['iban_number']:'') }}" autocomplete="iban_number" autofocus>
                        <span>{{ trans('contact.iban_number') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'IBAN Number']) }}</div>
                        @error('iban_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    
                    <label class="pure-material-textfield-outlined">
                       <input type="text" id="bank_name" name="bank_name" class="form-control input_data @error('bank_name')  is-invalid @enderror" placeholder=" "  value="{{ old('bank_name', isset($userData['bank_name'])?$userData['bank_name']:'') }}" autocomplete="bank_name" autofocus>
                        <span>{{ trans('contact.bank_name') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Bank Name']) }}</div>
                        @error('bank_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    
                     <label class="pure-material-textfield-outlined">
                       <input type="text" id="branch_code" name="branch_code" class="form-control input_data @error('branch_code')  is-invalid @enderror" placeholder=" "  value="{{ old('branch_code', isset($userData['branch_code'])?$userData['branch_code']:'') }}" autocomplete="branch_code" autofocus>
                        <span>{{ trans('contact.branch_code') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Bank Branch Code']) }}</div>
                        @error('branch_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                       <input type="text" id="company_reg_no" name="company_reg_no" class="form-control input_data @error('company_reg_no')  is-invalid @enderror" placeholder=" "  value="{{ old('company_reg_no', isset($userData['company_reg_no'])?$userData['company_reg_no']:'') }}" autocomplete="company_reg_no" autofocus>
                        <span>{{ trans('contact.company_reg_no') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Company Registration Number']) }}</div>
                        @error('company_reg_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>

                    <label class="pure-material-textfield-outlined">
                       <input type="text" id="company_tax_no" name="company_tax_no" class="form-control input_data @error('company_tax_no')  is-invalid @enderror" placeholder=" "  value="{{ old('company_tax_no', isset($userData['company_tax_no'])?$userData['company_tax_no']:'') }}" autocomplete="company_tax_no" autofocus>
                        <span>{{ trans('contact.company_tax_no') }}</span>
                        <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Company Tax Identification Number']) }}</div>
                        @error('company_tax_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>
                 

                    <!-- captcha field  start -->
                    <div class='row' style='margin-left: 0.2%;'>
                        <label for="password"  style="padding-top: 2%;" class="col-md-12 control-label k fs-20 pl-0 text-black">
                            <span class='text-black text-bold'>Security Check: </span>{{$math_captcha}}
                        <div class="col-md-3 security-answer">                            
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Answer" name="captcha">
                            
                        </div>  
                        </label>
                        @if ($errors->has('captcha'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                            @endif
                    </div>
                    <input type="hidden" name="recaptcha" id="recaptcha">
                    <!-- captcha field  end -->
                    
                    
                    <div class="form-group row mb-0">                        
                        <div class="col-md-6">                                
                            <button type="submit" class="customize-btn">{{ trans('contact.send') }}</button>
                        </div>
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
      $(function(){
        $('.bmd-form-group').map(function(index, item){
          var child = $(item).find('.input_data');
          console.log(child);
          item = $(child); 
        })
      });

      
        grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function(token) {
                if (token) {
                    console.log(token);
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
 
    </script>
    
@endsection   