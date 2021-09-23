@extends('layouts.data')

@section('title', 'Get data product | Databroker ')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper data-offer">
	<div class="bg-pattern1-left"></div>
    <div class="container">
    	<form method="post" action="{{ route('account.take_access_free_data', ['id'=>$product->offerIdx, 'pid'=>$product->productIdx]) }}">
    		@csrf
			<input type='hidden' id='free_access_token' name='free_access_token' value="{{$free_access_token}}">
	    	<div class="app-section app-reveal-section align-items-center">
	    		<div class="row blog-header">
		    		<div class="col col-9">
						<h1>Please review the data you're about to get</h1>
						<p class="para text-bold">You are getting data from {{$product->companyName}}</p>
					</div>
				</div>
				<div class="app-monetize-section-item0 ml-0 mt-20"></div>
				<div class="blog-content">
					<div class="row">
						<div class="col-6">
							<div class="row">
								<div class="col-md-12">
									<p class="fs-24 para text-bold mb-0">{{$product->productTitle}}</p>
									<p class="para fs-16">
										@foreach($product->region as $key=>$region)
	            							<span>{{ $region->regionName }}</span>
	            							@if(count($product->region) > $key+1)
	            							<span>, </span>
	            							@endif
	            						@endforeach
	            					</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<p class="para text-red">FREE</p>
									<p class="para">
						        		<span class="text-grey">{{ trans('data.access_to_this_data') }}: </span>
						        		<span>1 hour</span>
						        	</p>
						        	<p class="para">
						        		<span class="text-grey">{{ trans('data.format') }}: </span>
						        		<span>{{$product->productType}}</span>
						        	</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-check">
		                                <label class="form-check-label w-100">
		                                    <input type="checkbox" class="form-check-input" name="termcondition_privacypolicy" @if(old('termcondition_privacypolicy')=='on') checked @endif>
		                                    <p class="text-black fs-16 lh-24">{!! trans('data.accept_termsconditions_privacypolicy', ['url1'=>route('about.terms_conditions'), 'url2'=>route('about.privacy_policy')]) !!}</p>
		                                    <span class="form-check-sign">
		                                        <span class="custom-check check"></span>
		                                    </span>
	                        				<div class="error_notice termcondition_privacypolicy">Please confirm that you accept Databroker’s Terms and conditions and Privacy policy.</div>
	                        				@error('termcondition_privacypolicy')
	                        				<div class="invalid-feedback">
	                        					<strong>{{$message}}</strong>
	                        				</div>
	                        				@enderror
		                                </label>
		                            </div>
		                            <div class="form-check">
		                                <label class="form-check-label w-100">
		                                    <input type="checkbox" class="form-check-input" name="license_seller" @if(old('license_seller')=='on') checked @endif>
	        								@if(preg_match("@^https?://@", $product->productLicenseUrl))
		                                    <p class="text-black fs-16 lh-24">{!! trans('data.accept_license_seller', ['url'=>$product->productLicenseUrl]) !!}</p>
		                                    @else
		                                    <p class="text-black fs-16 lh-24">{!! trans('data.accept_license_seller', ['url'=>"https://".$product->productLicenseUrl]) !!}</p>
		                                    @endif
		                                    <span class="form-check-sign">
		                                        <span class="custom-check check"></span>
		                                    </span>
	                        				<div class="error_notice license_seller">Please confirm that you accept the data provider’s licence for the use of this data.</div>
	                        				@error('license_seller')
	                        				<div class="invalid-feedback">
	                        					<strong>{{$message}}</strong>
	                        				</div>
	                        				@enderror
		                                </label>
		                            </div>
								</div>
							</div>
							<div class="row mt-20">
								<div class="col-md-12">
									<div class="buttons flex-vcenter">
										<button type="submit" class="customize-btn btn-next">{{ trans('data.confirm') }}</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 flex-column align-items-center">
							<div class="ml-20">
								<p class="fs-24 para text-bold">Buy with confidence</p>
			        			<ul class="custom-list">
			        				<li>30-day warranty</li>
			        				<li>Instant access to the data</li>
			        				<li>Fully secure peer-to-peer data transfer</li>
			        			</ul>
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
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
@endsection