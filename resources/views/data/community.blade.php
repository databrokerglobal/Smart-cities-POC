@extends('layouts.app')

@section('title', trans('home.'.str_replace( ' ', '_', strtolower($community) ).'_desc_meta_title'))
@section('description', trans('home.'.str_replace( ' ', '_', strtolower($community) ).'_desc_meta_desc'))

@section('content')
<div class="container-fluid app-wapper">	
    <div class="container">
    	<div class="row">
	    	<div class="col-md-12">	    		
				<div class="card card-raised card-background" style="background-image: url({{ asset('images/communities/'.str_replace( ' ', '_', $community).'/hero.jpg') }})">
					<div class="hero_overlay_bg"></div>
					<div class="card-body">						
						<h2 class="card-title fs-40">{{ $communityDetail->communityName }}</h2>
						<p class="text-white fs-18">
							{!! $communityDetail->overview!!}
						</p>
						<a href="{{ route('data_community.'.$communityDetail->slug) }}" class="btn btn-round readmore mt-30">
							{{ trans('pages.view_dataoffer') }}
						</a>										
					</div>
				</div>
			</div>
	    </div>   
	    <div class="row">
	    	@foreach( $themes as $theme )
	    	<div class="col-md-4 mt-20">
	    		<h4 class="text-green fs-20 text-bold">{{ $theme->themeName }}</h4>
	    		<p class="fs-18">
	    			{{ $theme->themeText }}
	    		</p>
	    	</div>
	    	@endforeach	    	
	    </div> 	
	    <div class="mt-40 text-center">		        	
        	<a href="{{ route('data_community.'.str_replace( ' ', '_', strtolower($community))) }}" ><button type="button" class="button secondary-btn mgh25 w225">{{ trans('pages.view_dataoffer') }}</button></a>
        </div>
		@if($communityDiscoverData && count($communityDiscoverData)>0)
        <h2 class="mt-80 mb-20 fs-30 text-bold text-left"> {{trans('pages.discover_improve_business', ['community' => str_replace( '-', ' ', strtolower($community))])}} </h2>
		<div class="row">
			@foreach($communityDiscoverData as $discoverData)
			@php
				$company_slug = $discoverData->offer->provider->user->company->slug;
				$title = $discoverData->offer->slug;
				$region = "";
				foreach($discoverData->offer->region as $key=>$r){
					$region = $region . $r->slug;
					if($key+1 < count($discoverData->offer->region)) $region = $region . "-";
				}

			@endphp
			<div class="col-md-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="{{route('data_details', ['companyName'=>$company_slug, 'param'=>$title . '-' . $region])}}">
							@if(!empty($discoverData->image) &&  file_exists(public_path("uploads/communities/discover/medium/".$discoverData->image))) 
									<img alt ="{{$communityDetail->communityName}}" title ="{{$communityDetail->communityName}}" class="img" style="    max-height: 212px;" src="{{asset("uploads/communities/discover/medium/".$discoverData->image)}}" />
							@else
									<img alt ="{{$communityDetail->communityName}}" title ="{{$communityDetail->communityName}}" class="img" style="max-width:100%"  src="{{ asset('uploads/offer/default.png') }}" />
							@endif
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title text-bold text-green">{{ $communityDetail->communityName }}</h4>
						<p class="card-description text-bold">{{ $discoverData->discription }}
						</p>						
					</div>			
				</div>	
			</div>
			@endforeach				
  		</div>
		@endif
    </div>      
</div>

<div class="container-fluid app-wapper">
	<div class="section_splitor"></div>    
    <div style="background: url({{ asset('images/patterns/background_01.png') }});background-position: right;background-repeat: no-repeat;background-size: contain;">
        <div style="background: url({{ asset('images/patterns/background_02.png') }});background-position: left;background-repeat: no-repeat;background-size: contain;">
            <div class="app-section app-peek-section align-items-center">
                <div class="app-monetize-section-item0"></div>
                <h1 class="fs-30" style="margin-bottom: 10px;">{{ trans('pages.what_business_challenge') }}</h1>
                <p class="center">
                    {{ trans('pages.tell_us_data_partner')}}
                    <span class="height-space" style="display: block;"></span>
                    <a href="{{ route('contact') }}">
                        <button style="width: 270px;" type="button" class="button customize-btn mgh25 w225">TRY OUR DATAMATCH SERVICE</button>
                    </a>                     
                </p> 
                <p class="text-free text-grey">It's free</p>               
            </div>
        </div>
    </div>
    <div class="section_splitor"></div>    
</div>

<div class="container-fluid app-wapper">	
	<div class="container">
		<h2 class="mt-80 mb-20 fs-30 text-bold text-left"> {{ trans('home.team_picks') }} </h2>
		<div class="row">
			@foreach($offers as $offer)		
			<div class="col-md-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('images/blogs/blog1.png') }}" />
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="offer-title card-title">{{$offer['offerTitle']}}</h4>
						<h6 class="card-category offer-location">
							@foreach($offer['region'] as $region)
			            		<span>{{ $region->regionName }}</span>
			            	@endforeach</h6>
						<a href="{{ route('data.company_offers', ['companyName'=>str_replace(' ', '-', strtolower($offer['companyName']))])}}">
							@if( file_exists( public_path() . '/uploads/company/'.$offer['provider']->companyLogo) && $offer['provider']->companyLogo )
							<img class="img" src="{{ asset('uploads/company/'.$offer['provider']->companyLogo) }}" />
							@else
							<img class="img" src="{{ asset('uploads/company/default.png') }}" />
							@endif
						</a>
					</div>			
				</div>	
			</div>
			@endforeach
  		</div>

	    <div class="app-section app-monetize-section align-items-center">
	        <div class="app-monetize-section-item0"></div>
	        <div class="app-monetize-section-item1">
	            <h1 class="fs-30"> {{ trans('home.featured_data_providers') }} </h1>
	            <p>Check out their data offers!</p>
	        </div>
	    </div>
	    <div class="app-partner-items row">
        	@foreach($featured_providers as $featured_provider)
        	<div class="col-md-4 col-lg-2 col-xl-2">
                <div>
                    <a href="{{ route('data.company_offers', ['companyName'=>str_replace(' ', '-', strtolower($featured_provider->companyName))]) }}">
                        <div class="app-partner-item">
                            <div class="img">
                                @if(file_exists(public_path("uploads/company/".$featured_provider->companyLogo))) 
                                <img src="{{ asset('uploads/company/'.$featured_provider->companyLogo) }}" style="height:75px;">
                                @else 
                                <img src="{{ asset('uploads/company/default.png') }}" style="height:75px;">
                                @endif
                            </div>        
                        </div>
                    </a>
                    <!-- <a href="{{$featured_provider->companyURL}}">{{$featured_provider->companyName}}</a> -->
                </div>
            </div>
            @endforeach
        </div> 
		@if($newInCommunity && count($newInCommunity)>0)
        <h2 class="mt-80 mb-20 fs-30 text-bold text-left"> NEW IN THE {{str_replace( '-', ' ', strtoupper($community))}} COMMUNITY </h2>
		<div class="row">
			@foreach($newInCommunity as $communityNewOffer)
			@php
				$company_slug = $communityNewOffer->offer->provider->user->company->slug;
				$comapnyName = $communityNewOffer->offer->provider->companyName;
				$offerProviderCompanyLogo = $communityNewOffer->offer->provider->companyLogo;
				$title = $communityNewOffer->offer->slug;
				$offerTitle = $communityNewOffer->offer->offerTitle;
				$offerRegions = $communityNewOffer->offer->region;
				$region = "";
				foreach($offerRegions as $key=>$r){
					$region = $region . $r->slug;
					if($key+1 < count($offerRegions)) $region = $region . "-";
				}
				$alt_text_offer = $offerTitle.' from '.$comapnyName. ' in '. $region;								
				$alt_text_provider = $comapnyName. ' on '.APPLICATION_NAME;
				$offerImage = $communityNewOffer->offer->offerImage;
			@endphp
			<div class="col-md-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="{{route('data_details', ['companyName'=>$company_slug, 'param'=>$title . '-' . $region])}}">
						@if( file_exists(public_path().$offerImage) && $offerImage )
								<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" style="max-width:100%" src="{{asset($offerImage)}}" />
						@elseif( file_exists(public_path('uploads/offer/medium/'.$offerImage)) && $offerImage )
							<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" style="max-width:100%"  src="{{ asset('uploads/offer/medium/'.$offerImage) }}" />
						@else
								<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" style="max-width:100%"  src="{{ asset('uploads/offer/default.png') }}" />
						@endif
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">{{$offerTitle}}</h4>
						<h6 class="card-category">
							@foreach($offerRegions as $region)
				            		<span>{{ $region->regionName }}</span>
				            	@endforeach</h6>
						@if( file_exists( public_path() . '/uploads/company/'.$offerProviderCompanyLogo) && $offerProviderCompanyLogo )
						<img alt ="{{$alt_text_provider}}" title ="{{$alt_text_provider}}" class="img" src="{{ asset('uploads/company/'.$offerProviderCompanyLogo) }}" />
						@else
						<img alt ="{{$alt_text_provider}}" title ="{{$alt_text_provider}}" class="img" src="{{ asset('uploads/company/default.png') }}" />
						@endif
					</div>			
				</div>	
			</div>
			@endforeach				
  		</div>   
  		<div class="mt-40 text-center">		        	
        	<a href="{{ route('data_community.'.str_replace( ' ', '_', strtolower($community))) }}" ><button type="button" class="button secondary-btn mgh25 w225">View Data Offer</button></a>
        </div>
		@endif
    </div>    
</div>  

@endsection

