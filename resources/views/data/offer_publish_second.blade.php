@extends('layouts.app')

@section('title', 'Publishing a data offer | Databroker ')

@section('additional_css')
@endsection

@section('content')
<div class="container-fluid app-wapper data-offer overview">
	<div class="bg-pattern1-left"></div>
    <div class="container mb-40">	
		<div class="row">
			<div class="col-lg-6">
				<div class="blog-header mt-60">
		            <h1 class="text-primary text-bold">Publishing your data offer</h1>		            
		        </div>		        
			</div>			
		</div>
		<div class="app-monetize-section-item0 ml-0 mt-20"></div>
		<div class="row">
			<div class="col-lg-6">
				<h3 class="text-bold">Our step-by-step wizard guides you through the four steps of publishing a data offer:</h3>	
			</div>			
		</div>	
		<div class="row mt-30">
			<div class="col-lg-6 publish_start">				
				<div class="mt-20">
					<h3 class="text-bold"><span class="fs-30">1. </span> Basic information about your data offer (mandatory)</h3>
					<p class="fs-18">Give a concise description of the data, indicate which region it covers, and select which of our 8 data communities it should be categorised in. <br>
					To make your data offer as attractive as possible, you can also upload an image from your own computer or from our image database.
					</p>
				</div>
				<div class="mt-20">
					<h3 class="text-bold"><span class="fs-30">2. </span> More details about your data (optional but recommended)</h3>
					<p class="fs-18">Explain the main characteristics of your data offer to help potential buyers decide whether or not your data is what they are looking for. <br>
					For example, you might want to explain how the data is collected, whether or not it requires special processing etc.</p>
				</div>
				<div class="mt-20">
					<h3 class="text-bold"><span class="fs-30">3. </span> Use cases (optional but recommended)</h3>
					<p class="fs-18">Add some typical use cases for your data. These can help potential buyers understand how your data could solve challenges and enrich their business. </p>
				</div>
				<div class="mt-20">
					<h3 class="text-bold"><span class="fs-30">4. </span> Examples (optional but recommended)</h3>
					<p class="fs-18">Uploading some screenshots or other visual representations of the data can help potential buyers better understand the quality and relevance what you are offering. </p>
					<p class="fs-18 mt-30">Done? Your offer is live on the marketplace!</p>
				</div>
				<a href="{{ route('data_offers') }}">
					<button type="button" class="btn customize-btn btn-next">START</button>
				</a>	
			</div>	
			<div class="col-lg-2">				
			</div>
			<div class="col-lg-4">				
				<div class="publish_box">
        			<h3 class="text-bold">Good to know</h3>
        			<p class="text-grey fs-18 mt-10">You can publish data offers and products even before you are technically ready to actually start selling or sharing data i.e. have set up the Data eXchange Controller.</p>
        			<p class="text-grey fs-18 mt-10">You can edit the details of your data offer at any time, and even unpublish temporarily if you need to.</p>
        		</div>
			</div>	
		</div>		
	</div>   	
</div>

@endsection

@section('additional_javascript')
@endsection

