@extends('layouts.app')

@section('title','Data Exchange Controller')
@section('description','Data Exchange Controller')

@section('additional_css')	
	<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@php
	$max_to_show = 5;
@endphp

@section('content')
<div class="container-fluid app-wapper">	
    <div class="container">    		    
		@if(count($dataoffer) == 0 && count($usecases) ==  0 && count($featured_providers) ==  0)
			<!-- <h4 style='text-align:center;margin-top:5%'>No Result found for search key  <b>"{{ session('curSearchKey')?session('curSearchKey'):'' }}"</b>, please try with other.</h4> -->
			<h4 style='text-align:left;margin-top:5%'>Unfortunately, we could not find any result for your search on <b>'{{ session('curSearchKey')?session('curSearchKey'):'' }}'</b>.
			<br/><br/>
			What you can do:
			<br/>
			<ul>
				<li>Check the spelling of your keyword</li>
				<li>Try alternate words</li>
				<li>You can also browse our data communities to discover data offers (Geographics, Environment, People, Agriculture, Energy, Transport, Economy and Supply Chain)</li>
				<li>Or contact our DataMatch Advisor for help with your search for data  <a href="{{ route('about.matchmaking') }}"> (link to https://www.databroker.global/about/matchmaking)</a></li>			
			</ul>
			</h4>
		@endif
		@if(count($featured_providers) > 0)
				<h1 id="offer-count" class="mb-20 fs-30 text-bold text-left"> Found <span>{{ count($featured_providers) }}</span> Providers for your search key "{{ session('curSearchKey')?session('curSearchKey'):'' }}" </h1>   
				<div id="providers-list" class="mgh30">		
					<div class="row">
						@foreach($featured_providers as $featured_provider)
						<div class="col-md-4 col-lg-2 col-xl-2">
							<div>
								<a href="{{ route('data.company_offers', ['companyName'=>$featured_provider->slug]) }}">
									<div class="app-partner-item">
										<div class="img">
											@if(file_exists(public_path("uploads/company/tiny/".$featured_provider->companyLogo))) 
											<img src="{{ asset('uploads/company/tiny/'.$featured_provider->companyLogo) }}" style="height:75px;">
											@else 
											<img src="{{ asset('uploads/company/default_tiny.png') }}" style="height:75px;">
											@endif
										</div>        
									</div>
								</a>
								<!-- <a href="{{$featured_provider->companyURL}}">{{$featured_provider->companyName}}</a> -->
							</div>
						</div>
						@endforeach
					</div>
				</div>
		@endif
		@if(count($offer_products) > 0)
    	<h1 id="product-count" class="mb-20 fs-30 text-bold text-left"> Found <span>{{ count($offer_products) }}</span> data products for your search key "{{ session('curSearchKey')?session('curSearchKey'):'' }}" </h1>   
    	<div id="product-list">
			<div class="row">
				@php
					$makematching = rand(0, count($offer_products)-1);					
				@endphp
				<?php foreach ( $offer_products as $index => $offer ){					
							if($index > $max_to_show)						
								break; ?>
			
						<div class="col-md-4 mb-20">
							<div class="card card-profile card-plain mb-0">					
								<div class="card-header">
									@php
										$companyName = $offer['company_slug'];
										$title = $offer['offer_slug'];
										$region = "";
										foreach($offer['region'] as $key=>$r){
											$region = $region .$r->slug;
											if($key+1 < count($offer['region'])) $region = $region . "-";
										}
										$alt_text_offer = $offer['offerTitle'].' from '.$offer['companyName']. ' in '. $region;								
										$alt_text_provider = $offer['companyName']. ' on '.APPLICATION_NAME;
									@endphp
														
								</div>
								<a href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region])}}">
								
									<div class="card-body text-left">
										<h4 class="offer-title card-title">{{$offer['productTitle']}}</h4>
										<h6 class="offer-location card-category">
											@foreach($offer['region'] as $region)
															<span>{{ $region->regionName }}</span>
														@endforeach
													</h6>			           
										<a href="{{ route('data.company_offers', ['companyName'=>$offer['company_slug']]) }}">
											@if( file_exists( public_path() . '/uploads/company/'.$offer['companyLogo']) && $offer['companyLogo'] )
											<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" src="{{ asset('uploads/company/'.$offer['companyLogo']) }}" />
											@else
											<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" src="{{ asset('uploads/company/default_thumb.png') }}" />
											@endif
										</a>
									</div>
								</a>
							</div>	
						</div>						
					
				<?php  } ?>				
				</div>
				
				<?php if( $max_to_show < (count($offer_products)-1)){?>
						<div class="row" id='dataproducts_more' style='display:none	'>
							<?php foreach ( $offer_products as $index => $offer ){
								if($index > $max_to_show){ ?>
								<div class="col-md-4 mb-20">
											<div class="card card-profile card-plain mb-0">					
												<div class="card-header">
													@php
														$companyName = $offer['company_slug'];
														$title = $offer['offer_slug'];
														$region = "";
														foreach($offer['region'] as $key=>$r){
															$region = $region .$r->slug;
															if($key+1 < count($offer['region'])) $region = $region . "-";
														}
														$alt_text_offer = $offer['offerTitle'].' from '.$offer['companyName']. ' in '. $region;								
														$alt_text_provider = $offer['companyName']. ' on '.APPLICATION_NAME;
													@endphp
													
												</div>
												
												<div class="card-body text-left">
													<h4 class="offer-title card-title">{{$offer['productTitle']}}</h4>
													<h6 class="offer-location card-category">
														@foreach($offer['region'] as $region)
																		<span>{{ $region->regionName }}</span>
																	@endforeach
																</h6>			           
													<a href="{{ route('data.company_offers', ['companyName'=>str_replace(' ', '-', strtolower($offer['companyName']))]) }}">
														@if( file_exists( public_path() . '/uploads/company/thumb/'.$offer['companyLogo']) && $offer['companyLogo'] )
														<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" src="{{ asset('uploads/company/thumb/'.$offer['companyLogo']) }}" />
														@else
														<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" src="{{ asset('uploads/company/default_thumb.png') }}" />
														@endif
													</a>
												</div>
											</div>	
										</div>	
											
								<?php } } ?>
							</div>
							<div class='row'>
								<div class='col-md-4'></div>
								<div class='col-md-4' style='text-align:center'>
									<button class='button customize-btn mgh25' id='dataproducts_more_btn'  onclick="viewMoreSearch('dataproducts','more')">View More</button>
									<button class='button customize-btn mgh25' id='dataproducts_less_btn' style='display:none' onclick="viewMoreSearch('dataproducts','less')">View Less</button>
								</div>
								
							</div>
				<?php  } ?>

  		</div> 	  		
  		<input type="hidden" name="totalcount" value="{{ $totalcount }}">  		
  		<input type="hidden" name="per_page" value="{{ $per_page }}">
  		<div class="text-center @if ( $totalcount <= $per_page ) hide @endif"><button id="offer_loadmore" type="button" class="button secondary-btn mgh25 w225">Load More</button></div>
		@endif
		@if(count($dataoffer) > 0)
    	<h1 id="offer-count" class="mb-20 fs-30 text-bold text-left"> Found <span>{{ count($dataoffer) }}</span> data offers for your search key "{{ session('curSearchKey')?session('curSearchKey'):'' }}" </h1>   
    	<div id="offer-list">
			<div class="row">
				@php
					$makematching = rand(0, count($dataoffer)-1);					
				@endphp
				<?php foreach ( $dataoffer as $index => $offer ){
							if($index > $max_to_show)						
								break; 
								?>
			
				<div class="col-md-4 mb-20">
					<div class="card card-profile card-plain mb-0">					
						<div class="card-header">
							@php
								$companyName = $offer['company_slug'];
								$title = $offer['offer_slug'];
								$region = "";
								foreach($offer['region'] as $key=>$r){
									$region = $region . $r->slug;
									if($key+1 < count($offer['region'])) $region = $region . "-";
								}
								$alt_text_offer = $offer['offerTitle'].' from '.$offer['companyName']. ' in '. $region;								
								$alt_text_provider = $offer['companyName']. ' on '.APPLICATION_NAME;
							@endphp
							<a href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region])}}">
									@if( file_exists(public_path().$offer['offerImage']) && $offer['offerImage'] )
											<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" style="max-width:100%" src="{{asset($offer['offerImage'])}}" />
									@else
											<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" style="max-width:100%"  src="{{ asset('uploads/offer/default.png') }}" />
									@endif
							</a>							
						</div>
						
						<div class="card-body text-left">
							<h4 class="offer-title card-title">{{$offer['offerTitle']}}</h4>
							<h6 class="offer-location card-category">
								@foreach($offer['region'] as $region)
				            		<span>{{ $region->regionName }}</span>
				            	@endforeach
				            </h6>			           
							<a href="{{ route('data.company_offers', ['companyName'=>$offer['company_slug']]) }}">
								@if( file_exists( public_path() . '/uploads/company/thumb/'.$offer['companyLogo']) && $offer['companyLogo'])
								<img class="img" src="{{ asset('uploads/company/thumb/'.$offer['companyLogo']) }}" />
								@else
								<img class="img" src="{{ asset('uploads/company/default_thumb.png') }}" />
								@endif
							</a>
						</div>
					</div>	
				</div>						
					
				<?php  } ?>				
				</div>
				
				<?php if( $max_to_show < (count($dataoffer)-1)){?>
						<div class="row" id='dataoffers_more' style='display:none'>
							<?php foreach ( $dataoffer as $index => $offer ){
								if($index > $max_to_show){ ?>
								<div class="col-md-4 mb-20">
											<div class="card card-profile card-plain mb-0">					
												<div class="card-header">
	@php
		$companyName = $offer['company_slug'];
		$title = $offer['offer_slug'];
		$region = "";
		foreach($offer['region'] as $key=>$r){
			$region = $region .$r->slug;
			if($key+1 < count($offer['region'])) $region = $region . "-";
		}
		$alt_text_offer = $offer['offerTitle'].' from '.$offer['companyName']. ' in '. $region;								
		$alt_text_provider = $offer['companyName']. ' on '.APPLICATION_NAME;
	@endphp
		<a href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region])}}">
			@if( file_exists( public_path() . $offer['offerImage']) && $offer['offerImage'] )
			<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" style="max-width:100%" src="{{asset($offer['offerImage'])}}" />
			@else
			<img alt ="{{$alt_text_offer}}" title ="{{$alt_text_offer}}" class="img" src="{{ asset('uploads/offer/default.png') }}" />
			@endif
		</a>		
	</div>
												
												<div class="card-body text-left">
													<h4 class="offer-title card-title">{{$offer['offerTitle']}}</h4>
													<h6 class="offer-location card-category">
														@foreach($offer['region'] as $region)
																		<span>{{ $region->regionName }}</span>
																	@endforeach
																</h6>			           
													<a href="{{ route('data.company_offers', ['companyName'=>$offer['company_slug']]) }}">
														@if( file_exists( public_path() . '/uploads/company/thumb/'.$offer['companyLogo']) && $offer['companyLogo'] )
														<img class="img" src="{{ asset('uploads/company/thumb/'.$offer['companyLogo']) }}" />
														@else
														<img class="img" src="{{ asset('uploads/company/default_thumb.png') }}" />
														@endif
													</a>
												</div>
											</div>	
										</div>	
											
								<?php } } ?>
							</div>
							<div class='row'>
								<div class='col-md-4'></div>
								<div class='col-md-4' style='text-align:center'>
									<button class='button customize-btn mgh25' id='dataoffers_more_btn'  onclick="viewMoreSearch('dataoffers','more')">View More</button>
									<button class='button customize-btn mgh25' id='dataoffers_less_btn' style='display:none' onclick="viewMoreSearch('dataoffers','less')">View Less</button>
								</div>
								
							</div>
				<?php  } ?>

  		</div> 	  		
  		<input type="hidden" name="totalcount" value="{{ $totalcount }}">  		
  		<input type="hidden" name="per_page" value="{{ $per_page }}">
  		<div class="text-center @if ( $totalcount <= $per_page ) hide @endif"><button id="offer_loadmore" type="button" class="button secondary-btn mgh25 w225">Load More</button></div>
		@endif
		@if(count($usecases) > 0)
		  <h1 id="offer-count" class="mb-20 fs-30 text-bold text-left"> Found <span>{{ count($usecases) }}</span> use cases for your search key "{{ session('curSearchKey')?session('curSearchKey'):'' }}" </h1>   
		  <div id="usecase-list" class="mgh30">
                    <div class="row">
                        <?php foreach ( $usecases as $index => $usecase ){
							if($index > $max_to_show)						
								break; ?>
					
							<div class="col-md-4">
								<a href="{{ route('about.usecase_detail',  ['title' => $usecase->slug] ) }}">
									<div class="card card-profile card-plain">                  
										<div class="card-header holder" id="resposive-card-header">        
											<img class="img" src="{{ asset('uploads/usecases/tiny/'.$usecase->image) }}" id="responsive-card-img" />
										</div>
										<div class="card-body text-left">
											<div class="para-small">
											
											</div>
											<h4 class="offer-title card-title">{{ $usecase->articleTitle }}</h4>
										</div>
									</div>  
								</a>
							</div>  
                       <?php  }   ?>
                    </div>					
						<?php if( $max_to_show <= (count($usecases)-1)){?>
						<div class="row" id='usecases_more' style='display:none	'>
							<?php foreach ( $usecases as $index => $usecase ){
								if($index > $max_to_show){ ?>
						
									<div class="col-md-4">
										<a href="{{ route('about.usecase_detail',  ['title' => $usecase->slug] ) }}">
											<div class="card card-profile card-plain">                  
												<div class="card-header holder" id="resposive-card-header">        
													<img class="img" src="{{ asset('uploads/usecases/tiny/'.$usecase->image) }}" id="responsive-card-img" />
												</div>
												<div class="card-body text-left">
													<div class="para-small">
													
													</div>
													<h4 class="offer-title card-title">{{ $usecase->articleTitle }}</h4>
												</div>
											</div>  
										</a>
									</div>  
							<?php  }  }  ?>
						</div>
						<div class='row'>
							<div class='col-md-4'></div>
							<div class='col-md-4' style='text-align:center'>
								<button class='button customize-btn mgh25' id='usecases_more_btn'  onclick="viewMoreSearch('usecases','more')">View More</button>
								<button class='button customize-btn mgh25' id='usercases_less_btn' style='display:none' onclick="viewMoreSearch('usecases','less')">View Less</button>
							</div>
							
						</div>
					<?php } ?>
                </div>  
			@endif

			@if(count($updates) > 0)
		  <h1 id="offer-count" class="mb-20 fs-30 text-bold text-left"> Found <span>{{ count($updates) }}</span> updates for your search key "{{ session('curSearchKey')?session('curSearchKey'):'' }}" </h1>   
		  <div id="updates-list" class="mgh30">
                    <div class="row">
              <?php foreach ( $updates as $index => $update ){
								if($index > $max_to_show)						
									break; ?>
					
							<div class="col-md-4">
								<a href="{{ route('about.usecase_detail',  ['title' => $update->slug] ) }}">
									<div class="card card-profile card-plain">                  
										<div class="card-header holder" id="resposive-card-header">        
											<img class="img" src="{{ asset('uploads/usecases/tiny/'.$update->image) }}" id="responsive-card-img" />
										</div>
										<div class="card-body text-left">
											<div class="para-small">
											
											</div>
											<h4 class="offer-title card-title">{{ $update->articleTitle }}</h4>
										</div>
									</div>  
								</a>
							</div>  
                       <?php  }   ?>
                    </div>					
						<?php if( $max_to_show <= (count($updates)-1)){?>
						<div class="row" id='updates_more' style='display:none	'>
							<?php foreach ( $updates as $index => $update ){
								if($index > $max_to_show){ ?>
						
									<div class="col-md-4">
										<a href="{{ route('about.usecase_detail',  ['title' => $update->slug] ) }}">
											<div class="card card-profile card-plain">                  
												<div class="card-header holder" id="resposive-card-header">        
													<img class="img" src="{{ asset('uploads/usecases/tiny/'.$update->image) }}" id="responsive-card-img" />
												</div>
												<div class="card-body text-left">
													<div class="para-small">
													
													</div>
													<h4 class="offer-title card-title">{{ $update->articleTitle }}</h4>
												</div>
											</div>  
										</a>
									</div>  
							<?php  }  }  ?>
						</div>
						<div class='row'>
							<div class='col-md-4'></div>
							<div class='col-md-4' style='text-align:center'>
								<button class='button customize-btn mgh25' id='updates_more_btn'  onclick="viewMoreSearch('updates','more')">View More</button>
								<button class='button customize-btn mgh25' id='updates_less_btn' style='display:none' onclick="viewMoreSearch('updates','less')">View Less</button>
							</div>
							
						</div>
					<?php } ?>
                </div>  
			@endif
			
		
		</div>

			 
    </div>    
	

@endsection

@section('additional_javascript')
	<script src="{{ asset('js/plugins/select2.min.js') }}"></script>
	<script>
		function viewMoreSearch(section,action){

			console.log(section,action);
			if(section=='updates' && action == 'more'){
				$('#updates_more').css('display','flex');
				$('#updates_more_btn').css('display','none');
				$('#updates_less_btn').css('display','block');
				$('html, body').animate({
					'scrollTop' : $("#updates_more").position().top
				});
			}
			if(section=='updates' && action == 'less'){
				$('#updates_more').css('display','none');
				$('#updates_more_btn').css('display','block');
				$('#updates_less_btn').css('display','none');
			}
			if(section=='usecases' && action == 'more'){
				$('#usecases_more').css('display','flex');
				$('#usecases_more_btn').css('display','none');
				$('#usercases_less_btn').css('display','block');
				$('html, body').animate({
					'scrollTop' : $("#usecases_more").position().top
				});
			}
			if(section=='usecases' && action == 'less'){
				$('#usecases_more').css('display','none');
				$('#usecases_more_btn').css('display','block');
				$('#usercases_less_btn').css('display','none');
			}
			if(section=='dataoffers' && action == 'more'){
				$('#dataoffers_more').css('display','flex');
				$('#dataoffers_more_btn').css('display','none');
				$('#dataoffers_less_btn').css('display','block');
				$('html, body').animate({
					'scrollTop' : $("#dataoffers_more").position().top
				});
			}
			if(section=='dataoffers' && action == 'less'){
				$('#dataoffers_more').css('display','none');
				$('#dataoffers_more_btn').css('display','block');
				$('#dataoffers_less_btn').css('display','none');
			}
			if(section=='dataproducts' && action == 'more'){
				$('#dataproducts_more').css('display','flex');
				$('#dataproducts_more_btn').css('display','none');
				$('#dataproducts_less_btn').css('display','block');
				$('html, body').animate({
					'scrollTop' : $("#dataproducts_more").position().top
				});
			}
			if(section=='dataproducts' && action == 'less'){
				$('#dataproducts_more').css('display','none');
				$('#dataproducts_more_btn').css('display','block');
				$('#dataproducts_less_btn').css('display','none');
			}
		}
	</script>
@endsection
