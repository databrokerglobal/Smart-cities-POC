@extends('layouts.app')

@section('title','Publishing a data offer | How it works | Databroker ')

@section('additional_css')
@endsection

@section('content')
<div class="container-fluid app-wapper data-offer overview">
	<div class="bg-pattern1-left"></div>
    <div class="container mb-40">	
		<div class="row">
			<div class="col-lg-6">
				<div class="blog-header mt-60">
		            <h1 class="text-primary text-bold">It looks like it’s the first time you’re publishing a data offer.</h1>
		        </div>		        
			</div>			
		</div>
		<div class="app-monetize-section-item0 ml-0 mt-20"></div>
		<div class="row">
			<div class="col-lg-6">
				<h3 class="text-bold">Here’s a quick overview of how it all works.</h3>	
			</div>			
		</div>	
		<div class="row mt-30">
			<div class="col-lg-6 publish_start">				
				<div class="mt-20">
					<h3 class="text-bold"><span class="fs-30">1. </span> The data offer: A data offer is a high-level description of data you want to sell</h3>
					<p class="fs-18">Whether you already know exactly which data you want to monetise, or just want to engage with potential buyers and find out what they need, a data offer gives you the opportunity to attract interest and convey the value of your data. 

					You can publish as many data offers as you like, but to be able to actually sell data, there are TWO more steps you need to take.</p>
				</div>
				<div class="mt-20">
					<h3 class="text-bold"><span class="fs-30">2. </span> The data products: You can add defined data products to a particular data offer at any time</h3>
					<p class="fs-18">To be able to sell your data, you need to define data products. You can add (or remove) data products to a data offer at any time, and as soon as you publish them, they’ll be visible to buyers.

					However, to make them available for purchase, there’s ONE more step you need to take.</p>
				</div>
				<div class="mt-20">
					<h3 class="text-bold"><span class="fs-30">3. </span> The DXC</h3>
					<p class="fs-18">A key feature of Databroker is that your data never touches our systems. Instead, data is safely and securely transferred directly from your system to the buyer. For this to happen, you need to install a small piece of software, known as a Data eXchange Controller (DXC), in your system. 

					By using unique IDs for each data product, the DXC ‘opens’ a gateway allowing the buyer to access only the data product they have purchased from you.</p>
				</div>

				<a href="{{ route('data_offer_provider') }}">
					<button type="button" class="btn customize-btn btn-next">OK, LET’S CONTINUE</button>
				</a>	
			</div>	
			<div class="col-lg-2">				
			</div>
			<div class="col-lg-4">				
				<div class="publish_box">
        			<h3 class="text-bold">More questions? </h3>        			
        			<p class="text-grey text-bold fs-18 mt-10">Check out our page on selling data in the <a href="{{ route('help.overview') }}">Help & support centre.</a></p>        			
        		</div>
			</div>	
		</div>		
	</div>   	
</div>

@endsection

@section('additional_javascript')
@endsection

