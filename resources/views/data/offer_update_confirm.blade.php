@extends('layouts.app')

@section('title', 'Data offer updated | Databroker')

@section('content')
<div class="container-fluid app-wapper data-offer confirm mgh25">
	<div class="bg-half-watermark-right-left">
		<div class="bg-half-watermark w-right"></div>
		<div class="bg-half-watermark w-left"></div>
	</div>
    <div class="container flex-vcenter">	
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<div class="blog-header">
		            <div class="h1-big text-center color-blue">Your data offer {{$title}} has been updated.</div>
		        </div>		        
		        <div class="blog-content">
		            <div class="h2">You can access it via the <a href="{{route('data_offers_overview')}}">My data offers & products</a> section of your account and edit it any time.</div>
		            <p class="para"><b>IMPORTANT</b>: To be able to sell or share data related to this data offer, you need to create specific data products. You can do this now, or at any time, via the <a href="{{route('data_offers_overview')}}">My data offers and products</a> section of your account.</p>
		            <div class="flex-center mgt30">
		            	<a href="{{$link_to_market}}"><button class="primary-btn mgr30">VIEW ON THE MARKETPLACE</button></a>
		            	<a href="{{route('data_offer_add_product', ['id'=>$offerId])}}"><button class="secondary-btn">ADD DATA PRODUCTS NOW</button></a>
		            </div>
		        </div>
			</div>
		</div>
	</div>   	
</div>

@endsection

@section('additional_javascript')
@endsection

