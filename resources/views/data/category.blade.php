@extends('layouts.app')



@section('title', $communityDetail->meta_title ?? ucfirst($category))
@section('description', $communityDetail->meta_desc ??ucfirst($category))

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
	        			<h1>{{ trans('pages.explore_data_offer') }}
			            <i>{{$communityDetail->communityName}}</i> Community<span class="theme_text">
							@if(isset($curTheme)) {{"/".$curTheme->themeName}} @endif</span><span class="region_text">
							@if($regionDetail)
								in {{$regionDetail['regionName']}}
							@endif
						</span></h1>
			        </div>    
			    </div>
			    <div class="row">
			    	<div class="col-lg-6">
			            <p class="desc mt-10">
							{!!$communityDetail->description!!}
			            </p>	            
			            <a href="{{ route('data.community_'.$category) }}"><button type="button" class="button secondary-btn w225 mgh25">{{ trans('pages.read_more') }}</button></a>
	        		</div>	
	        	</div>	        	
	        </div>	        
	        <div class="app-monetize-section-item0 ml-0 mt-20"></div>
	        <div class="cat-body">
				@csrf    
	        	<div class="row community-filter">	        				
	        		<div class="col-xl-4 col-md-4 col-sm-4 col-12 col-lg-8 px-5 mb-20 community">
	        			<label class="cat-label">{{ trans('pages.category_explore') }}</label>	        	
	                    <div class="adv-combo-wrapper custom-select2 cat-select">
		                    <select id="community" data-placeholder="{{ trans('pages.select_by_community') }}" class="no-search">
		                    	<option value="all">All Communities</option>
		                    	@foreach ($communities as $community)
	                                <option value="{{$community->communityIdx}}" <?php echo (isset($communityDetail->slug) && $communityDetail->slug == $community->slug)?'selected':'' ?> community-name="{{ $community->slug }}">The {{ $community->communityName }} community</option>
	                            @endforeach
		                    </select>	                        
		                </div>
	        		</div>
	        		<div class="col-xl-4 col-md-4 col-sm-4 col-12 col-lg-6 px-5 mb-20 theme">
	        			<label class="cat-label"> {{trans('pages.category_community_for_about')}}</label>	        		
	                    <div class="adv-combo-wrapper custom-select2 cat-select">
		                    <select id="theme" data-placeholder="{{ trans('pages.all_themes') }}" class="no-search">
		                    	<option value="all">All themes</option>
		                    	@foreach ($themes as $theme)
	                                <option value="{{$theme->themeIdx}}" community-id="{{ $theme->communityIdx }}">{{ $theme->themeName }}</option>
	                            @endforeach
		                    </select>	                        
		                </div>
	        		</div>
	        		<div class="col-xl-4 col-lg-6 col-md-4 col-sm-4 col-12 px-5 mb-20 region">
	        			<label class="cat-label">{{ trans('pages.in') }}</label>
	        			<div class="custom-dropdown-container cat-select">
	                        <div id="region" class="custom-dropdown" tabindex="1">
	                        	<input type="hidden" name="region" value="">
	                            <div class="select">
	                                <span>Select Region</span>
	                            </div>
	                            <ul class="custom-dropdown-menu region-select mt-10" style="display: none;">
				                    <div class="adv-combo-wrapper custom-select2">
					                    <select data-placeholder="{{ trans('pages.search_by_country') }}">
					                    	<option></option>
					                    	@foreach ($countries as $country)
				                                <option value="{{$country->regionIdx}}">{{ $country->regionName }}</option>
				                            @endforeach
					                    </select>	                        
					                </div>	                            	
	                            	<h5>Or {{ trans('pages.select_region') }}:</h5>
	                            	<!-- <span class="region" region-id="all">{{ trans('pages.all_regions') }}</span> -->
	                            	@foreach ($regions as $region)
					                    <span class="region" region-id="{{$region->regionIdx}}">{{$region->regionName}}</span>
					                @endforeach					                
	                            </ul>
	                        </div>	                        
	                    </div>  
	        		</div>
	        	</div>
	        </div>	        
    	</div>	
		
		<div id="no-offers" style="display:<?=count($dataoffer) == 0 ?'block':'none'?>">
			<p class="desc mt-10">Unfortunately, we could not find any data offers in <b>"{{$communityDetail->communityName}} Community"</b>.</p>

			<p class="desc mt-10">Data sets listed on the Databroker marketplace are, in many cases, just a sliver of what can be made available upon request. Contact our DataMatch Advisor for help with your search 
				for data <a href="{{ route('about.matchmaking') }}">(https://www.databroker.global/about/matchmaking)</a>
			</p>
		</div>
		
		@if(count($dataoffer) > 0)	    
    	<h2 id="offer-count" class="mb-20 fs-30 text-bold text-left"> There are currently <span>{{ count($dataoffer) }}</span> data offers in the <span>{{ $communityDetail->communityName }}</span> community </h2>   
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
								$company_slug = $offer['company_slug'];
								$title = $offer['offer_slug'];
								$region = "";
								foreach($offer['region'] as $key=>$r){
									$region = $region . $r->slug;
									if($key+1 < count($offer['region'])) $region = $region . "-";
								}

								$alt_text_offer = $offer['offerTitle'].' from '.$offer['companyName']. ' in '. $region;								
								$alt_text_provider = $offer['companyName']. ' on '.APPLICATION_NAME;

							@endphp
							<a href="{{route('data_details', ['companyName'=>$company_slug, 'param'=>$title . '-' . $region])}}">
							@if( file_exists(public_path().$offer['offerImage']) && $offer['offerImage'] )
									<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" style="max-width:100%" src="{{asset($offer['offerImage'])}}" />
							@else
									<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" style="max-width:100%"  src="{{ asset('uploads/offer/default.png') }}" />
							@endif
							</a>
							
						</div>
						
						<div class="card-body text-left">
					
							<h2 class="offer-title card-title offer-card-title">{{$offer['offerTitle']}} | {{$offer['companyName']}}</h2>
							<h3 class="offer-location card-category">
								@foreach($offer['region'] as $region)
				            		<span>{{ $region->regionName }}</span>
				            	@endforeach
								
				            </h3>			           
							<a href="{{ route('data.company_offers', ['companyName'=> $company_slug] ) }}">
								@if( file_exists( public_path() . '/uploads/company/'.$offer['provider']->companyLogo) && $offer['provider']->companyLogo )
								<img alt ="{{$alt_text_provider}}" title ="{{$alt_text_provider}}" class="img" src="{{ asset('uploads/company/'.$offer['provider']->companyLogo) }}" />
								@else
								<img alt ="{{$alt_text_provider}}" title ="{{$alt_text_provider}}" class="img" src="{{ asset('uploads/company/default_thumb.png') }}" />
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
									<a href="{{route('about.matchmaking')}}"><button type="button" class="button customize-btn mgh25">MATCH ME UP</button></a>
									<p>It’s free!</p>
								</div>
							</div>	
						</div>						
					</div>	
					@endif
				@endforeach							
	  		</div>
  		</div> 	
		@endif		
  		<input type="hidden" name="totalcount" value="{{ $totalcount }}">  		
  		<input type="hidden" name="per_page" value="{{ $per_page }}">
  		<div class="text-center @if ( $totalcount <= $per_page ) hide @endif"><button id="offer_loadmore" type="button" class="button secondary-btn mgh25 w225">Load More</button></div>
    </div>      
</div>

@endsection

@section('additional_javascript')
	<script src="{{ asset('js/plugins/select2.min.js') }}"></script>
@endsection
