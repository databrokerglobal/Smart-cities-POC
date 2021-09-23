@extends('layouts.app')

@section('title', 'Publish a data offer | Databroker ')
@section('description', 'Ready to monetise your data? You’re in the right place! Publishing a data offer on our marketplace is the perfect way to connect with potential buyers.')

@section('content')
<div class="container-fluid app-wapper data-offer overview">
	<div class="bg-pattern1-left"></div>
    <div class="container">	
		<div class="row">
			<div class="col-lg-6">
				<div class="blog-header mt-60">
		            <h1>{{ trans('pages.publish_data_offer_title') }}</h1>			            
		            <p class="area">{!! trans('pages.publish_data_offer_desc') !!}</p>
		        </div>		        
			</div>
			<div class="col-lg-6 flex-end">
				<a href="{{ route('data_offer_start') }}">
					<button type="button" class="button customize-btn btn-next pull-right">{{ trans('pages.publish_a_data_offer') }}</button>
				</a>	
			</div>
		</div>
		<div class="app-monetize-section-item0 ml-0 mt-20"></div>
		<div class="row">
			<div class="col-lg-6">
				<h2 class="text-bold">{!! trans('pages.advantage_databroker') !!}</h2>	
			</div>			
		</div>	
		<div class="row mt-30">
			<div class="col-lg-6">				
				<div class="number-counter mt-20">
					<span>{!! trans('pages.advantage_databroker_reason1') !!}</span>
				</div>
			</div>	
			<div class="col-lg-6 pl-15">
			{!! trans('pages.advantage_databroker_reason1_desc') !!}
			</div>	
		</div>
		<div class="row mt-30">
			<div class="col-lg-6">				
				<div class="number-counter mt-20">
					<span>{!! trans('pages.advantage_databroker_reason2') !!}</span>					
				</div>
			</div>	
			<div class="col-lg-6 pl-15">
				{!! trans('pages.advantage_databroker_reason2_desc') !!}
			</div>	
		</div>
		<div class="row mt-30">
			<div class="col-lg-6">				
				<div class="number-counter mt-20">
					<span>{!! trans('pages.advantage_databroker_reason3') !!}</span>
				</div>
			</div>	
			<div class="col-lg-6 pl-15">
			{!! trans('pages.advantage_databroker_reason3_desc') !!}
			</div>	
		</div>
	</div>   	
</div>
<div class="container-fluid app-wapper">
	<div class="section_splitor"></div>    
    <div style="background: url({{asset('images/patterns/background_01.png')}});background-position: right;background-repeat: no-repeat;background-size: contain;">
        <div style="background: url({{asset('images/patterns/background_02.png')}});background-position: left;background-repeat: no-repeat;background-size: contain;">
        	<div class="container">
        		<div class="testimonials">
	            	<div class="testimonial">
	            		<p class="content">
	            			“The intersection of blockchain and IoT is a trend we’re seeing more and more as the industry matures. We believe enabling integration with the Databroker platform will enable the Robustel IoT ecosystem to extract massive value from their data and share insights that can improve the quality of IoT solutions world-wide” 
	            		</p>
	            		<p class="author">Yi Huang, Vice President of Robustel</p>
	            	</div>
	            	<div class="testimonial">
	            		<p class="content">
	            			“Thanks to our collaboration with Databroker we enable our customers to sell their data in a secure, traceable and extremely easy way.”
	            		</p>
	            		<p class="author">Joris Huegaerts, Business Area Manager Industry Management and Automation at Phoenix Contact</p>
	            	</div>
	            </div>
        	</div>            
        </div>
    </div>
    <div class="section_splitor"></div>    
</div>

<div class="container-fluid app-wapper">	
	<div class="container">		
		<div class="row">			
        	<div class="col-lg-6">
        		<h3 class="text-bold">Publish your data offer in any of our data communities</h3>
        		<div class="row">
        			@foreach ($communities as $community)
					@php $route = 'data_community.'.$community->slug; @endphp
                        <div class="col-md-4 mt-10 text-bold fs-18">
						<a class="text-black" style="word-break: break-word;" href="{{route($route)}}">{{ $community->communityName }}</a></div>
                    @endforeach  
        		</div>
        	</div>
        	<div class="col-lg-6">
        		<div class="publish_box">
        			<h4 class="text-bold">Are you ready?</h4>
        			<a href="{{route('data_offer_start')}}"><button type="button" class="button customize-btn btn-next mgh25">{{ trans('pages.publish_a_data_offer') }}</button></a>
        			<p class="text-grey text-bold fs-18 mt-10">It’s free!</p>
        			<div class="app-monetize-section-item0 mt-20"></div>

        			<h4 class="text-bold mb-0">Still have questions?</h4>
        			<a class="fs-18 text-green" href="{{route('data_offer_start')}}">Find out how it all works</a>
        			<p class="fs-18">Or contact us for a chat</p>
        			<a href="{{route('contact')}}">
        				<button type="button" class="button secondary-btn w225 mgh25">CONTACT US</button>
        			</a>
        		</div>
        	</div>
        </div>
	</div>                    
</div>


@endsection

@section('additional_javascript')
@endsection

