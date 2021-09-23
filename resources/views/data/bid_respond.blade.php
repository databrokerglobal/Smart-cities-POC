@extends('layouts.data')

@section('title', 'Respond to bid | Databroker ')

@section('content')
<div class="container-fluid app-wapper app-bids-wapper">
	<div class="bg-pattern1-left"></div>
    <div class="container">
    	<div class="app-section app-reveal-section align-items-center">    		
	        <div class="blog-header">
	            <h1>You have received a bid from {{$bidObj['companyName']}}</h1>
	            <p class="para text-bold">{{date("d/m/Y - H:i", strtotime($bidObj['createdAt']))}}</p>
	            <p class="para text-green">{{$bidObj['firstname']." ".$bidObj['lastname']}}</p>
	        </div>
	        <div class="blog-content">
	        	<table>
	        		<tbody>
	        			<tr>
	        				<td><div class="info-label">{{ trans('data.bid_related_to_data_product') }}: </div></td>
		                    <td><div class="col info-text">{{$bidObj['productTitle']}}</div></td>
		                </tr>
	        			<tr>
	        				<td><div class="info-label">{{ trans('data.format') }}: </div></td>
		                    <td><div class="col info-text">{{$bidObj['productType']}}</div></td>
		                </tr>
	        			<tr>
	        				<td><div class="info-label">{{ trans('data.price') }}: </div></td>
		                    <td>
		                    	<div class="col info-text text-red">
		                    	@if($bidObj['productBidType']=="bidding_only"){{ "N/A" }}
		                    	@elseif($bidObj['productBidType']=="free") {{ "Free" }}
		                    	@else € {{$bidObj['actualProductPrice']}}(tax incl.)
		                    	@endif
		                		</div>
		                	</td>
		                </tr>
	        			<tr>
	        				<td><div class="info-label">{{ trans('data.access_to_this_data') }}: </div></td>
		                    <td><div class="col info-text">1 {{$bidObj['accessDays']}}</div></td>
		                </tr>
	        		</tbody>
	        	</table>
	        	<div class="mt-20 row">
	        		<div class="col-md-6 auth-section">
	        			<form method="POST" action="{{route('data.bid_send_response', ['bid'=>$bidObj['bidIdx']])}}">
                        	@csrf
	        				<input type="hidden" name="bidIdx" value="{{$bidObj['bidIdx']}}">
	        				<input type="hidden" name="productIdx" value="{{$bidObj['productIdx']}}">
			        		<h4 class="fs-20 text-bold">{{trans('data.bid_amount')}}: <span class="text-red">€ {{$bidObj['bidPrice']}}</span></h4>
			        		<div class="radio-wrapper">
			        			<label class="container para">{{trans('data.accept_bid')}}
			        				<input type="radio" name="response" value="1">
									<span class="checkmark"></span>
			        			</label>
			        			<label class="container para">{{trans('data.reject_bid')}}
			        				<input type="radio" name="response" value="-1">
									<span class="checkmark"></span>
			        			</label>
			        			@error('response')
			        			<span class="invalid-feedback respond">{{$message}}</span>
			        			@enderror
			        		</div>
			        		<label class="pure-material-textfield-outlined">
								<textarea name="bidResponse" class="form-control input_data user-message @error('bidResponse') is-invalid @enderror" placeholder="{{ trans('data.add_message_optional') }}" maxlength="1000" autofocus>{{ old('bidResponse')}}</textarea>
								<div class="error_notice">{{ trans('validation.required', ['attribute' => 'Message']) }}</div>
		                        @error('bidResponse')
		                            <span class="invalid-feedback" role="alert">
		                                <strong>{{ $message }}</strong>
		                            </span>
		                        @enderror
							</label>
							<div class="form-group mb-0">                                
		                        <button type="submit" class="customize-btn">{{ trans('data.continue') }}</button>
		                    </div>
		                </form>
	                </div>
	        	</div>
	        </div>
	    </div>
	</div>
</div>
@endsection	
