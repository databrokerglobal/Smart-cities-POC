@extends('layouts.data')

@section('title', 'Send a bid | Databroker ')

@section('content')
<div class="container-fluid app-wapper app-bids-wapper">
	<div class="bg-pattern1-left"></div>
    <div class="container">
    	<div class="app-section app-reveal-section align-items-center">    		
	        <div class="blog-header">
	            <h1>Send a bid to {{$provider->companyName}}</h1>
	            <p class="para text-bold">{{$product->productTitle}}</p>
	            <p class="para">
	            	@foreach($product['region'] as $key=>$region)
	            		<span>{{$region->regionName}}</span>
	            		@if(count($product['region'])>$key+1)
	            		<span>, </span>
	            		@endif
	            	@endforeach
	            </p>
	        </div>
	        <div class="blog-content">
	        	<div class="para text-red">
	        	@if($product->productBidType=="bidding_only")
	        		<span>N/A</span>
	        	@elseif($product->productBidType=="free")
	        		<span>FREE</span>
	        	@else
	        		<span>€ {{$ppmapping->productPrice}}</span>
	        	@endif
	        	</div>
	        	<div class="para">
	        		<span class="text-grey">{{ trans('data.access_to_this_data') }}: </span>
	        		<span>1 {{$ppmapping->productAccessDays}}</span>
	        	</div>
	        	<div class="para">
	        		<span class="text-grey">{{ trans('data.format') }}: </span>
	        		<span>{{$product->productType}}</span>
	        	</div>
	        	<div class="row mt-30">
	        		<div class="col-md-6 auth-section">
	        			<form method="POST" action="{{route('data.send_bid', ['id'=>$product->offerIdx, 'pid'=>$product->productIdx])}}">
                        	@csrf
                        	<input type="hidden" name="offerIdx" value="{{$product->offerIdx}}">
                        	<input type="hidden" name="productIdx" value="{{$product->productIdx}}">
                        	<input type="hidden" name="companyName" value="{{$provider->companyName}}">
							<input type="hidden" name="actualProductPrice" value="{{$ppmapping->productPrice}}">
							<input type="hidden" name="productAccessDays" value="{{$ppmapping->productAccessDays}}">
		        			<label class="pure-material-textfield-outlined currency-input">
		        				<span class="currency">€</span>
		                        <input type="number" id="bidPrice" step="1" min='1' max="999999999" placeholder="1.00" name="bidPrice" class="form-control input_data price_input @error('bidPrice') is-invalid @enderror" placeholder=""  value="{{ old('bidPrice') }}" autofocus>
		                        <div class="error_notice mt-10">Bid price should be higher than €1</div>
		                        <span class="invalid-feedback" role="alert">
		                        @error('bidPrice')
		                            <strong>{{ $message }}</strong>
		                        @enderror
		                        </span>
		                    </label>
		                    <label class="pure-material-textfield-outlined">
								<textarea name="bidMessage" class="form-control input_data user-message @error('bidMessage') is-invalid @enderror" placeholder="{{ trans('data.add_message_optional') }}" maxlength="1000" autofocus>{{ old('bidMessage')}}</textarea>
								<div class="error_notice">{{ trans('validation.required', ['attribute' => 'Message']) }}</div>
		                        @error('bidMessage')
		                            <span class="invalid-feedback" role="alert">
		                                <strong>{{ $message }}</strong>
		                            </span>
		                        @enderror
							</label>
							<div class="form-group mb-0">                                
		                        <button type="submit" class="customize-btn">{{ trans('data.send_bid') }}</button>
		                    </div>
						</form>
	        		</div>
	        		<div class="col-md-6">
	        			<div class="pl-30">
		        			<p class="para text-bold">How it works</p>
		        			<ul class="custom-list">
		        				<li>Your bid is sent directly to the data provider, who also sees your name and your company It is not published on the marketplace.</li>
		        				<li>The data provider can accept or reject your bid. When they do, you’ll receive an email with their response.</li>
		        				<li>Bids are not binding, so even if the data provider accepts your bid, you can still decide whether or not to buy the data at the agreed price.</li>
		        			</ul>
		        			<p class="para">Remember that you can follow up on your bids in the <a href="{{route('profile.buyer_bids')}}">Bids sent</a> section of your account.</p>
		        		</div>
	        		</div>
	        	</div>
	        </div>
	    </div>
	</div>
</div>
@endsection	

@section('additional_javascript')
<script type="text/javascript">
	$('input[name="bidPrice"]').on('input', function(){
		if(parseFloat($(this).val())<1 || !(parseFloat($(this).val())>=0))
			$(this).parent().find('.invalid-feedback').html("<strong>Bid price should be higher than €1</strong>");
		else $(this).parent().find('.invalid-feedback').html("");
	})
</script>
@endsection