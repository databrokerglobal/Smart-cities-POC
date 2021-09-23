@extends('layouts.app')
@php
$regionName = '';
@endphp
@foreach($offer['region'] as $region)
		@php
		$regionName = $region->regionName;
		@endphp
@endforeach

@section('title')
{{ "Get ". $offer['offerTitle']." from ". $offer['provider']->companyName." for ". $regionName." | Databroker" }}
@stop

@section('description', 'Looking for '. $offer['offerTitle']. ' in '.$offer['community']->communityName. '? '.$offer['provider']->companyName. ' share this data on databroker ('.$regionName.')')

@section('content')
<div class="container-fluid app-wapper">
	<div class="bg-pattern1-left"></div>
    <div class="container">    	
    	<div class="app-section app-reveal-section align-items-center data-detail">     		
    		@if($prev_route)
    		<a href="{{ route($prev_route) }}" class="back-icon text-grey"><i class="material-icons">keyboard_backspace</i><span>Back</span></a>
    		@endif
	        <div class="blog-header">
	            <h1>Get {{ $offer['offerTitle'] }} from {{$offer['provider']->companyName}} on Databroker {{$offer['community']->communityName}}</h1>	

				<p class="area">
					@php 
					$offerRegions = '';					
					@endphp
	            	@foreach($offer['region'] as $region)
					@php $offerRegions .= $region->regionName.', '; @endphp
	            		<span>{{ $region->regionName }}</span>
	            	@endforeach
	            </p>
				@php
				$offerImgAltTxt = $offer['offerTitle'].' from '. $offer['provider']->companyName.' in '.$offer['community']->communityName;
				if(!empty($offerRegions)){
				$offerImgAltTxt .= ' ('.rtrim($offerRegions,', ').')';
				}
				@endphp
	            <p class="category"> Published in : 
				@php $route = 'data_community.'.$offer->community->slug; @endphp
				<a href="{{route($route)}}" >
				{{ $offer['community']->communityName }} </a>
	            	<label>		            	
		            	@foreach($offer['theme'] as $theme)
		            		<a href="{{route('data.offer_theme_filter', ['community'=>$offer['community']->slug, 'theme'=>str_replace( ' ', '-', strtolower($theme->themeName))])}}"><span>{{ $theme->themeName }}</span></a>
		            	@endforeach
	            	</label>
	            </p>
	        </div>	        
	        <div class="blog-content">
	        	<div class="row">
	        		<div class="col-lg-8">			
						
						@if( file_exists(public_path().$offer['offerImage']) && $offer['offerImage'] )
							<img class="img" style="max-width:100%" alt="{{$offerImgAltTxt}}" title="{{$offerImgAltTxt}}" src="{{asset($offer['offerImage'])}}" />
						@else
								<img class="img" style="max-width:100%" alt="{{$offerImgAltTxt}}" title="{{$offerImgAltTxt}}"  src="{{ asset('uploads/offer/default.png') }}" />
						@endif
			            <div class="nav-tabs-wrapper mt-30">
			                <ul class="nav nav-tabs">
			                	@if( $offer['offerDescription'])
			                    <li class="nav-item">
			                        <a class="nav-link active" href="#description">{{ trans('pages.description') }}</a>
			                    </li>
			                    @endif
			                    @if( $offer['usecase'] )
			                    <li class="nav-item">
			                        <a class="nav-link" href="#use_cases">{{ trans('pages.use_case') }}</a>
			                    </li>
			                    @endif
			                    @if( sizeof($offersample) >0 )
			                    <li class="nav-item">
			                        <a class="nav-link" href="#samples">{{ trans('pages.samples') }}</a>
			                    </li>
			                    @endif				                    
			                    @if( sizeof($products ) > 0 )
			                    <li class="nav-item">
			                        <a class="nav-link" href="#this_data">{{ trans('pages.buy_this_data') }}</a>
			                    </li>
			                    @endif
			                </ul>
			            </div>				        
				        <div class="link-content">
							@if( $offer['offerDescription'] )
							<p class="mobile-scrolling" id="description"></p>
				            <div class="link-box" id="description">
				            	<h3>{{ trans('pages.description') }}</h3>
				                <p>{!! nl2br($offer['offerDescription']) !!}</p>
				                <div class="region">
				                	<label>{{ trans('pages.region') }}: </label> 
				                	<span>
				                		@foreach($offer['region'] as $key=>$region)
						            		<a href="{{route('data.offer_region_filter', ['community'=>str_replace( ' ', '_', strtolower($offer['community']->communityName)), 'regionName'=>str_replace( ' ', '-', strtolower($region->regionName))])}}">{{ $region->regionName }}</a>
						            		@if($key+1 < count($offer['region'])) 
						            		<span></span>
						            		@endif
						            	@endforeach
				                	</span>
				                </div>
				            </div>
				            @endif
							@if( $offer['usecase'] )
							<p class="mobile-scrolling" id="use_cases"></p>
				            <div class="link-box" id="use_cases">
				                <h3>{{ trans('pages.use_case') }}</h3>
				                @if( $offer['usecase'] )
				                <p>{!! nl2br($offer['usecase']->useCaseContent) !!}</p>
				                @endif
				            </div>
				            @endif
							@if( sizeof($offersample)>0 )
							<p class="mobile-scrolling" id="samples"></p>
				            <div class="link-box" id="samples">
				                <h3>{{ trans('pages.samples') }}</h3>				               
				                @foreach($offersample as $sample)
				                	@if( explode("-", $sample['sampleType'])[0] == 'file')
				                	<div class="file">
				                		<p>{{$sample['sampleDescription']}}</p>
				                		<a class="download" href="{{ asset('uploads/offersample/'.$sample['sampleFileName']) }}" target="_blank"><i class="material-icons">get_app</i><span>{{$sample['sampleFileName']}}</span></a>
				                	</div>	
				                	@endif					                	
				                	@if( explode("-", $sample['sampleType'])[0] == 'image')				                	
				                		<div class="image">				
				                			@if( file_exists(public_path() . '/uploads/offersample/'.$sample['sampleFileName']) && $sample['sampleFileName'] )	
					                		<img alt="{{$offerImgAltTxt}}" title="{{$offerImgAltTxt}}" src="{{ asset('uploads/offersample/'.$sample['sampleFileName']) }}">
					                		@else
					                		<img alt="{{$offerImgAltTxt}}" title="{{$offerImgAltTxt}}" class="img" src="{{ asset('uploads/default.png') }}" />
					                		@endif
					                		<p>{{$sample['sampleDescription']}}</p>
				                		</div>
				                	@endif				                	
				                @endforeach				               
				            </div>
				            @endif
							@if( sizeof($products ) > 0 )
							<p class="mobile-scrolling" id="this_data"></p>
				            <div class="link-box" id="this_data">
				                <h3>Buy data</h3>
				                <p>If the data provider has already defined data products that can be purchased
								  directly, you’ll find these below. When you buy a data product, you’ll 
								  receive an email link to access or download the data.
								  <br/><br/>This link will also be available in the Purchases section of your account. 
								<br/><br/>If you don’t see the data you need below, you can contact the data provider directly to request specific data.
								</p>

				                <div class="buy_lists">
				                	@foreach($products as $product)
				                	<div class="buy_list">				                		
				                		<div class="row">
				                			<div class="col col-md-7 col-12">
					                			<div class="text-left">
						                			<h2>{{$product->productTitle}} {{(count($product['region'])>0) ? '|' : ''}}
														@foreach($product['region'] as $region)
					            							<span>{{ $region->regionName }}</span>
					            						@endforeach
													</h2>
						                			<p><label class="text-grey">{{ trans('pages.format') }} : </label> <span>{{ $product->productType }}</span></p>
						                			@if($product->productMoreInfo)
						                			<a href="javascript:;" id="more_info" class="dropdown-toggle" data-toggle="dropdown" aaria-haspopup="true" aria-expanded="false">More Info</a>
						                			<div class="dropdown-menu more_info" aria-labelledby="more_info">
						                				<p class="pd-15">{{ $product->productMoreInfo }}</p>
						                			</div>
						                			@endif
						                		</div>
						                	</div>
						                	<div class="col col-md-5 col-12">
						                		<div >
							                			@if($product->productBidType=="free")
							                			<p class="price">FREE</p>
						                				@elseif(!$product->dxc || !$product->did || !$product->did_available)
						                				<p class="price">Soon available for buying  </p>
							                			@elseif($product->productBidType=="bidding_only")
							                			<p class="price">Make your best bid</p>
							                			@else
														
							                			<p class="price"><span class="currency">€</span><span id="price_<?=$product['productIdx']?>"><?=isset($product['productpricemappings'][0])?$product['productpricemappings'][0]['productPrice']:''?></span> <span class="color-black">(tax incl.)</span></p>
							                			@endif
														<div style="display:flex;">
															<div class="col-md-6">
															<label>{{ trans('pages.access_to_data') }} : </label>
															</div>
															<div class="col-md-6">
																<div class="form-group">					
																	<select class="form-control" onchange="setPircePeriod(this,'period',<?=$product['productIdx']?>)" id="period_<?=$product['productIdx']?>">
																		@foreach($product['productpricemappings'] as $key => $mapping)
																			<option value="<?=$mapping->ppmIdx?>_<?=$mapping->productPrice?>">1 {{$mapping->productAccessDays}}</option>
																		@endforeach
																	</select>										
																</div>
															</div>
														</div>
							                			<!-- <p class="expiry"> <span>1 {{ $product->productAccessDays }}</span></p> -->
						                		</div>	
						                	</div>
				                		</div>	 
			                			<div class="product_actions">
					                			@if($product->productBidType == 'free')
												
													@if(isset($product['productpricemappings'][0]))
														<a href="{{route('data.get_data', ['id'=>$id, 'pid'=>$product->productIdx,'expiredate'=>'na',
																'ppmid'=>$product['productpricemappings'][0]['ppmIdx']])}}">
															<button type="button" class="customize-btn my-0">GET DATA</button>
														</a>
													@else
														<a href="{{route('data.get_data', ['id'=>$id, 'pid'=>$product->productIdx,'expiredate'=>'na','ppmid'=>'na'])}}">
															<button type="button" class="customize-btn my-0">GET DATA</button>
														</a>
													@endif
			                					@elseif(!$product->dxc || !$product->did || !$product->did_available)
			                					<a href="{{route('data.send_message', ['id'=> $offer['offerIdx']])}}">
					                				<button type="button" class="customize-btn my-0">CONTACT SELLER</button>
					                			</a>
					                			@elseif($product->productBidType == 'no_bidding')
													@foreach($product['productpricemappings'] as $mapkey => $mapping)
														<a style="display:<?=($mapkey == 0)?'block':'none'?>" id="buy_<?=$mapping->ppmIdx?>" class="buy_now_<?=$product['productIdx']?>" 
															href="{{route('data.buy_data', ['id'=>$id, 'pid'=>$product->productIdx,'ppmid' => $mapping->ppmIdx,'expiredate'=>'na'])}}">
															<button type="button" class="customize-btn my-0">BUY NOW</button>
														</a>
													@endforeach												
					                			@elseif($product->productBidType == 'bidding_only')
													@if(isset($product['productpricemappings'][0]))
														
														<a href="{{route('data.bid', ['id'=>$id, 'pid'=>$product->productIdx,'ppmid'=>$product['productpricemappings'][0]['ppmIdx']])}}">
															<button type="button" class="customize-btn my-0">SEND BID</button>
														</a>
													@else
														<a href="{{route('data.bid', ['id'=>$id, 'pid'=>$product->productIdx,'ppmid'=>'na'])}}">
															<button type="button" class="customize-btn my-0">SEND BID</button>
														</a>
													@endif
					                			
					                			@elseif($product->productBidType == 'bidding_possible')
					                			
												@foreach($product['productpricemappings'] as $mapkey => $mapping)
														<a style="display:<?=($mapkey == 0)?'block':'none'?>" id="bid_<?=$mapping->ppmIdx?>" class="bid_now_<?=$product['productIdx']?>"
															 href="{{route('data.bid', ['id'=>$id, 'pid'=>$product->productIdx,'ppmid' => $mapping->ppmIdx])}}">
															<button type="button" class="customize-btn my-0">SEND BID</button>
														</a>
														<a style="display:<?=($mapkey == 0)?'block':'none'?>" id="buy_<?=$mapping->ppmIdx?>" class="buy_now_<?=$product['productIdx']?>" 
															href="{{route('data.buy_data', ['id'=>$id, 'pid'=>$product->productIdx,'ppmid' => $mapping->ppmIdx,'expiredate'=>'na'])}}">
															<button type="button" class="customize-btn my-0">BUY NOW</button>
														</a>
												@endforeach	
					                			<br>
				                				@endif
			                			</div>			                		
				                	</div>
				                	@endforeach				                	

				                	<div class="row">
				                		<div class="cta_box col-12">
						        			<h3 class="text-bold">Questions about this data? </h3>
											<p class="fs-18">Or want to request specific data from this provider?</p>
						        			<a href="{{route('data.send_message', ['id'=> $offer['offerIdx']])}}">
						        				<button type="button" class="secondary-btn mgh25">CONTACT THE DATA PROVIDER</button>
						        			</a>
						        		</div>
				                	</div>
				                </div>
				            </div>
				            @endif
				        </div>
	        		</div>

	        		<div class="col-lg-4">
	        			<h2 class="explain">Data provided by {{ $offer['provider']->companyName }}</h2>
	        			<h5 class="subcategory">{{$user_info['businessName']}} Service</h5>
	        			<label class="country">{{ $offer['provider']['region']->regionName }}</label>
	        			@if(preg_match("@^https?://@", $offer['provider']->companyURL))
	        			<label class="author"><a target="_blank" href="{{ $offer['provider']->companyURL }}">{{ $offer['provider']->companyURL }}</a></label>
	        			@else
	        			<label class="author"><a target="_blank" href="https://{{ $offer['provider']->companyURL }}">{{ $offer['provider']->companyURL }}</a></label>
	        			@endif
						<a href="{{route('data.company_offers', ['companyName'=>$user_info->slug])}}">
	        			<div class="author_avatar">	        				
	        				@if( file_exists( public_path() . '/uploads/company/'.$offer['provider']->companyLogo) && $offer['provider']->companyLogo )
	        				<img alt="{{ $offer['provider']->companyName.' ('.$offer['provider']['region']->regionName.')' }} on databroker" title="{{ $offer['provider']->companyName.' ('.$offer['provider']['region']->regionName.')' }} on databroker" src="{{ asset('uploads/company/'.$offer['provider']->companyLogo) }}">
	        				@else
	        				<img alt="{{ $offer['provider']->companyName.' ('.$offer['provider']['region']->regionName.')' }} on databroker" title="{{ $offer['provider']->companyName.' ('.$offer['provider']['region']->regionName.')' }} on databroker" class="img" src="{{ asset('uploads/company/default_medium.png') }}" />
	        				@endif
	        			</div>	 
						</a> 			
	        			<p class="short-desc">
	        				{!! trans('pages.contact_data_provider') !!}
	        			</p>
	        			<a href="{{route('data.send_message', ['id'=> $offer['offerIdx']])}}">
	        				<button  type="button" class="secondary-btn mgh25">CONTACT THE DATA PROVIDER</button>
	        			</a><br/>
	        			<a href="{{route('data.company_offers', ['companyName'=>$user_info->slug])}}">
	        				View more data from {{ $offer['provider']->companyName }}
	        			</a>
	        		</div>
	        	</div>
	        </div>
	    </div>	
	    @if($prev_route)
		<a href="{{ route($prev_route) }}" class="back-icon text-grey"><i class="material-icons">keyboard_backspace</i><span>Back</span></a>
		@endif   
    </div>      
</div>

@endsection

<script>
	function setPircePeriod(ele,type,productIdx){
			
			let det = $(ele).val().split("_");
			console.log(det[1]);
			if(type == 'period'){				
				$('#price_'+productIdx).html(det[1]);				
			}
			if(type == 'price'){				
				$('#period_'+productIdx).htl(det[1]);
			}
			$(".buy_now_"+productIdx).css('display','none');
			$("#buy_"+det[0]).css('display','block');

			$(".bid_now_"+productIdx).css('display','none');
			$("#bid_"+det[0]).css('display','block');
		}
</script>