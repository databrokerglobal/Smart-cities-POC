@extends('layouts.app')

@section('title', 'Data products | Databroker ')
@section('description', '')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">		
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style type="text/css">
    	.sweet-alert.showSweetAlert .btn.confirm{
    		background: #FF6B6B 0% 0% no-repeat padding-box;
    		display: inline-block;
		    font-size: 14px;
		    font-weight: bold;
		    width: auto;
		    padding-left: 20px;
		    padding-right: 20px;
		    margin: 15px 0px 15px 20px;
		    min-width: 150px;
		    border-radius: 25px;
    	}
    	.sweet-alert.showSweetAlert .btn.confirm:hover{
    		background-color: #E15757;
    	}
    	.sweet-alert.showSweetAlert .btn.cancel{
    		display: inline-block;
    		font-size: 14px;
		    font-weight: bold;
		    width: auto;
		    padding-left: 20px;
		    padding-right: 20px;
		    margin: 15px 0px 15px 20px;
		    min-width: 150px;
		    border-radius: 25px;
    	}
    	.sweet-alert.showSweetAlert .btn.cancel:hover{background-color: grey;}
			.bid_price{
				position: relative;
    		top: 15px;
			}
			.data-offer.detail .product-container .product-fields-block {
					margin-top: 18px;
					margin-bottom: 14px;
			}
    </style>
@endsection

@include('modals/private_share')
@section('content')
<div class="container-fluid app-wapper data-offer detail">
	<div class="bg-pattern1-left"></div>
    <div class="container">	
    	<div class="app-section app-reveal-section align-items-center">
    		<a href="{{ route('data_offers_overview') }}" class="back-icon"><i class="material-icons">keyboard_backspace</i><span>{{ trans('pages.Back_to_data_offer_overview') }}</span></a>
	        <div class="blog-header">
	            <h1>{{ trans('pages.Data_offer') }}</h1>
	            <div class="offer">
					<div class="offer-title">{{$offer['offerTitle']}}</div>
					<div class="region offer-location">
									@foreach($offer['region'] as $region)
		            		<span>{{ $region->regionName }}</span>
		            	@endforeach
		            </div>
					<div class="status-block publish">
						<div>
							<span class="offer-publish-status">
								<span class="label">{{ trans('pages.Status') }}: </span>
								@if ( $offer['offer_status'] == 1 )
									{{ trans('pages.published') }}
								@else
									{{ trans('pages.unpublished') }}
								@endif
							</span>
							<a class="link-market" href="{{$link_to_market}}">{{ trans('pages.view_on_marketplace') }}</a>
						</div>
						<div class="buttons">
							<a href="{{route('data_offer_edit', ['id'=>$id])}}">
								<span class="icon-button btn-edit color-gray5" >
									<i class="icon material-icons">
										edit
									</i>
									{{ trans('pages.edit') }}
								</span>
							</a>
							<span class="seperator">|</span>
						@if ( $offer['offer_status'] == 1 )							
							<a class="icon-button btn-delete data_unpublish" data-toggle="modal" data-target="#unpublishOfferModal" data-id="{{ $offer['offerIdx'] }}" data-type="offer">
								<i class="icon material-icons">
									cancel
								</i>								
								{{ trans('pages.unpublish') }}
							</a>
						@else
							<a class="icon-button btn-publish data_publish" data-id="{{ $offer['offerIdx'] }}" data-type="offer">
								<i class="icon material-icons">
									publish
								</i>
								{{ trans('pages.publish') }}
							</a>
						@endif	
							<span class="seperator">|</span>
							<a class="icon-button btn-delete" onclick="deleteOffer(this,<?=$offer['offerIdx']?>)" >
									<i class="icon material-icons">
										delete
									</i>								
									{{ trans('pages.delete') }}
							</a>
							<span class="seperator">|</span>
							<a class="icon-button btn-delete" onclick="duplicateOffer(<?=$offer['offerIdx']?>)" >
									<i class="icon material-icons">
									control_point_duplicate
									</i>								
									{{ trans('pages.duplicate') }}
							</a>
						</div>
					</div>
					<div class="divider-green"></div>
		        </div>
	        </div>
	        <div class="blog-content">
				<span class="offer-products">
					<div class="row products-header">
						<div class="col-12 col-md-6 col-sm-6 col-lg-6">
							<span class="label text-black">{{ trans('pages.data_products') }}: </span>
							<span class="count">{{ count($products) }}</span>
							<p class="para">Before you can sell or share a data product, you need to make sure that the Data eXchange Controller (DXC) has been installed and that you have activated the data product using its unique ID.</p>
							<p class="para">Need help? You can find detailed instructions in our <a href="{{ route('help.buying_data') }}" class="link-market">{{ trans('pages.help_section') }}</a></p>
						</div>
						<div class="col-12 col-md-6 col-sm-6 col-lg-6">
							<div class='row' > 
								<div class="col-md-3"></div>
									<div class="col-md-6">
										@if ( $offer['status'] == 1)	
										<a href="{{ route('data_offer_add_product', ['id'=>$id]) }}"><button type="button" class="customize-btn btn-add pull-right">{{ trans('pages.ADD_DATA_PRODUCT') }}</button>	<!-- goto #29 --></a>
										@else						
										<a class="" data-toggle="modal" data-target="#pubRecommendModal" data-id="{{ $offer['offerIdx'] }}" data-type="offer">
											<button type="button" class="customize-btn btn-add pull-right">{{ trans('pages.ADD_DATA_PRODUCT') }}</button>
										</a>
										@endif
									</div>
							</div>
						<!-- 	@if ( $offer['offerType'] == 'PRIVATE')	
								<div class='row'> 
									<div class="col-md-3"></div>
										<div class="col-md-6">
											<a class="" data-toggle="modal" data-target="#shareModal" data-id="{{ $offer['offerIdx'] }}" data-type="offer">
												<button type="button" class="customize-btn btn-add pull-right">{{ trans('pages.SHARE_OFFER') }}</button>
											</a>
										</div>
								</div>
							@endif -->
						</div>
					</div>
					<div class="product-list">
						@foreach ($products as $product)
						<div class="product-container">
							<div class="product-title">{{ $product['productTitle']}}</div>							
							<div class="product-region offer-location">
								@foreach($product['region'] as $region)
				            		<span>{{ $region->regionName }}</span>
				            	@endforeach
				      </div>
							<div class="row product-fields-block">
								<div class="col col-12 col-md-6 col-sm-6 col-lg-6 product-fields">
									<div class="row field-format">
										<div class="col col-6 col-md-3 col-sm-3 col-lg-3"><span class="label">{{ trans('pages.format') }}:</span></div>
										<div class="col col-6 col-md-3 col-sm-3 col-lg-3 value">{{ $product['productType'] }}</div>
									</div>
									<div class="row field-price">
										<div class="col col-6 col-md-3 col-sm-3 col-lg-3 <?=($product->productBidType == 'no_bidding' || $product->productBidType == 'bidding_possible')?'bid_price':'';?>"><span class="label">{{ trans('pages.price') }}:</span></div>
										<div class="col-6 col-md-3 col-sm-3 col-lg-3">
											@if($product['productBidType']=="bidding_only")
											N/A
											@elseif($product['productBidType']=="free")
											<span class="value text-warning">FREE</span>
											@else						
											<div class="form-group">					
												<select class="form-control" onchange="setPircePeriod(this,'price',<?=$product['productIdx']?>)" id="price_<?=$product['productIdx']?>">
														@foreach($product['productpricemappings'] as $key => $mapping)
															<option value="<?=$mapping->ppmIdx?>_<?=$key?>">{{$mapping->productPrice}} € (tax incl.)</option>
														@endforeach
												</select>											
											</div>
											@endif
										</div>
									</div>
									<div class="row field-access">	
										<div class="col col-6 col-md-3 col-sm-3 col-lg-3"></div>
										<div class="col-6 col-md-3 col-sm-3 col-lg-3 value text-warning">{{ str_replace('_', ' ',$product['productBidType']) }}</div>
									</div>
									<div class="row field-period">
										<div class="col col-6 col-md-3 col-sm-3 col-lg-3"><span class="label">{{ trans('pages.Access_to_this_data') }}: </span></div>
										<div class="col-6 col-md-3 col-sm-3 col-lg-3 value"> 
													@if($product->productBidType == 'no_bidding' || $product->productBidType == 'bidding_possible')
													<select class="form-control" onchange="setPircePeriod(this,'period',<?=$product['productIdx']?>)" id="period_<?=$product['productIdx']?>">
														@foreach($product['productpricemappings'] as $key => $mapping)
															<option value="<?=$mapping->ppmIdx?>_<?=$key?>">1 {{$mapping->productAccessDays}}</option>
														@endforeach
													</select>
													@else
														<span><?=isset($product['productpricemappings'][0])? "1 ".$product['productpricemappings'][0]['productAccessDays'] : '' ;?></span>
													@endif
										</div>
									</div>
										<div class="row field-period">
										<div class="col col-6 col-md-3 col-sm-3 col-lg-3"><span class="label">{{ trans('pages.Data_Type') }}:</span></div>
										<div class="col-6 col-md-3 col-sm-3 col-lg-3 value">{{ $product['offerType'] }}</div>
									</div>
								</div>
								<div class="col-12 col-md-6 col-sm-6 col-lg-6 status-block product flex-vcenter">
									<div class="w-100">								
										<span class="offer-publish-status product">
											<span class="label">{{ trans('pages.Status') }}: </span>

											@if ( $product['productStatus'] == 1 )
												{{ trans('pages.published') }}
											@else
												{{ trans('pages.unpublished') }}
											@endif
										</span>
										<div class="buttons">
											<a class="icon-button btn-edit" href="{{route('data_offer_edit_product', ['id'=>$id, 'pid'=>$product['productIdx']])}}">
												<i class="icon material-icons">
													edit
												</i>
												{{ trans('pages.edit') }}
											</a>
											<span class="seperator">|</span>
											@if ( $product['productStatus'] == 0 )
											<a class="icon-button btn-edit data_publish" data-id="{{ $product['productIdx'] }}" data-type="product">
												<i class="icon material-icons">
													publish
												</i>	
												{{ trans('pages.publish') }}
											</a>	
											@else	
											<a class="icon-button btn-delete data_unpublish" data-toggle="modal" data-target="#unpublishProductModal" data-id="{{ $product['productIdx'] }}" data-type="product">
												<i class="icon material-icons">
													cancel
												</i>	
												{{ trans('pages.unpublish') }}
											</a>	
											@endif												
										</div>
										<!--div class="sell_pending_hint_container">
											<i class="icon material-icons">info</i>
											<span class="sell_pending_hint">{{ trans('pages.sell_pending_hint') }}</span>
										</div>
										<div class="user-id">
											<span class="label">{{ trans('pages.id') }} :</span>
											{{ trans('pages.hidden_numbers') }}
										</div>
										<div class="copy-id"><a class="link-market">{{trans('pages.Copy_ID')}}</a></div-->
										
										<div class="row">
											<div class="col-lg-12">
												<div class="row">													
													@if(!empty($dxcs) && $activeDxcs > 0)
														<div class="col col-12 col-md-6 col-sm-6 col-lg-6">
															<div class="buttons flex-vcenter">
																<button type="submit"  onclick="showMapModal(<?=$product['productIdx']?>,<?=$product['offerIdx']?>,&quot;<?=$product['dxc']?>&quot;,&quot;<?=$product['did']?>&quot;)" class="customize-btn">Map with data in DXC</button>
															</div>
														</div>
													@endif
													@if($product['offerType'] == 'PRIVATE')
													<div class="col col-12 col-md-6 col-sm-6 col-lg-6">
															<div class="buttons flex-vcenter">
																<button type="submit" class="customize-btn" onclick="addUsersToProductDetailsPage(<?=$product['productIdx']?>)"> Map with data Users </button>
															</div>
													</div>													
													@endif
													@if($product['productBidType']!="free")
														@if($product['offerType'] == 'PRIVATE')
															<div class="col col-3"></div>
														@endif
														<div class="col col-12 col-md-6 col-sm-6 col-lg-6">
																<div class="buttons flex-vcenter">
																	<button type="submit" class="customize-btn" onclick="addEmailsToShare('<?=$product['productIdx']?>')"> Test Your Data</button>
																</div>
														</div>

													@endif																								
											</div>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</span>
	        </div>			
	</div>      
</div>

<div class="modal fade" id="unpublishOfferModal" tabindex="-1" role="dialog" aria-labelledby="unpublishOfferModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="para">Unpublishing a data offer means the related data products will no longer be available for purchase.</p>
        <p class="para">Are you sure you want to unpublish?</p>
      </div>      
      <input type="hidden" name="data_type" value="">
      <input type="hidden" name="data_id" value="">
      <div class="modal-footer">        
        <button type="button" class="button primary-btn unpublish">Yes, Unpublish</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="unpublishProductModal" tabindex="-1" role="dialog" aria-labelledby="unpublishProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="para">Unpublishing this data product means it will no longer be available for purchase.</p>
        <p class="para">Are you sure you want to unpublish?</p>
      </div>      
      <input type="hidden" name="data_type" value="">
      <input type="hidden" name="data_id" value="">
      <div class="modal-footer">        
        <button type="button" class="button primary-btn unpublish">Yes, Unpublish</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="pubRecommendModal" tabindex="-1" role="dialog" aria-labelledby="pubRecommendModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="para">
        	You need to publish the data offer first before you can actually sell the product.

        	Do you want to publish the data offer?
        </p>
      </div>      
      <input type="hidden" name="data_type" value="">
      <input type="hidden" name="data_id" value="">
      <div class="modal-footer">        
        <button type="button" class="button primary-btn publish btn-publish data_publish" data-id="{{ $offer['offerIdx'] }}" data-type="offer">Yes, publish it!</button>
        <a href="{{ route('data_offer_add_product', ['id'=>$id]) }}" data-window='external' data-dismiss="modal" data-target="#"><button type="button" class="button secondary-btn" data-dismiss="modal">Add product</button></a>
      </div>
    </div>
  </div>
</div>

<form method="post" id="duplicate_offer_form" action="{{route('data.duplicate_offer')}}">
			@csrf   
			<input type='hidden' name="duplicate_offerIdx" id="duplicate_offerIdx">
</form>

<!-- Map with data model -->
<div class="modal fade" id="mapWithDataModal" tabindex="-1" role="dialog" aria-labelledby="pubRecommendModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 850px !important;">
    <div class="modal-content" style="padding: 3%;">
      <div class="modal-header">  
				<h4 class='text-bold'>Map with data in DXC</h4>      
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method="post" action="{{route('map_data_with_dxc')}}" onsubmit="return validateForm()">
				@csrf    
				<div class="modal-body">
								<div class="row" >
								<div class="col-lg-12 ml-30" >
									<div class="list-dxc-container">
										<p class="para fs-16 lh-1 text-bold">Select the DXC</p>										
										<input type="hidden" name="offerIdx" id="offerIdx">
										<input type="hidden" name="productIdx" id="productIdx">
										<div class="adv-combo-wrapper custom-select2 mt-10">
											<input type="hidden" name="dxc" id="dxc" value="<?=$intialDxc;?>">
											<select name="dxc-select" id="dxc-select" onchange="changeDxc(this)" data-placeholder="Please select a dxc" class="no-search form-control">																						
											@if(!empty($dxcs))
												@foreach($dxcs as $key=>$dxc)
													@foreach($dxc as $i => $dxc)
																												
															@if($dxc->acceptanceStatus=="ACCEPTED")
																<option value="{{$i}}">{{$dxc->host}}</option>													
															@endif
													@endforeach
												@endforeach
											@endif
											</select>	
										</div>
										<div class="error_notice err_dxc"></div>
									</div>
									<p class="para fs-16 lh-1 mt-10 text-bold">Select the data source</p>
									<input type="hidden" name="did" id="did" value="">
									<table class="table border-grey table-dxc-data">
											<thead>
												<tr>
													<th class="text-bold fs-16 text-black">Data</th>
													<th class="text-bold fs-16 text-black">Type</th>
												</tr>
											</thead>
											<tbody class="selectable-list list-data" id='data-body'>
												@if(!empty($dxcs))
													@php $i=0; @endphp
													@foreach($dxcs as $key=>$value)
														@if(isset($value[0]))
															@php $dxc = $value[0]; @endphp
															@if($dxc->acceptanceStatus=="ACCEPTED")
																
																<?php foreach($dxc->datasources as $index=>$pp){
																		if($i > 0)  break; ?>														
																	
																		<tr class="selectable-list-item"  did="{{$pp->did}}" parent-id="<?=$key?>">
																			<td>{{$pp->name}}</td>
																			<td>{{$pp->type}}</td>
																		</tr>
																	
																<?php }?>
																@php $i++; @endphp
															@endif
														@endif
													@endforeach
												@endif
											</tbody>
										</table>
										<div class="error_notice err_did"></div>
								</div>
								<span class="error_notice dxcDataSource ml-30 mt-10"> Please select the DXC and Data Source where the buyer can get the data for free.</span>
							</div>
				</div>            
				<div class="modal-footer">        
					<button class="customize-btn" type="submit">UPDATE</button>
					
				</div>
			</form>
    </div>
  </div>
</div>

@endsection


<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="post" post autocomplete="off">
            @csrf
            <input type="hidden" name="offerIdx" value="{{$offer['offerIdx']}}">
            <p class="para">
						{{ trans('pages.SHARE_OFFER_MODEL_HEADING') }}
            </p>    
            <p class="share-feedback text-center" style="display: none">The email is successfully sent.</p>
            <div class="email_lists cat-body">
                <div class="error_notice">Please add email address.</div>
								<div class='row item1' >
									<div class='col-md-10'>

											<label class="pure-material-textfield-outlined">
													<!-- <i class='fa fa-home'></i> -->
													<input type="email" id="email1" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
													<span>Email 1</span>                    
													<div class="error_notice">Email format is incorrect.</div>
											</label>
									</div>								
								</div>
								<div class="row item2">
									<div class="col-md-10">
										<label class="pure-material-textfield-outlined">
												<input type="email" id="email2" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
												<span>Email 2</span> 
												<div class="error_notice">Email format is incorrect.</div>                        
										</label>
									</div>
									<div class="col-md-2">
											<a class="removemail" id="2"><i class="fa fa-times" aria-hidden="true"></i></a>
									</div>
									
								</div>
								<div class='row item3'>
									<div class='col-md-10'>
										<label class="pure-material-textfield-outlined">
												<input type="email" id="email3" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
												<span>Email 3</span> 
												<div class="error_notice">Email format is incorrect.</div>                        
										</label> 
									</div>
									<div class='col-md-2'>
											<a class="removemail" id="3"><i class='fa fa-times' aria-hidden="true"></i></a>
									</div>
									
								</div>               
						</div>
						<input type='hidden' id='share_count' value='3'>
            <a class="more_email pull-right mb-20" href="javascript:;">+ more</a>
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn shareoffer">Share</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="shareFreeAccessModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="post" post autocomplete="off">
            @csrf
						<input type='hidden' id='invite_productIdx' name='invite_productIdx' value=''>
            <p class="para">
                An email will be sent to the user providing free access to your data during 1 hour
            </p>    
            <p class="invalid-feedback text-center" style="display: none">The email is successfully sent.</p>
            <div class="free_access_email_lists cat-body">
                <div class="error_notice">Please add email address.</div>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="email1" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Email 1</span>                    
                    <div class="error_notice">Email format is incorrect.</div>
                </label>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="email2" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Email 2</span> 
                    <div class="error_notice">Email format is incorrect.</div>                        
                </label>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="email3" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Email 3</span> 
                    <div class="error_notice">Email format is incorrect.</div>                        
                </label>                
            </div>
            <a class="more_email pull-right mb-20" href="javascript:;">+ more</a>
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn invite">Invite</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@section('additional_javascript')
	
  <script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
	<script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
	<script type="text/javascript">
		/* let active_id = $('.list-dxc .selectable-list-item.active').attr('item-id'); */
	
		$('.list-dxc .selectable-list-item').click(function(e){
			let dxc = $(this).html();
			$("input[name='dxc']").val(dxc);
			let active_id = $(this).attr('item-id');
			$('.list-dxc .selectable-list-item.active').removeClass('active');
			$('.list-dxc .selectable-list-item.selected').removeClass('selected');
			$(this).addClass('active');
			$(this).addClass('selected');
			$('.list-data .selectable-list-item.active').removeClass('active');
			$.each($('.list-data .selectable-list-item'), function(key, value){
				if($(value).attr('parent-id')==active_id){
					$(value).addClass('active')
				}
			});
		});
		$(document.body).on('click', '.list-data .selectable-list-item' ,function(e){
		/* $('.list-data .selectable-list-item').on('click',function(e){ */			
			let did = $(this).attr('did');
			$('input[name="did"]').val(did);
			$('.list-data .selectable-list-item.selected').removeClass('selected');
			$(this).addClass('selected');
		});	

	    // Initialize datatable with ability to add rows dynamically
	    var initTableWithDynamicRows = function() {
	        var table = $('.table-dxc-data');

	        var settings = {
	            responsive: true,

	            lengthMenu: [5, 10, 25, 50],

	            pageLength: 10,

	            language: {
	                'lengthMenu': 'Display _MENU_',
	            },
	        };

	        board_data_table = table.dataTable(settings);
	    }

		initTableWithDynamicRows();
		
		function changeDxc(ele){

			let  key = $(ele).val();
			let dxcs = <?=json_encode($dxcs);?>;	
			let data = dxcs['dxcs'];
			let content = "";
			if(data[key].datasources.length > 0){
				$("input[name='dxc']").val(data[key].host);
				var table = $('.table-dxc-data').DataTable();
				//clear datatablei
				table.clear().draw();
				table.destroy();

				let datasources = data[key].datasources;
				$.each(datasources,function(key,value){
						let selected = "";
						if(key == 0){
							selected = "selected";
							$('input[name="did"]').val(value['did']);
						}

						content +='<tr class="selectable-list-item '+selected+'"  did="'+value['did']+'" parent-id="'+key+'">'
								  +'<td>'+value['name']+'</td>'
								  +'<td>'+value['type']+'</td>'
								  +'</tr>';
				});				
				$('#data-body').html(content);
				initTableWithDynamicRows();
			}						
		}
		function showMapModal(productIdx,offerIdx,host,did){	
				
			if(host != '' && did != ''){
				let dxcs = <?=json_encode($dxcs);?>;	
				let data = dxcs['dxcs'];
				$.each(data,function(key,value){				
					if(value.acceptanceStatus == "ACCEPTED" && value.host == host ){
						console.log(key);
						$('#dxc-select').val(key).change();						
						$("input[name='dxc']").val(host);
					}
				})			
				
				$('input[name="did"]').val(did);
			  $('.selectable-list-item.selected').removeClass('selected');			
				$("[did='"+did+"']").addClass('selected');
			}else{
				
				let dxcs = <?=json_encode($dxcs);?>;	
				let data = dxcs['dxcs'];
				$.each(data,function(key,value){				
					if(value.acceptanceStatus == "ACCEPTED"){												
						$('#dxc-select').val(key).change();						
						$("input[name='dxc']").val(data[key].host);	
						$('.selectable-list-item.selected').removeClass('selected');
						$('input[name="did"]').val('');
						return false;
					}
				})
			
			}

					$("#productIdx").val(productIdx);
					$("#offerIdx").val(offerIdx);					
					$('#mapWithDataModal').modal('show');
		}
		function validateForm(){
				console.log('helo');
				let error =0;
				if($('#dxc').val() == ""){
						$("#err_dxc").html("Please select dxc.");
						error = 1;
				}else{
					$("#err_dxc").html("");
				}

				if($('#did').val() == ""){
						$("#err_did").html("Please select did.");
						error = 1;
				}else{

					$("#err_did").html("");
				}

				if(error == 0){
					return true;
				}else{
					return false;
				}
		}

		function deleteOffer(element,offerIdx){
			
				swal({
			    title: "Are you sure to delete offer?",
			    text: "Organizations are currently using data related to this offer, after deletion they will not be able to access it. Are you sure to delete?",
			    type: "warning",
			    showCancelButton: true,
			    confirmButtonClass: "btn-danger",
			    confirmButtonText: "Confirm",
			    cancelButtonText: "No",
			    closeOnConfirm: false,
			    closeOnCancel: true
			  },
			  function(isConfirm) {
			    if (isConfirm) {
						console.log(isConfirm);
			      	$.ajax({
				        headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        },
				        url: '/data/delete',
								data:{oid:offerIdx},
				        method: 'post',
				        success: function(res){
									window.location.href = "/data/offers/overview";
				        }
			      	});
			    }
				});
			
		}

		function duplicateOffer(offerIdx){			
			let res = confirm("Are  you sure to duplicate this offer?");
			if(res){
				$('#duplicate_offerIdx').val(offerIdx);
				$( "#duplicate_offer_form" ).submit();
			}
		}

		function setPircePeriod(ele,type,productIdx){
			
			if(type == 'period'){				
				$('#price_'+productIdx).val($(ele).val());				
			}
			if(type == 'price'){				
				$('#period_'+productIdx).val($(ele).val());
			}
		}
	</script>
@endsection		