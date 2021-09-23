@extends('layouts.app')

@section('title', 'My data offers & products | Databroker')
@section('description', '')

@section('additional_css')
@endsection

@section('content')
<div class="container-fluid app-wapper data-offer overview">
	<div class="bg-pattern1-left"></div>
    <div class="container">	
		<div class="row mb-20">
			<div class="col-lg-6">
				<div class="blog-header mt-60">
		            <h1>{{ trans('pages.Data_offers_overview') }}</h1>			            
		            <p class="para">Here you can find an overview of all your data offers. To see individual data products, or to add products to a data offer, click on the relevant data offer.</p>
		            <p class="para">Need help with adding new data offers and products, and on installing the API needed to transfer data to other parties? Check out our <a href="{{ route('help.buying_data') }}" class="help-section">{{ trans('pages.help_section') }}</a></p><!-- #60 Selling data Help_buying/selling -->
		        </div>		        
			</div>
			<div class="col-lg-6">
				<a href="{{ route('data_offer_start') }}"><button type="button" class="customize-btn btn-next pull-right">{{ trans('pages.PUBLISH_NEW_DATA_OFFER') }}</button></a>
			</div>
		</div>
		<div class="gridview col2" id="23">			
			@foreach ($offers as $offer)			
				<a class="cell offer @if ($offer['status'] == 1) {{ 'active' }} 
					@endif" href="{{env('APP_URL')}}/data/offers/{{$offer['offerIdx']}}">
					<span class="iconify right-arrow" data-icon="bx:bx-right-arrow-alt" data-inline="false"></span>
					<p class="offer-title">{{$offer['offerTitle']}}</p>
					<p class="offer-location region">
						@foreach($offer['region'] as $region)
		            		<span>{{ $region->regionName }}</span>
		            	@endforeach
		            </p>
					<span class="offer-products"> 
					@if(isset($offer['offerproduct']) && $offer['offerproduct']->product_count > 0)
					<span class="label">{{ trans('pages.data_products') }}: </span>{{ $offer['offerproduct']->product_count }}
					@else
					<span class="label">{{ trans('pages.data_products') }}: </span>none added yet
					@endif
					</span><br>					
					<!-- <span class="label">{{ 'Offer Type' }}: </span> {{ $offer['offerType']}} </span> -->
				</a>
			@endforeach

		</div>
	</div>      
</div>

@endsection


@section('additional_javascript')
@endsection

