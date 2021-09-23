@extends('layouts.data')

@section('title', 'Configure stream | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="app-section app-reveal-section align-items-center">
        	<div class="row blog-header">
                <div class="col-md-12">
                	<h1>Configure stream details</h1>
        			<p class="para fs-20 text-bold">{{$product->productTitle}}</p>
                	<p class="para fs-16">
                        @foreach($product->region as $key=>$region)
                            {{$region->regionName}}
                            @if(count($product->region)>$key+1)
                            <span>,</span>
                            @endif
                        @endforeach
                    </p>
                </div>
    		</div>
            <div class="app-monetize-section-item0 ml-0 mt-20"></div>
            <div class="blog-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mt-20">
                            <div class="col-md-12">
                                <form method="POST" action="{{route('data.save_stream')}}">
		                        	@csrf
		                        	<input type="hidden" name="streamIdx" value="{{isset($stream)? $stream->streamIdx : 0}}">
		                        	<input type="hidden" name="purchaseIdx" value="{{$product->purchaseIdx}}">
		                        	<div class="row">
		                        		<div class="col-md-6">
		                        			<label class="pure-material-textfield-outlined">
						                        <input type="text" id="IP" name="IP" class="form-control2 input_data" placeholder=" "  value="{{isset($stream) ? $stream->IP : old('IP')}}">
						                        <span>{{ trans('data.stream_ip') }}</span>	                        
				                   				<div class="error_notice IP"></div>
				                   				@error('IP')
							        			<span class="invalid-feedback IP">
							        				<strong>{{$message}}</strong>
							        			</span>
							        			@enderror
						                    </label>
		                        		</div>
		                        		<div class="col-md-6">
		                        			<label class="pure-material-textfield-outlined">
						                        <input type="text" id="port" name="port" class="form-control2 input_data" placeholder=" "  value="{{isset($stream) ? $stream->port : old('port')}}">
						                        <span>{{ trans('data.stream_port') }}</span>	                        
						                   		<div class="error_notice port"></div>
						                   		@error('port')
							        			<span class="invalid-feedback port">
							        				<strong>{{$message}}</strong>
							        			</span>
							        			@enderror
							                </label>
		                        		</div>
		                        	</div>
									<div class="form-group mt-30">
				                        <button type="submit" class="customize-btn">{{ trans('data.save') }}</button>
				                    </div>
								</form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 flex-column align-items-center">
                    	<div class="row">
                            <div class="col-md-12">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.from') }}: </div></td>
                                            <td><div class="col info-text">{{$company}}</div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.format') }}: </div></td>
                                            <td><div class="col info-text">{{$product->productType}}</div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.price') }}: </div></td>
                                            <td>
                                                <div class="col info-text">
                                                    @if($product->productBidType=="free")
                                                    <span class="text-red">Free</span>
                                                    @else
                                                    <span class="text-red">€ {{$product->bidPrice!=0 ? $product->bidPrice : $product->productPrice}}</span> (tax incl.)
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.access_to_this_data') }}: </div></td>
                                            <td>
                                                <div class="col">
                                                    <span class="info-text">1 {{$product->productAccessDays}}</span>
                                                    <span class="fs-14"> ( From : {{date('d/m/Y', strtotime($product->from))}} until {{date('d/m/Y', strtotime($product->to))}} )</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="fs-16">{{$product->offerDescription}}</p>
		                        <div class="mt-20">
		                            <span class="info-label">{{trans('data.api_key')}}:</span>
		                            <span class="info-text" id="uniqueId">{{$product->apiKey}}</span>
		                            <span class="copy-id"><a class="link-market" id="copyToClipboard">Copy key</a></span>
		                        </div>
		                        <div class="mt-20">
		                            <span class="info-label fs-10">Transaction ID:</span>
		                            <span class="info-label fs-10">{{$product->transactionId}}</span>
		                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/inputmask.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.inputmask.js') }}"></script>
    <script type="text/javascript">
    	$("input[name='IP']").inputmask({'mask': "999.999.999.999"});
    </script>
@endsection