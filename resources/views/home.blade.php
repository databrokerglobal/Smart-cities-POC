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
    <div class="top-bg-image"></div>
    <div class="container">
    	<div class="app-section app-reveal-section align-items-center">
	        <div class="app-reveal-section-notify" style="margin-bottom: 0;padding-left: 1%;">			
				<h1>Welcome to {{APPLICATION_NAME}} </h1>
	            <p>{{ APPLICATION_SLOGAN }}</p>
	        </div>
	    </div>
    </div>        
    <div class="app-section app-reveal-section align-items-center" style="padding-top: 0;">    
        <img class="app-reveal-section-mark" style="height:480px;" src="{{ asset('images/patterns/desktop-graphic.png') }}">
    </div>
</div>
<div class="container-fluid app-wapper">    
	<div class="section_splitor_green">        
    </div>
	<div class="container">		
	    <div class="row">
	    	<div class="col-md-12">
				<div class="card card-raised card-background" style="background-image: url({{ asset('images/banner.jpg') }})">
					<div class="card-body">
						<h6 class="card-category text-info tx-success">{{ trans('home.featured_data') }}</h6>
						<h3 class="card-title fs-40">Weather data</h3>
						<p class="card-description text-white">
							Get current weather and daily forecasts, interactive maps that show precipitation, clouds, pressure and wind around your location. Now available for all countries in Europe.
						</p>
						<a href="#pablo" class="btn btn-round readmore">
							READ MORE
						</a>
						<div class="card-author">
							<p> Data provided by sigfox </p>
							<img src="{{ asset('images/blogs/logo_def.jpg') }}">	
						</div>						
					</div>
				</div>
			</div>
	    </div>
	</div>
</div>	

<div class="container-fluid app-wapper" id="home-mobile-3">
    <div class="container">        
        <h1 class="mb-20 fs-30 text-bold text-left">{{ trans('home.trending') }}</h1>
        <div class="app-partner-items row">
        	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-2">
        		<div class="app-partner-item info">
					<div class="icon">
						<img src="{{ asset('images/design/transport.svg') }}">
	                </div>        
					<h4 class="info-title"> Car data </h4>
        		</div>

        	</div>
        	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-2">
        		<div class="app-partner-item info">
					<div class="icon">
						<img src="{{ asset('images/design/transport.svg') }}">
	                </div>
					<h4 class="info-title"> Traffic density </h4>
        		</div>

        	</div>
        	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-2">
        		<div class="app-partner-item info">
					<div class="icon"><img src="{{ asset('images/design/people.svg') }}">
                    </div>
					<h4 class="info-title"> Shopping behaviour </h4>
        		</div>

        	</div>
        	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-2">
        		<div class="app-partner-item info">
					<div class="icon"><img src="{{ asset('images/design/geography.svg') }}">
                    </div>
					<h4 class="info-title"> Land parcels </h4>
        		</div>

        	</div>
        	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-2">
        		<div class="app-partner-item info">
					<div class="icon"><img src="{{ asset('images/design/energy.svg') }}">
                    </div>		
					<h4 class="info-title"> Light pollution </h4>
        		</div>

        	</div>
        	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-2">
        		<div class="app-partner-item info">
					<div class="icon"><img src="{{ asset('images/design/geography.svg') }}">
                    </div>
					<h4 class="info-title"> Flood maps </h4>
        		</div>
        	</div>
        </div>
		<h1 class="mt-80 mb-20 fs-30 text-bold text-left"> {{ trans('home.new_on_marketplace') }} </h1>
		<div class="row">
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('images/blogs/blog_def.jpg') }}" />
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">Satellite imagery of buildings and roads</h4>
						<h6 class="card-category">Europe</h6>
						<img class="img" src="{{ asset('images/blogs/logo_def.jpg') }}" />
					</div>			
				</div>	
			</div>	
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('images/blogs/blog_def.jpg') }}" />
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">Satellite imagery of buildings and roads</h4>
						<h6 class="card-category">Europe</h6>
						<img class="img" src="{{ asset('images/blogs/logo_def.jpg') }}" />
					</div>			
				</div>	
			</div>	
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('images/blogs/blog_def.jpg') }}" />
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">Satellite imagery of buildings and roads</h4>
						<h6 class="card-category">Europe</h6>
						<img class="img" src="{{ asset('images/blogs/logo_def.jpg') }}" />
					</div>			
				</div>	
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
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('images/blogs/blog_def.jpg') }}" />
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">Satellite imagery of buildings and roads</h4>
						<h6 class="card-category">Europe</h6>
						<img class="img" src="{{ asset('images/blogs/logo_def.jpg') }}" />
					</div>			
				</div>	
			</div>	
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('images/blogs/blog_def.jpg') }}" />
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">Satellite imagery of buildings and roads</h4>
						<h6 class="card-category">Europe</h6>
						<img class="img" src="{{ asset('images/blogs/logo_def.jpg') }}" />
					</div>			
				</div>	
			</div>	
			<div class="col-md-6 col-lg-4 col-xl-4">
				<div class="card card-profile card-plain">
					<div class="card-header">
						<a href="#pablo">
							<img class="img" src="{{ asset('images/blogs/blog_def.jpg') }}" />
						</a>
					</div>
					<div class="card-body text-left">
						<h4 class="card-title">Satellite imagery of buildings and roads</h4>
						<h6 class="card-category">Europe</h6>
						<img class="img" src="{{ asset('images/blogs/logo_def.jpg') }}" />
					</div>			
				</div>	
			</div>	
  		</div>

	    <div class="app-section app-monetize-section align-items-center">
	        <div class="app-monetize-section-item0"></div>
	        <div class="app-monetize-section-item1">
	            <h1 class="fs-30"> {{ trans('home.featured_data_providers') }} </h1>
	            <p>Check out their data offers!</p>
	        </div>
	    </div>
	    <div class="app-partner-items row">
        	<div class="col-md-4 col-lg-2 col-xl-2">
        		<div class="app-partner-item">
					<div class="img">
						<img src="{{ asset('images/blogs/logo_def.jpg') }}">
	                </div>        
        		</div>
        	</div>
        	<div class="col-md-4 col-lg-2 col-xl-2">
        		<div class="app-partner-item">
					<div class="img">
						<img src="{{ asset('images/blogs/logo_def.jpg') }}">
	                </div>        
        		</div>
        	</div>
        	<div class="col-md-4 col-lg-2 col-xl-2">
        		<div class="app-partner-item">
					<div class="img">
						<img src="{{ asset('images/blogs/logo_def.jpg') }}">
	                </div>        
        		</div>
        	</div>
        	<div class="col-md-4 col-lg-2 col-xl-2">
        		<div class="app-partner-item">
					<div class="img">
						<img src="{{ asset('images/blogs/logo_def.jpg') }}">
	                </div>        
        		</div>
        	</div>
        	<div class="col-md-4 col-lg-2 col-xl-2">
        		<div class="app-partner-item">
					<div class="img">
						<img src="{{ asset('images/blogs/logo_def.jpg') }}">
	                </div>        
        		</div>
        	</div>
        	<div class="col-md-4 col-lg-2 col-xl-2">
        		<div class="app-partner-item">
					<div class="img">
						<img src="{{ asset('images/blogs/logo_def.jpg') }}">
	                </div>        
        		</div>
        	</div>
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
						<p class="card-description">{{ $top_usecase->articleTitle??'' }}</p>						
					</div>			
				</div>	
			</div>
			@endforeach	
  		</div>  		
  	</div>  	
</div>
@endsection

