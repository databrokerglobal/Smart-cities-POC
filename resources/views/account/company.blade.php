@extends('layouts.app')

@section('title', 'Company profile | Databroker ')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/imageuploadify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper profile">
    <div class="bg-pattern1-left"></div>
	<div class="app-section app-reveal-section align-items-center">	    
		<div class="container">
            @if($user->userStatus==1)
			<div class="page-title text-primary">{{ trans('pages.update_company_profile') }}</div>
            @else
            <div class="page-title text-primary">{{ trans('pages.company_profile') }}</div>
            @endif
			<div class="label companyname">
				<span>{{ trans('pages.company_profile_desc') }}</span>
			</div>			

            <!-- <div class="row">
                        <div class="col-10 info-label">&nbsp;</div>
                        <div class="col-2 info-text "><u><a href="#">Test Wyre Payment</a></u></div>
             </div> -->


            <div class="app-section profileinfo">
                <div id="company-profile-display-section">
                    @if($user->userStatus==1)
                    <div id="edit-button" class="action-button-edit top-right flex-center" onClick="document.getElementById('company-profile-edit-section').style.display = 'block';document.getElementById('company-profile-display-section').style.display = 'none';">
                        <i class="material-icons">edit</i> {{ trans('pages.edit') }}
                        
                    </div>  
                    @endif                   
                    <div class="row">
                        <div class="col-2 info-label">Company:</div>
                        <div class="col info-text">{{ $company->companyName?$company->companyName:"" }} </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-2 info-label">Location:</div>
                        <div class="col info-text">{{ $company->region?$company->region->regionName:"" }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2 info-label">URL:</div>
                        <div class="col info-text">
                        @php
                            $companyurl = $company->companyURL;
                            $p=parse_url($companyurl);
                        @endphp
                        <a target="_blank" class="text-green"  href="{{ $company->companyURL }}" rel="nofollow">{{ $company->companyURL?$company->companyURL:"" }}</a></div>
                    </div>
                    <div class="row">
                        <div class="col-2 info-label">VAT number:</div>
                        <div class="col info-text">{{ $company->companyVAT?$company->companyVAT:"" }}</div>
                    </div>
                    <div class="row">                            
                        <div class="col companylogo">                            
                            @if( file_exists( public_path() . '/uploads/company/medium/'.$company->companyLogo) && $company->companyLogo )
                            <img src="{{ asset('/uploads/company/medium/'.$company->companyLogo) }}">
                            @else
                            <img class="img" src="{{ asset('/uploads/company/default.png') }}" />
                            @endif
                        </div>
                    </div>
                </div><!--profile-display-section-->

                <div id="company-profile-edit-section" style="display: none;" >
                    <div id="cancel-button" class="top-right flex-center" onClick="document.getElementById('company-profile-edit-section').style.display = 'none';document.getElementById('company-profile-display-section').style.display = 'block';">
                       <i class="material-icons">close</i> Cancel
                    </div>
                    <br />
                    <form method="POST" action="{{ route('account.company.update') }}">
                        @csrf
                        <input type="hidden" id="companyIdx" name="companyIdx" value="{{ $company->companyIdx }}">
                        <input type="hidden" name="old_companyLogo" value="{{ $company->companyLogo }}">
                        <label class="pure-material-textfield-outlined">
                            <input type="text" id="companyName" name="companyName" class="form-control input_data" placeholder=" " value="{{ old('companyName', $company->companyName) }}" autocomplete="company" autofocus>
                            <span>{{ trans('auth.company') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Company name']) }}</div>
                            <span class="invalid-feedback companyName" role="alert">
                                <strong></strong>
                            </span>
                        </label>
                        <div class="dropdown-container">
                            <div class="dropdown2 business_list" tabindex="1">                                
                                <div class="adv-combo-wrapper">
                                    <select id="regionIdx" name="regionIdx" placeholder="{{trans('pages.search_by_country')}}">
                                        <option></option>
                                        @foreach ($countries as $country)
                                            @if( $country->regionIdx == $company->regionIdx )
                                            <option value="{{$country->regionIdx}}" selected>{{ $country->regionName }}</option>
                                            @else
                                            <option value="{{$country->regionIdx}}">{{ $country->regionName }}</option>
                                            @endif
                                        @endforeach
                                     </select>
                                     <span class="invalid-feedback regionIdx" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>                              
                            </div>
                        </div>    
                        <label class="pure-material-textfield-outlined">
                            <input type="text" id="companyURL" name="companyURL" class="form-control input_data" placeholder=" "  value="{{ old('companyURL', $company->companyURL) }}" autocomplete="company" autofocus>
                            <span>{{ trans('pages.url') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Company URL']) }}</div>
                            <span class="invalid-feedback companyURL" role="alert">
                                <strong></strong>
                            </span>
                        </label>    
                        <label class="pure-material-textfield-outlined">
                            <input type="text" id="companyVAT" name="companyVAT" class="form-control input_data" placeholder=" "  value="{{ old('companyVAT', $company->companyVAT) }}" autocomplete="company" autofocus>
                            <span>{{ trans('pages.company_vat') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Company VAT']) }}</div>
                            <span class="invalid-feedback companyVAT" role="alert">
                                <strong></strong>
                            </span>
                        </label>        
                        <div class="fileupload data-offer">                            
                            <input type="file" id="companyLogo" name="companyLogo" accept='image/jpg,image/png,image/svg,image/jpeg'>
                            <span class="invalid-feedback companyLogo">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col info-text flex-vend">
                                <button type="submit" class="customize-btn">UPDATE COMPANY</button>
                            </div>
                        </div>
                    </form>
                </div><!--profile-edit-section-->
			</div>
		</div>
	</div>
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/imageuploadify.min.js') }}"></script>        
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>        
@endsection