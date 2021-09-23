@extends('layouts.data')

@section('title', 'Publishing a data offer | Enter company info | Databroker')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/imageuploadify.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
	<!-- <link rel="stylesheet" href="{{ asset('bower_components/select2/select2.css') }}"> -->
@endsection

@section('content')
<div class="container-fluid app-wapper data-offer">
	<div class="bg-pattern1-left"></div>
    <div class="container">
    	<form method="post" action="{{ route('save_data_offer_provider') }}">
    		@csrf    		
            <div class="app-section app-reveal-section align-items-center">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="blog-header">
                            <h1>Before we get started</h1>
                            @if($user->userStatus==1)
                            <p class="area">Please tell us a little more about your company.<br>
                            This information will be published in the marketplace along with your data offer.</p>
                            @else
                            <p class="area">Please check the below information about your company.</p>
                            @endif
                        </div>
                        <div class="blog-content">
                            <label class="pure-material-textfield">Which country are you located in?</label>
                            <div class="adv-combo-wrapper custom-select2">
                                @if($user->userStatus==1)
                                <select id="regionIdx" name="regionIdx" class="@error('regionIdx') is-invalid @enderror" placeholder="{{ trans('pages.search_by_country') }}">
                                @else                                
                                <input type="hidden" name="regionIdx" value="{{$company->regionIdx}}">
                                <select id="regionIdx" name="regionIdx" class="" placeholder="{{ trans('pages.search_by_country') }}" disabled>
                                @endif
                                    <option></option>
                                    @foreach ($countries as $country)
                                        @if($country->regionIdx == $company->regionIdx)
                                        <option value="{{$country->regionIdx}}" selected>{{ $country->regionName }}</option>
                                        @else
                                        <option value="{{$country->regionIdx}}">{{ $country->regionName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback regionIdx">
                                    <strong>@error('regionIdx') {{$message}} @enderror</strong>
                                </div>
                            </div>
                            <label class="pure-material-textfield">The name of your company</label>
                            <label class="pure-material-textfield-outlined">
                                <input type="hidden" name="companyIdx" value="{{$company?$company->companyIdx:0}}">
                                <input type="text" id="companyName" name="companyName" class="form-control input_data" placeholder=" "  value="{{old('companyName', $company->companyName)}}" readonly>
                                <span>{{ trans('pages.company_name') }}</span>
                                <div class="invalid-feedback companyName">
                                    <strong></strong>
                                </div>
                            </label>
                            <label class="pure-material-textfield">{{ trans('pages.what_company_url') }}</label>
                            <label class="pure-material-textfield-outlined">
                                @if($user->userStatus==1)
                                <input type="text" id="companyURL" name="companyURL" class="form-control input_data @error('companyURL') is-invalid @enderror" placeholder=" "  value="{{old('companyURL', $company->companyURL)}}">
                                @else
                                <input type="text" id="companyURL" name="companyURL" class="form-control input_data" placeholder=" "  value="{{old('companyURL', $company->companyURL)}}" readonly>
                                @endif
                                <span>{{ trans('pages.enter_url') }}</span>
                                <div class="invalid-feedback companyURL">
                                    <strong>@error('companyURL') {{$message}} @enderror</strong>
                                </div>
                            </label>
                            <label class="pure-material-textfield">{{ trans('pages.company_vat') }}</label>
                            <label class="pure-material-textfield-outlined">
                                @if($user->userStatus==1)
                                <input type="text" id="companyVAT" name="companyVAT" class="form-control input_data @error('companyVAT') is-invalid @enderror" placeholder=" "  value="{{old('companyVAT', $company->companyVAT)}}">
                                @else
                                <input type="text" id="companyVAT" name="companyVAT" class="form-control input_data" placeholder=" "  value="{{old('companyVAT', $company->companyVAT)}}" readonly>
                                @endif
                                <span>{{ trans('pages.company_vat') }}</span>
                                <div class="invalid-feedback companyVAT">
                                    <strong>@error('companyVAT') {{$message}} @enderror</strong>
                                </div>
                            </label>
                            @if($company->companyLogo)
                            <label class="pure-material-textfield">Company logo</label>              
                            <div class="companylogo">
                                <input type="hidden" name="companyLogo" value="{{$company->companyLogo}}">
                                <inptu type="hidden" name="providerCompanyLogo" value="{{$company->companyLogo}}">
                                <img class="w-100" src="{{ asset('/uploads/company/'.$company->companyLogo) }}">
                            </div>
                            @elseif($user->userStatus==1)
                            <label class="pure-material-textfield mt-20">Please upload your company's logo <i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.company_logo_tooltip') }}">help</i></label>
                            <div class="fileupload data-offer">
                                <input type="file" id="companyLogo" class="companyLogo" name="companyLogo" accept='image/*'>
                                <div class="invalid-feedback companyLogo">
                                    <strong>@error('companyLogo') {{$message}} @enderror</strong>
                                </div>
                            </div>    
                            @endif
                            <div class="mt-20">
                                <p class="para text-secondary mb-0">We need all your company details to create a Data Offer</p>
                                @if($user->userStatus!=1)   
                                <p class="para text-secondary mb-0">If you need to add or change these details, please contact your administrator</p>
                                @endif
                            </div>
                            <div class="buttons text-right">
                                @if($user->userStatus==1)
                                <button type="submit" class="customize-btn btn-next pull-right">{{ trans('pages.next') }}</button>
                                @elseif($company->regionIdx==255 || $company->companyURL==null || $company->companyVAT==null || $company->companyLogo==null)
                                <button type="submit" class="customize-btn btn-next pull-right btn-disabled" disabled>{{ trans('pages.next') }}</button>
                                @else
                                <button type="submit" class="customize-btn btn-next pull-right">{{ trans('pages.next') }}</button>
                                @endif
                            </div>
                        </div>  
                    </div>
                </div>   
            </div>     
        </form>
    </div>
</div>
@endsection
@section('additional_javascript')
    <script src="{{ asset('js/plugins/imageuploadify.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
@endsection