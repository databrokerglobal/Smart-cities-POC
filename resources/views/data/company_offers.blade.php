@extends('layouts.app')

@section('title', 'Download data from '. $company->companyName .' on databroker')
@php
$communitiesList = '';
@endphp
@foreach($communities as $communityInfo)
		@php
		$communitiesList .= $communityInfo->communityName. ', ';
		@endphp
@endforeach
@section('description', 'Looking for data in '.rtrim($communitiesList, ', ').'? Visit '.$company->companyName.' to download their data on databroker')
@section('additional_css')	
	<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper">	
    <div class="container">
    	<div class="app-section app-reveal-section align-items-center pb-10">    		
	        <div class="cat-header">
	        	<div class="row">
	        		<div class="col-lg-12">
			            <h1 class="mt-0">{{trans('pages.provider_title', ['provider' => str_replace( '-', ' ', strtolower($company->companyName))])}}</h1>
			        </div>    
			    </div>        	
	        </div>	        
	        <div class="app-monetize-section-item0 ml-0 mt-20"></div>        
    	</div>		    
    	<h2 id="offer-count" class="mb-20 fs-30 text-bold text-left"> Explore <span>{{ count($dataoffer) }}</span> data offers </h2>   
    	<div id="offer-list">
			<div class="row">
				@php
					$makematching = rand(0, count($dataoffer)-1);					
				@endphp
				@foreach ( $dataoffer as $index => $offer )				
				<div class="col-md-4 mb-20">
					<div class="card card-profile card-plain mb-0">					
						<div class="card-header">
							@php
								$companyName = $offer['company_slug'];
								$title = $offer['offer_slug'];
								$region = "";	
								$offerRegions = '';	
								foreach($offer['region'] as $key=>$r){
									$region = $region . $r->slug;
									$offerRegions .= $r->regionName.', ';
									if($key+1 < count($offer['region'])) $region = $region . "-";
								}

								
								$offerImgAltTxt = $offer['offerTitle'].' from '. strtolower($company->companyName);
								if(!empty($offerRegions)){
								$offerImgAltTxt .= ' in '.rtrim($offerRegions,', ').' on databroker';
								}
							@endphp
							<a href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region])}}">							
								@if( file_exists(public_path().$offer['offerImage']) && $offer['offerImage'] )
									<img alt="{{$offerImgAltTxt}}" title="{{$offerImgAltTxt}}" class="img" style="max-width:100%" src="{{asset($offer['offerImage'])}}" />
								@else
										<img alt="{{$offerImgAltTxt}}" title="{{$offerImgAltTxt}}" class="img" style="max-width:100%"  src="{{ asset('uploads/offer/default.png') }}" />
								@endif
							</a>
						</div>
						<div class="card-body text-left">
							<h2 class="offer-title card-title provider-card-title">{{$offer['offerTitle']}} {{(
								!empty($offerRegions)) ? '| '.rtrim($offerRegions, ', ') : ''}}
				            </h2>			     
							<a href="{{route('data.company_offers', ['companyName'=>$offer['company_slug']])}}">
								@if( file_exists( public_path() . '/uploads/company/'.$offer['provider']->companyLogo) && $offer['provider']->companyLogo )
								<img class="img" src="{{ asset('uploads/company/'.$offer['provider']->companyLogo) }}" />
								@else
								<img class="img" src="{{ asset('uploads/company/thumb/default.png') }}" />
								@endif								
							</a>
						</div>
					</div>	
				</div>						
					@if( $index == $makematching )
					<div class="col-md-4 makematching mb-20">
						<div>
							<div class="card card-profile card-plain mb-0">
								<div class="card-body pd-15">
									<div class="app-monetize-section-item0 mb-40"></div>
									<p class="fs-18">Can't find the data you need?</p>
									<p class="fs-21 text-bold mb-40">Let our tailor-made DataMatch service find the perfect data partner for you!</p>
									<a href="{{route('about.matchmaking')}}"><button type="button" class="button customize-btn mgh25 w225">MATCH ME UP</button></a>
									<p>It’s free!</p>
								</div>
							</div>	
						</div>						
					</div>	
					@endif
				@endforeach							
	  		</div>
  		</div> 	  		
  		<input type="hidden" name="totalcount" value="{{ $totalcount }}">  		
  		<input type="hidden" name="per_page" value="{{ $per_page }}">
  		<div class="text-center @if ( $totalcount <= $per_page ) hide @endif"><button id="offer_loadmore" type="button" class="button secondary-btn mgh25 w225">Load More</button></div>
    </div>      
</div>

@endsection

@section('additional_javascript')
	<script src="{{ asset('js/plugins/select2.min.js') }}"></script>        
@endsection
