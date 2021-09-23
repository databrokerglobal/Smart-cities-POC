@extends('layouts.preview')

@section('title')
{{trans('home.meta_title')}}
@stop
@section('description')
{{trans('home.meta_desc')}}
@stop

@section('content')
<div id="background-image-mobile"></div>
<div class="container-fluid app-wapper header-section">	
    <div class="top-bg-image"></div>
    <div class="container">
    	<div class="app-section app-reveal-section align-items-center">
	        <div class="app-reveal-section-notify" style="margin-bottom: 0;padding-left: 1%;">
                <!-- <h1>Welcome to Databroker </h1> -->
                <h1>Welcome to {{APPLICATION_NAME}} </h1>
	            <p>{{ APPLICATION_SLOGAN }}</p>
	        </div>
	    </div>
    </div>        
    <div class="app-section app-reveal-section align-items-center" style="padding-top: 0;">    
        <img class="app-reveal-section-mark" src="{{ asset('images/patterns/desktop-graphic.png') }}">
    </div>
</div>
<div class="container-fluid app-wapper">    
	<div class="section_splitor_green">        
    </div>
	<div class="container">		
	    <div class="row">
	    	<div class="col-md-12">
                @if(isset($featured_data))
				<div class="card card-raised card-background" style="background-image: url({{ asset('uploads/home/featured_data/'.($featured_data->image??'')) }})">
					<div class="card-body">
						<h6 class="card-category text-info tx-success">{{ trans('home.featured_data') }}</h6>
						<h3 class="card-title fs-40">{{ $featured_data->featured_data_title??'' }}</h3>
						<div class="card-description text-white" id="home_featured_data">
							{!! $featured_data->featured_data_content??'' !!}						
                        </div>
						<a href="{{$featured_data->read_more_url}}" class="btn btn-round readmore">
							READ MORE
						</a>
						<div class="card-author">
							<p> Data provided by {{ $featured_data->companyName }} </p>
							<a href="{{ route('data.company_offers', ['companyName'=>str_replace(' ', '-', strtolower($featured_data->companyName))]) }}"><img src="{{ asset('uploads/company/'.($featured_data->companyLogo??'')) }}" style="height:50px;"></a>
						</div>						
					</div>
                </div>
                @endif
			</div>
	    </div>
	</div>
</div>	

<div class="container-fluid app-wapper" id="home-mobile-3">
    <div class="container">        
        <h1 class="mb-20 fs-30 text-bold text-left">{{ trans('home.trending') }}</h1>
        <div class="app-partner-items row">
            @foreach($trendings as $trending)
        	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                <a href="{{ $trending->logo_url??'' }}">
                    <div class="app-partner-item info">
                        <div class="icon">
                            <img src="{{ asset('uploads/home/trending/'.($trending->image??'')) }}">
                        </div>        
                        <h4 class="info-title"> {{ $trending->title??'' }} </h4>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
		<h1 class="mt-80 mb-20 fs-30 text-bold text-left"> {{ trans('home.new_on_marketplace') }} </h1>
		<div class="row">
            @foreach($marketplaces as $marketplace)
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('uploads/home/marketplace/medium/'.($marketplace->image??'')) }}" id="responsive-card-img"/>
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">{{ $marketplace->title }}</h4>
                        <h6 class="card-category">{{ $marketplace->legion }}</h6>
                        <a href="{{ $marketplace->logo_url??'' }}">
                            <img class="img" src="{{ asset('uploads/home/marketplace/logo/'.($marketplace->logo??'')) }}" />
                        </a>
						
					</div>			
				</div>	
            </div>
            @endforeach	
  		</div>
    </div>        
</div>

<div class="container-fluid app-wapper" id="home-mobile-4">
	<div class="section_splitor_mobile"></div>    
    <div style="background: url({{ asset('images/patterns/background_01.png') }});background-position: right;background-repeat: no-repeat;background-size: contain;">
        <div style="background: url({{ asset('images/patterns/background_02.png') }});background-position: left;background-repeat: no-repeat;background-size: contain;">
            <div class="app-section app-peek-section align-items-center">
                <div class="app-monetize-section-item0"></div>
                <h1 class="fs-30 mb-10">{{ trans('home.looking_supercharge')}}</h1>
                <p class="center">
                    {{ trans('home.looking_supercharge_description')}}
                    <span class="height-space" style="display: block;"></span>
                    <a href="{{ route('about.matchmaking') }}">
                        <button type="button" class="button customize-btn mgh25 w225">{{ trans('home.match_me') }}</button>
                    </a>                     
                </p>
                <p class="text-free text-grey">It's free</p>
            </div>
        </div>
    </div>
    <div class="section_splitor_mobile"></div>    
</div>

<div class="container-fluid app-wapper" id="home-mobile-5">	
	<div class="container">
		<h1 class="mt-80 mb-20 fs-30 text-bold text-left"> {{ trans('home.team_picks') }} </h1>
		<div class="row">
            @foreach($teampicks as $teampick)
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('uploads/home/teampicks/'.($teampick->image??'')) }}" id="responsive-card-img"/>
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">{{ $teampick->title??'' }}</h4>
						<h6 class="card-category">{{ $teampick->legion??'' }}</h6>
						<a href="{{ $teampick->logo_url??'' }}"><img class="img" src="{{ asset('uploads/home/teampicks/logo/'.($teampick->logo??'')) }}" /></a>
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
                    <a href="{{ route('data.company_offers', ['companyIdx'=>str_replace(' ', '-', strtolower($featured_provider->companyName))]) }}">
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
    </div>    
</div>    

<div class="container-fluid app-wapper" id="home-mobile-6">
	<div class="section_splitor_mobile"></div>    
    <div style="background: url({{ asset('images/patterns/background_01.png') }});background-position: right;background-repeat: no-repeat;background-size: contain;">
        <div style="background: url({{ asset('images/patterns/background_02.png') }});background-position: left;background-repeat: no-repeat;background-size: contain;">
            <div class="app-section app-peek-section align-items-center">
                <div class="app-monetize-section-item0"></div>
                <h1 class="fs-30" style="margin-bottom: 10px;">{{ trans('home.sell_or_share') }}</h1>
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
		<h1 class="mt-80 mb-20 fs-30 text-bold text-left"> {{trans('home.top_usecase')}} </h1>
		<div class="row">
			@foreach($top_usecases as $top_usecase)
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="{{ route('about.usecase_detail',  ['id' => ($top_usecase->articleIdx??'')] ) }}">
							<img class="img" src="{{ asset('uploads/usecases/'.($top_usecase->image??'')) }}" />
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title text-bold text-green">{{ $top_usecase->community->communityName??'' }}</h4>
						<p class="card-description text-bold">{{ $top_usecase->articleTitle??'' }}</p>						
					</div>			
				</div>	
			</div>
			@endforeach	
  		</div>  		
  	</div>  	
</div>
@endsection

