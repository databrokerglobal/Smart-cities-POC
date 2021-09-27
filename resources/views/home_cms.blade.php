@extends('layouts.app')

@section('title')
{{trans('home.meta_title')}}
@stop
@section('description')
{{trans('home.meta_desc')}}
@stop

@section('content')

<div id="background-image-mobile"></div>
<div class="container-fluid app-wapper header-section">	
  
    <div class="container">
    	<div >
			<div class="app-reveal-section-notify" style="margin-bottom: 0;padding-left: 1%;">
                <h1>Welcome to {{APPLICATION_NAME}} </h1>                
	            <p>{{ APPLICATION_SLOGAN }}</p>
	        </div>
	    </div>
    </div>        
    <div class="app-section app-reveal-section align-items-center" style="padding-top: 0;">    

        <img alt ="{{ APPLICATION_SLOGAN }}" title="{{ APPLICATION_SLOGAN }}" class="app-reveal-section-mark"  src="{{ asset('images/patterns/desktop-graphic.png') }}">
    </div>
</div>
<div class="container-fluid app-wapper">    
	<div class="section_splitor_green">        
    </div>
	<div class="container">	
    <div class="row">
	    	<div class="col-md-12">
				<div class="card card-raised card-background" style="background-image: url({{ asset('uploads/home/featured_data/'.($featured_data->image??'')) }})">
					<div class="card-body">
					    @if(isset($featured_data))
                        @php
								$company_slug = $featured_data->company_slug;
								$title = $featured_data->offer_slug;
								$region = "";
								foreach($featured_data['region'] as $key=>$r){
									$region = $region . $r->slug;
									if($key+1 < count($featured_data['region'])) $region = $region . "-";
								}
						@endphp
						<h6 class="card-category text-info tx-success">{{ trans('home.featured_data') }}</h6>
						<h3 class="card-title fs-40">{{ $featured_data->featured_data_title ?? '' }}</h3>
						<div class="card-description text-white" id="home_featured_data">
							{!! $featured_data->featured_data_content??'' !!}						
                        </div>
						<a href="{{route('Offerdetail', $featured_data->offer_slug)}}" class="btn btn-round readmore">
							READ MORE
						</a>
						<div class="card-author">
							<p> Data provided by {{ $featured_data->companyName }} </p>
							
							<a href="{{route('Offerdetail', $featured_data->offer_slug)}}">
							@if( $featured_data->companyLogo != '' && file_exists(public_path( "uploads/company/tiny/".$featured_data->companyLogo??'' )) )  
								<img alt ="{{ $featured_data->featured_data_title ?? '' }}" 
								title="{{ $featured_data->featured_data_title ?? '' }}" src="{{ asset('uploads/company/tiny/'.($featured_data->companyLogo??'')) }}"></a>
							@else 
							<img alt ="{{ $featured_data->featured_data_title ?? '' }}" 
								title="{{ $featured_data->featured_data_title ?? '' }}" src="{{ asset('uploads/company/default.png') }}"></a>
							@endif							
						</div>	
                        @endif					
					</div>
                </div>
			</div>
	    </div>	

	</div>
</div>	

<div class="container-fluid app-wapper" id="home-mobile-3">
    <div class="container">        
        <h2 class="mb-20 fs-30 text-bold text-left">{{ trans('home.trending') }}</h2>
        <div class="app-partner-items row">
			@foreach($trendings as $trending)
			@php
				$company_slug = App\Models\Provider::findorfail($trending->offer->providerIdx);
				
			@endphp
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                <a href="{{ route('Offerdetail',$trending->offer->slug) }}">
                    <div class="app-partner-item info">
                        <div class="icon">
						@if( $trending->image != '' && file_exists(public_path( "uploads/home/trending/".$trending->image??'' )) )  
								<img alt ="{{ $trending->title ?? '' }}" title="{{ $trending->title ?? '' }}" src="{{ asset('uploads/home/trending/'.($trending->image??'')) }}">
							@else 
								<img  alt ="{{ $trending->title ?? '' }}"  title="{{ $trending->title ?? '' }}"
								 class="img" src="{{ asset('uploads/home/trending/default.png') }}" />
							@endif		
							
                        </div>        
                        <h4 class="info-title"> {{ $trending->title ?? '' }} </h4>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
		<h2 class="mt-20 mb-20 fs-30 text-bold text-left"> {{ trans('home.new_on_marketplace') }} </h2>
		<div class="row">
            @foreach($marketplaces as $marketplace)               
                @php
					$company_slug = $marketplace['company_slug'];
					$title = $marketplace['offer_slug'];
				    $region = "";
					foreach($marketplace['region'] as $key=>$r){
						$region = $region . $r->slug;
						if($key+1 < count($marketplace['region'])) $region = $region . "-";
					}
				@endphp
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
                        <a href="{{route('data_details', ['companyName'=>$company_slug, 'param'=>$title . '-' . $region])}}">
							@if( $marketplace->offerImage != '' && file_exists(public_path( "uploads/offer/medium/".$marketplace->offerImage??'' )) )  
								<img alt ="{{$marketplace['offerDescription'] ?? ''}}" alt ="{{$marketplace['offerDescription'] ?? ''}}" title="{{$marketplace['offerTitle'] ?? ''}}"
								class="img" src="{{ asset('uploads/offer/medium/'.($marketplace->offerImage??'')) }}" id="responsive-card-img"/>
							@else 
								<img  alt ="{{$marketplace['offerDescription'] ?? ''}}"  title="{{ $marketplace['offerDescription'] ?? '' }}" class="img" src="{{ asset('uploads/default.png') }}" />
							@endif							
						</a>
					</div>
					<div class="card-body text-left">
                        <a href="{{route('data_details', ['companyName'=>$company_slug, 'param'=>$title . '-' . $region])}}">
                            <h3 class="card-title">{{$marketplace['offerTitle']}}</h3>
                        </a>
                        <h6 class="card-category">
                                @foreach($marketplace['region'] as $region)
				            		<span>{{ $region->regionName }}</span>
				            	@endforeach</h6>
                        <a href="{{ $marketplace->logo_url ?? '' }}">
							@if( $marketplace['provider']->companyLogo != '' && file_exists(public_path( "uploads/home/teampicks/logo/thumb//".$marketplace['provider']->companyLogo??'' )) )  
								<img alt ="{{$marketplace['companyName'] ?? ''}}" alt ="{{$marketplace['companyName'] ?? ''}}" title="{{$marketplace['companyName'] ?? ''}}" 
								class="img" src="{{ asset('uploads/company/'.($marketplace['provider']->companyLogo??'')) }}" />
							@else
								<img alt ="{{$marketplace['companyName'] ?? ''}}"  title="{{ $marketplace['companyName'] ?? '' }}" class="img" src="{{ asset('uploads/company/thumb/default.png') }}" />
							@endif
							
                        </a>
						
					</div>			
				</div>	
            </div>
            @endforeach	
  		</div>
		@php 
			$all_contents =  DB::table('contents')->select('contents.*')->where('isActive',1)->orderBy('sortOrder','ASC')->get();			
		@endphp 
		<h1 style="display:none" class="mt-20 mb-20 fs-30 text-bold text-left"> {{ trans('home.databroker_content_hub') }} </h1>
		<div  class="row" style="display:none">
				@foreach($all_contents as $content)					
					<div class="col-md-6 col-lg-6 col-xl-6">
						<div class="content-card">
							<a href="{{$content->content_page_url}}">
								<div class="card card-profile card-plain">
									<div  class="row">
										<div class="col-md-3 col-12 img-container">
												<img class="img" src="{{ asset($content->content_image_path) }}"/>							
										</div>
										<div class="col-md-8 col-12">
												<h4 class="card-title">{{$content->meta_title}} </h4>
												<p>{{$content->meta_data}}</p>
										</div>	
										<div class="col-md-1 col-12 icon-container">
											<i class="fa fa-arrow-right"></i>						
										</div>
									</div>
								</div>	
							</a>	
						</div>			
					</div>
				@endforeach
					
		</div>
			
		</div>
    </div>        
</div>

<div class="container-fluid app-wapper" id="home-mobile-4">
	<div class="section_splitor_mobile"></div>    
	<div style="background: url({{ asset('images/patterns/background_01.svg') }});background-position: right;background-repeat: no-repeat;background-size: contain;">
        <div style="background: url({{ asset('images/patterns/background_02.svg') }});background-position: left;background-repeat: no-repeat;background-size: contain;">
             <div class="app-section app-peek-section align-items-center">
                <div class="app-monetize-section-item0"></div>
                <h2 class="fs-30 text-center mb-10">{{ trans('home.looking_supercharge')}}</h2>
                <p class="center">
                    {{ trans('home.looking_supercharge_description')}}
                    <span class="height-space" style="display: block;"></span>
                    <a href="{{ route('about.matchmaking') }}">
                        <button type="button" class="button customize-btn mgh25 w225">{{ trans('home.match_me') }}</button>
                    </a>                     
                </p>
				 <!-- <p class="text-free text-grey">It's free</p> -->
            </div>
        </div>
    </div>
   
</div>

@if(count($teampicks) > 0 || count($featured_providers) > 0) 
<div class="container-fluid app-wapper" id="home-mobile-5">	
	<div class="container">
    @if(count($teampicks) > 0)
		<h2 class="mt-0 mb-20 fs-30 text-bold text-left"> {{ trans('home.team_picks') }} </h2>
		<div class="row">
            @foreach($teampicks as $teampick)
			
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
					 <a href="{{ $teampick->logo_url ?? '#' }}">
						@if( $teampick->image != '' && file_exists(public_path( "uploads/home/teampicks/tiny/".$teampick->image??'' )) )  
							<img alt ="{{ $teampick->title ?? '' }}" title="{{ $teampick->title ?? '' }}" class="img" src="{{ asset('uploads/home/teampicks/tiny/'.($teampick->image ?? '')) }}"/>
                        @else 
                            <img  title="{{ $teampick->title ?? '' }}" class="img" src="{{ asset('uploads/default.png') }}" />
                    	@endif							
						</a>
					</div>
					<div class="card-body text-left">
						<h3 class="card-title">{{ $teampick->title ?? '' }}</h3>
						<h6 class="card-category">{{ $teampick->legion ?? '' }}</h6>
						<a href="{{ $teampick->logo_url ?? '#' }}">
							@if( $teampick->image != '' && file_exists(public_path( "uploads/home/teampicks/logo/thumb//".$teampick->logo??'' )) )  
							<img alt ="{{ $teampick->meta_desc ?? '' }}"  title="{{ $teampick->meta_title ?? '' }}" class="img" 
							src="{{ asset('uploads/home/teampicks/logo/thumb/'.($teampick->logo ?? '')) }}" />
							@else
								<img  alt ="{{ $teampick->meta_desc ?? '' }}" title="{{ $teampick->title ?? '' }}" class="img" src="{{ asset('uploads/company/thumb/default.png') }}" />
							@endif
						</a>
					</div>			
				</div>	
            </div>	
            @endforeach
  		</div>
        @endif
        @if(count($featured_providers) > 0)
	    <div class="app-section app-monetize-section align-items-center">
	        <div class="app-monetize-section-item0"></div>
	        <div class="app-monetize-section-item1">
	            <h2 class="fs-30"> {{ trans('home.featured_data_providers') }} </h2>
	            <p>Check out their data offers!</p>
	        </div>
	    </div>
	    <div class="app-partner-items row">
            @foreach($featured_providers as $featured_provider)					
        	<div class="col-md-4 col-lg-2 col-xl-2">
                <div>
                    <a href="{{ route('data.company_offers', ['companyName' => $featured_provider->slug ]) }}">
                        <div class="app-partner-item">
                            <div class="img">
                                @if(file_exists(public_path("uploads/company/tiny/".$featured_provider->companyLogo))) 
                                <img alt ="{{ $featured_provider->companyName ?? '' }}" title="{{ $featured_provider->companyName ?? '' }}" src="{{ asset('uploads/company/tiny/'.$featured_provider->companyLogo) }}" style="height:75px;">
                                @else 
                                <img alt ="{{ $featured_provider->companyName ?? '' }}" title="{{ $featured_provider->companyName ?? '' }}" src="{{ asset('uploads/company/default_tiny.png') }}" style="height:75px;">
                                @endif
                            </div>        
                        </div>
                    </a>
                    
                </div>
            </div>
            @endforeach
        </div>  
        @endif  
    </div>    
</div>    
@endif

<div class="container-fluid app-wapper" id="home-mobile-6">
	<div class="section_splitor_mobile"></div>    
    <div style="background: url({{ asset('images/patterns/background_01.png') }});background-position: right;background-repeat: no-repeat;background-size: contain;">
        <div style="background: url({{ asset('images/patterns/background_02.png') }});background-position: left;background-repeat: no-repeat;background-size: contain;">
            <div class="app-section app-peek-section align-items-center">
                <div class="app-monetize-section-item0"></div>
                <h2 class="fs-30 text-center mb-10">{{ trans('home.sell_or_share') }}</h2>
                <p class="center">
                    {{ trans('home.sell_or_share_desc')}}
                    <span class="height-space" style="display: block;"></span>
                    <a href="{{ route('data_offer_publish') }}">
                        <button type="button" class="button customize-btn mgh25 w225">{{ trans('home.lets_started') }}</button>
                    </a>                     
                </p>                
            </div>
        </div>
    </div>
    <div class="section_splitor_mobile"></div>    
</div> 

<div class="container-fluid app-wapper" id="home-mobile-7">	
	<div class="container">
		<h2 class="mt-0 mb-20 fs-30 text-bold text-left"> {{trans('home.top_usecase')}} </h2>
		<div class="row">
        @if(count($top_usecases))
			@foreach($top_usecases as $top_usecase)			
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="{{ route('about.usecase_detail',  ['title' => $top_usecase->slug]) }}">
                            @if( $top_usecase->image != '' && file_exists(public_path( "uploads/usecases/tiny/".$top_usecase->image??'' )) )  
                            <img  alt ="{{ $top_usecase->meta_desc ?? '' }}"  title="{{ $top_usecase->meta_title ?? '' }}" class="img" src="{{ asset('uploads/usecases/tiny/'.($top_usecase->image??'')) }}" />
                            @else 
                            <img  alt ="{{ $top_usecase->meta_desc ?? '' }}" title="{{ $top_usecase->meta_title ?? '' }}" class="img" src="{{ asset('uploads/default.png') }}" />
                            @endif
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title text-bold text-green">{{ $top_usecase->community->communityName??'' }}</h4>
						<h3 class="card-title">{{ $top_usecase->articleTitle??'' }}</h3>						
					</div>			
				</div>	
			</div>
			@endforeach	
        @endif
  		</div>  		
  	</div>  	
</div>
@endsection