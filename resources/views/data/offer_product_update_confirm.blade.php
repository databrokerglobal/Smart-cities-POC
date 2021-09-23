@extends('layouts.app')

@section('title', 'Your data product has been updated | Databroker')

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
		            <div class="h1-big text-center">Your data product {{ $productTitle }} for {{ $offerTitle }} has been updated successfully.</div>
		        </div>		        
		        <div class="blog-content text-center">
		            <!-- <div class="h3 mgt30">There is still some action required from you before you can sell the data.</div>
		            <div class="para mgt30">To enable selling, go to the Data Exchange Controller and declare this data product using this ID.</div>
		            <div class="mgt30">
						<div class="user-id">
							<span class="label">{{ trans('pages.id') }} :</span>
							<span id="uniqueId">{{$uniqueId}}</span>
						</div>
						<div class="copy-id"><a class="link-market" id="copyToClipboard">{{trans('pages.Copy_ID')}}</a></div>
					</div> -->
		            <div class="flex-center mgt30">
		            	@php
							$companyName = $offer['company_slug'];
							$title = $offer['offer_slug'];
							$region = "";
							foreach($offer['region'] as $key=>$r){
								$region = $region .$r->slug;
								if($key+1 < count($offer['region'])) $region = $region . "-";
							}
						@endphp
		            	<a href="{{ route('data_offer_detail', ['id' => $id]) }}"><button class="primary-btn mgr30">GO TO DATA PRODUCT IN YOUR ACCOUNT</button></a>
		            	<a href="{{ route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region]) }}"><button class="secondary-btn">VIEW DATA PRODUCT ON THE MARKETPLACE</button></a>
		            </div>
		        </div>
			</div>
		</div>
	</div>   	
</div>

@endsection

@section('additional_javascript')
@endsection

