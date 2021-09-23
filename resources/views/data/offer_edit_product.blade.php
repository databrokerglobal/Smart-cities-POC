@extends('layouts.app')

@section('title', 'Edit data product | Databroker')
@section('description', '')

@section('additional_css')	
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
	<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
	<style>
			.price-label{
				width:19%;
			}
			.form-check .form-check-sign {    
    			top: 3px;  
			}
			div.dataTables_wrapper div.dataTables_info {
				padding-top: 0.85em;
				white-space: break-spaces;
			}
		</style>
@endsection

@include('modals/private_share')
@section('content')
<!-- -->
<div class="container-fluid app-wapper help buying-data">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section align-items-center">
        	<form id="add_product" action="{{ route('data_offer_submit_product') }}" method="post" novalidate>
        		@csrf        		        		
        		<input type="hidden" name="productIdx" id="productIdx" value="{{ $product['productIdx'] }}">
				<input type="hidden" name="offerIdx" id="offerIdx" value="{{$offer['offerIdx']}}">
        		<div class="blog-header mgt60">
	                <h1 class="h1-small">Update data product</h1>
	                <h3 class="h3 text-normal">This data product is related to the following data offer:</h3>
	                <h3 class="h3"> {{ $offer['offerTitle'] }} </h3>
	                <span class="para offer-location">
	                	@foreach($offer['region'] as $region)
		            		<span>{{ $region->regionName }}</span>
		            	@endforeach
		            </span>
	            </div>
	            <div class="divider-green mgh40"> </div>
	            <div class="content">
	            	<div class="row">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">What is the specific data product are you selling? <i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.what_product_tooltip') }}">help</i></h4>

							<div class="text-wrapper">
								<textarea name="productTitle" class="round-textbox user-message min-h100" placeholder="{{ trans('pages.your_message') }}" maxlength="0100">{{$product['productTitle']}}</textarea>							
								<div class="error_notice productTitle"> This field is required</div>
								<div class="char-counter"><span>0</span> / <span>1000</span> characters</div>
							</div>
						</div>
					</div>
	            	<div class="row">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">Which region does the data cover? <i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_datacover_tooptip') }}">help</i></h4>
				        	<div class="custom-dropdown-container">
		                        <div class="custom-dropdown" tabindex="1">
		                            <div class="select">
		                                <span>{{implode(',', array_values($regionCheckList))}}</span>
		                            </div>
		                            <input type="hidden" id="offercountry" name="offercountry" value="{{implode(',', array_keys($regionCheckList))}}">
		                            <ul class="custom-dropdown-menu region-select" style="display: none;">
		                            	<h4>{{ trans('pages.select_region') }}:</h4>
		                            	@foreach ($regions as $region)
			                               	<div class="check_container">
						                        <label class="pure-material-checkbox">
						                            @if (isset($regionCheckList[$region->regionIdx]) && $regionCheckList[$region->regionIdx] != '')
						                            <input type="checkbox" class="form-control no-block check_community" name="region[]" region="{{$region->regionName}}" value="{{$region->regionIdx}}" checked>
						                            @else
						                            <input type="checkbox" class="form-control no-block check_community" name="region[]" region="{{$region->regionName}}" value="{{$region->regionIdx}}">
						                            @endif
						                            <span>{{$region->regionName}}</span>
						                        </label>
						                    </div>
						                @endforeach    
					                    
					                    <h4 class="h4_intro text-left">Or add country</h4>
                                        <div class="adv-combo-wrapper custom-select2 mt-10">
						                    <select class="" name="region[]" data-placeholder="{{ trans('pages.search_by_country') }}">
												<option></option>
						                    	@foreach ($countries as $country)
					                                <option value="{{$country->regionIdx}}">{{ $country->regionName }}</option>
					                            @endforeach
						                    </select>
						                </div>
		                                <div class="buttons flex-vcenter">						
											<button type="button" class="customize-btn">{{ trans('pages.confirm') }}</button>
										</div>
		                            </ul>
		                        </div>
		                        <div class="error_notice offercountry"> This field is required</div>
		                    </div>    
						</div>
					</div>
					<div class="row mgt30">
	            		<div class="col-lg-12">
			                <h4 class="h4_intro text-left">How are you going to share yourdata? 
							<i class="material-icons text-grey text-top" data-toggle="tooltip" 
							data-placement="auto"  title="" data-container="body" 
							data-original-title="{{ trans('description.product_type_tooptip') }}" data-html="true">help</i> </h4>
				        	<div class="radio-wrapper offerType">	
				        		<div class="mb-10 form-check">	                    
				                    <label class="orm-check-label para">Publicly
									  <input type="checkbox" name="offerType[]" class='product_type form-check-input' onChange="checkProductType('public')"  @if ($product['offerType'] == 'PUBLIC' || $product['offerType'] == 'PUBLIC&PRIVATE') checked="checked" @endif  value="PUBLIC">
									  <span class="form-check-sign">
                                        <span class="custom-check check"></span>
                                    	</span>
									</label>
								</div>
								<div class="mb-10 form-check">
									<label class="orm-check-label para">Privately  
									
									  <input type="checkbox" name="offerType[]" class='product_type form-check-input' onChange="checkProductType('private')" name="offerType" @if ($product['offerType'] == 'PRIVATE' || $product['offerType'] == 'PUBLIC&PRIVATE') checked="checked" @endif  value="PRIVATE">
									  <span class="form-check-sign">
                                        <span class="custom-check check"></span>
                                    	</span>
									</label>
									<a  id='add_users' title="add users" onclick="addUsersToProduct('addedit')" style="display:<?=($product['offerType'] == "PRIVATE" || $product['offerType'] == "PUBLIC&PRIVATE")?'initial':'none'?>">
                                            <i class="icon material-icons mdl-badge my-icon">person_add</i>
                                        </a>	
								</div>
								
							</div>
							<input type='hidden' id='addeditselected_users' value="<?=$product_sahre_users?>" name='addeditselected_users'>  
			                <span class="error_notice type"> Please select the offer type.</span>
						</div>
						
						
					</div>
					<!-- Seleccted Users list -->
					<div class='row' id="selected_users_list" style="display:<?=($product['offerType'] == "PRIVATE" || $product['offerType'] == "PUBLIC&PRIVATE")?'flex':'none'?>">	
							@foreach($sahred_users_with_orgs as $user)
									<div class="col-lg-12" style="margin: 0.5% 0;" id="selected_user_<?=$user->orgUserIdx?>">
									<div class="col-md-5" style="float:left"><a href="javascript:void(0)">{{$user->orgName}}({{$user->orgUserEmail}})</a></div>
										<div class="col-md-2" style="float:left"  title='Remove user'>
											<a onclick="removeSelectedUser(&quot;<?=$user->orgUserIdx?>&quot;)"><i class="icon material-icons mdl-badge my-icon">highlight_off</i></a>
										</div>
									</div>
							@endforeach						
					</div>
	            	<div class="row mgt30">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">In which format will the data be provided?<i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_data_provided_tooptip') }}">help</i></h4>
				        	<div class="radio-wrapper format">
				        		@foreach ($prodTypeList as $prodType)	
				        		<div class="mb-10">	                    
				                    <label class="container para">{{$prodType}}
									  <input type="radio" @if ($prodType == $product['productType']) checked="checked" @endif name="format" value="{{$prodType}}">
									  <span class="checkmark"></span>
									</label>
								</div>
								@endforeach
			                </div>
						</div>
					</div>
	            	<div class="row mgt30">
	            		<div class="col-lg-12">
			                <h4 class="h4_intro text-left">How will you handle pricing for this data product? <i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_pricing_tooptip') }}">help</i></h4>
				        	<div class="radio-wrapper period">
				        		@foreach ($bidTypes as $bidtype)
				        		<div class="mb-10" id="{{$bidtype['type']}}">
				        			<label class="container para">{{$bidtype['label']}}
										<input type="radio" @if ($bidtype['type'] == $product['productBidType']) checked="checked" @endif name="period" value="{{$bidtype['type']}}">
										<span class="checkmark"></span>
									</label>
									<div class="period_select" style="display:<?=$product['productBidType'] == $bidtype['type']?'block':'none'?>">
										@if ($bidtype['biddable'])
										<div class="flex-box">
											<label class="pure-material-textfield-outlined mb-0 p-0 price-label">
												<span class="currency">€ </span>
												<input type="number" step="0.01" name="{{$bidtype['type']}}_price" class="form-control2 bidding_price input_data" placeholder="0.00" value="{{$product['productPrice']}}"> 
											</label>
											<span class="select-period-content">(tax incl.)</span>
											<span class="para mlr-20 select-period-content">for access to this data for</span>
											<div class="adv-combo-wrapper custom-select2">
												<select name="{{$bidtype['type']}}_period" data-placeholder="Please select" class="no-search bidding_period">
													<option></option>
													@foreach ($accessPeriodList as $period)
													<option value="{{$period['key']}}">{{$period['label']}}</option>
													@endforeach
												</select>						                    
											</div>
											@if($bidtype['type'] == 'no_bidding')
												<span class="para mlr-20 add-price cursur-pointer" role="nobid"><i class="fa fa-plus select-period-content"></i></span>			
											@endif
											@if($bidtype['type'] == 'bidding_possible')
												<span class="para mlr-20 add-price cursur-pointer" role="bid"><i class="fa fa-plus select-period-content"></i></span>	
											@endif

										</div>
										@endif
										@if ($bidtype['biddable'] == false)
											<span class="para mlr-20">for access to this data for</span>
											<div class="adv-combo-wrapper custom-select2">
												<select name="{{$bidtype['type']}}_period" data-placeholder="Please select" class="no-search">
													<option></option>
													@foreach ($accessPeriodList as $period)
													<option value="{{$period['key']}}" @if (isset($price_mappings[0]) && $price_mappings[0]['productAccessDays'] == $period['key']) selected @endif>{{$period['label']}}</option>
													@endforeach
												</select>						                    
											</div>	
										@endif
										<div class="errors">
											@if($bidtype['type'] == 'bidding_possible')
												<span class="error_notice bid_repeat">The combination of price and period is already selected before. Please select the new combination.</span>
											@else
											<span class="error_notice nobid_repeat">The combination of price and period is already selected before. Please select the new combination.</span>
											@endif
											<span class="error_notice {{$bidtype['type']}}_price">   Price is required. </span>
											@if($bidtype['type']=="no_bidding" || $bidtype['type']=="bidding_possible")
											<span class="error_notice {{$bidtype['type']}}_price_min"> Price should be higher than € 0.50</span>
											<span class="error_notice {{$bidtype['type']}}_price_max"> Price should be less than € 999999999 and upto 2 decimal places.</span>
											<span class="error_notice {{$bidtype['type']}}_add_single_period"> Please add atleast one price period to proceed.</span>
											
											@elseif($bidtype['type']=='free')
											<!-- <span class="error_notice dataUrl">You must provide a URL where the buyer can get the data for free.</span> -->
											@endif
											<span class="error_notice {{$bidtype['type']}}_period"> Please select a period.</span>
						                </div>  										
										
										@if($bidtype['biddable'])
										<div class="selected_price_periods mt-10">		
											@if($product['productBidType'] == $bidtype['type'])
											<?php $arrProductBidType = []; ?>
											@foreach($price_mappings as $mapping)													<?php $arrVal = floatval($mapping['productPrice']).$mapping['productAccessDays']; 
													array_push($arrProductBidType,$arrVal);
											?>		
													<div class="row price_period">
														@if($bidtype['type'] == 'no_bidding')
															<input  type="hidden" class="nobidprice" name="nb_price[]" value="<?=$mapping['productPrice']?>" >
															<input  type="hidden" name="nb_period[]" value="<?=$mapping['productAccessDays']?>" >
														@endif
														@if($bidtype['type'] == 'bidding_possible')
															<input  type="hidden" class="bidprice" name="b_price[]" value="<?=$mapping['productPrice']?>" >
															<input  type="hidden" name="b_period[]" value="<?=$mapping['productAccessDays']?>" >
														@endif
														<p class="col-md-1 col-sm-1"></p>
														<p class="col-md-3 col-sm-3 para">{{$mapping['productPrice']}} for 1{{$mapping['productAccessDays']}}</p>
														<p class="col-md-2 col-sm-2 para danger cursur-pointer" onclick="removeme(this)"><i class="fa fa-times"></i></p>											
													</div>
												@endforeach	
												@if($bidtype['type'] == 'no_bidding')
													<input type="hidden" id="nobid_priceperiod" name="nobid_priceperiod[]" value="<?php echo implode(",",$arrProductBidType); ?>" />
												@endif
												@if($bidtype['type'] == 'bidding_possible')
													<input type="hidden" id="bid_priceperiod" name="bid_priceperiod[]" value="<?php echo implode(",",$arrProductBidType); ?>" />
												@endif
											@elseif($product['productBidType'] != $bidtype['type'])
												@if($bidtype['type'] == 'no_bidding')
													<input type="hidden" id="nobid_priceperiod" name="nobid_priceperiod[]" value="" />
												@endif
												@if($bidtype['type'] == 'bidding_possible')
													<input type="hidden" id="bid_priceperiod" name="bid_priceperiod[]" value="" />
												@endif
											@endif				
										</div>
										@endif	
						              <!--   @if($bidtype['type']=='free')
						                <div class="row">
						                	<div class="col-lg-6">
						                		<label class="pure-material-textfield-outlined">
						                			<input type="text" id="dataUrl" name="dataUrl" class="form-control input_data w-100" placeholder=" " value="{{$product->productUrl}}">
						                			<span>{{ trans('pages.data_url') }}</span>
						                		</label>
						                	</div>
						                </div>
						                @endif	 -->		         
						                    
									</div>	
				        		</div>
				        		@endforeach								
			                </div>
						</div>
					</div>
					<div class="row mgt30">
						<div class="col-6">
							<h4 class="h4_intro text-left">Identify your data source</h4>
						</div>
					</div>
					
					
					<div class="row" id='self-source' style="display:<?=$product->productBidType=='free'?'block':'none'?>">
						<div class="col-lg-6">
							<div class="col-lg-12">
								<div class="radio-wrapper format">	
									<div class="mb-10">	                    
										<label class="container para">I will enter a URL 
											<input type="radio" name="sourcetype"  @if($product['productUrl'] != '') checked="checked" @endif  id='self-data-source' value="self">
											
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-lg-12 ml-30">
								<label class="pure-material-textfield-outlined">									
									<input type="text" id="dataUrl" name="dataUrl" class="form-control input_data w-100" placeholder=" " value="{{$product->productUrl}}">
									<span>{{ trans('pages.data_url') }}</span>
								</label>
								<span class="error_notice dataUrl"> You must provide a URL where the buyer can get the data for free.</span>
							</div>
						</div>
					</div>	
					
					@if(count($dxcs)>0)
					<div class="row">
						<div class="col-lg-6">
							<div class="col-lg-12">
								<div class="radio-wrapper format">	
									<div class="mb-10">	                    
										<label class="container para">I'll select data from my DXC
											<input type="radio" name="sourcetype" @if ($product['dxc'] != '' &&  $product['did'] !='' && $product['productUrl'] == '' ) checked="checked" @endif id='dxc-data-source' value="dxc">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-lg-12 ml-30" >
								<div class="list-dxc-container">
									<p class="para fs-16 lh-1">Select the DXC</p>
									<input type="hidden" name="dxc" id="dxc" value="{{$product->dxc?$product->dxc:$dxcs[0]->host}}">
									<div class="adv-combo-wrapper custom-select2 mt-10">
										<select name="dxc-selectble" id="dxc-selectble" onchange="changeDxc(this)" data-placeholder="Please select a dxc" class="no-search">						                    	
													
											@foreach($dxcs as $key=>$dxc)
												@if($dxc->acceptanceStatus=="ACCEPTED")
													<option value="{{$key}}">{{$dxc->host}}</option>
													<!-- <li class="selectable-list-item @if($key==0) active selected @endif" item-id="{{$key+1}}">{{$dxc->host}}</li> -->
												@endif
											@endforeach
										</select>	
									</div>
									
								</div>
								<p class="para fs-16 lh-1 mt-10 ">Select the data</p>
								<input type="hidden" name="did" id="did" value="{{$product->did}}">
								<table class="table border-grey table-dxc-data">
										<thead>
											<tr>
												<th class="text-bold fs-16 text-black">Data</th>
												<th class="text-bold fs-16 text-black">Type</th>
											</tr>
										</thead>
										<tbody class="selectable-list list-data" id='data-body'>
											@foreach($dxcs as $key=>$dxc)
												@if($dxc->acceptanceStatus=="ACCEPTED")
													<?php foreach($dxc->datasources as $index=>$pp){
														if($index > 0)  break; ?>														
														@if($pp->available)
															<tr class="selectable-list-item"  did="{{$pp->did}}" parent-id="{{$key}}">
																<td>{{$pp->name}}</td>
																<td>{{$pp->type}}</td>
															</tr>
														@endif
													<?php }?>
												@endif
											@endforeach
										</tbody>
								  </table>
							</div>
							<span class="error_notice dxcDataSource ml-30 mt-10"> Please select the DXC and Data Source where the buyer can get the data for free.</span>
							<span class="error_notice dxc">Please select the DXC.</span>
							<span class="error_notice did">Please select your data source.</span>
						</div>
					</div>						
					@endif	
					<!-- @if(count($dxcs)>0)
					<div class="row mgt30">
						<div class="col-6">
							<h4 class="h4_intro text-left">Identify your data source</h4>
							<div class="row">
								<div class="col col-5">
									<div class="list-dxc-container">
										<p class="para text-center fs-16 lh-1">Select the DXC</p>
										<input type="hidden" name="dxc" id="dxc" value="{{$product->dxc?$product->dxc:$dxcs[0]->host}}">
										<ul class="selectable-list list-dxc list-style-none pl-0 text-center border-grey">
											@foreach($dxcs as $key=>$dxc)
												@if($dxc->acceptanceStatus=="ACCEPTED")
											<li class="selectable-list-item" item-id="{{$key+1}}">{{$dxc->host}}</li>
												@endif
											@endforeach
										</ul>
									</div>
								</div>
								<div class="col col-7 pl-0">
									<div class="table-dxc-data-container">
										<p class="para text-center fs-16 lh-1">Select the data</p>
										<input type="hidden" name="did" id="did" value="{{$product->did}}">
										<table class="table border-grey table-dxc-data">
											<thead>
												<tr>
													<th class="text-bold fs-16 text-black">Data</th>
													<th class="text-bold fs-16 text-black">Type</th>
												</tr>
											</thead>
											<tbody class="selectable-list list-data">
												@foreach($dxcs as $key=>$dxc)
													@if($dxc->acceptanceStatus=="ACCEPTED")
														@foreach($dxc->datasources as $index=>$pp)
															@if($pp->available)
															<tr class="selectable-list-item @if($product->did==$pp->did) selected @endif" did="{{$pp->did}}" parent-id="{{$key+1}}">
																<td>{{$pp->name}}</td>
																<td>{{$pp->type}}</td>
															</tr>
															@endif
														@endforeach
													@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<span class="error_notice dxc">Please select the DXC.</span>
					<span class="error_notice did">Please select your data source.</span>
					@endif -->
	            	<div class="row mgt30">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">Is there any additional information that might be useful for a potential buyer? (optional) <i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_potential_buyer_tooptip') }}">help</i></h4>
				        	<div class="text-wrapper">
								<textarea name="productMoreInfo" class="round-textbox user-message min-h200" placeholder="{{ trans('pages.your_message') }}" maxlength="1000">{{$product['productMoreInfo']}}</textarea>
								<div class="char-counter"><span>0</span> / <span>1000</span> characters</div>
							</div>
						</div>
					</div>
	            	<div class="row mgt30">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">Provide a URL where the buyer can read the data license. <i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_license_url_tooptip') }}">help</i></h4>
				        	<label class="pure-material-textfield-outlined">
		                        <input type="text" id="licenseUrl" name="licenceUrl" class="form-control2 input_data" placeholder=" "  value="{{$product['productLicenseUrl']}}">
		                        <span>{{ trans('pages.enter_url') }}</span>	                        
		                    </label>
		                   	<div class="error_notice licenceUrl"> You must provide a URL where the buyer can consult the data licence. </div>
						</div>
					</div>
					<div class="row mgt40">
						<div class="col-lg-6">
							<button class="customize-btn" type="submit">UPDATE</button><!-- submit and redirect to #38 -->
						</div>
					</div>
	            </div>
        	</form>            
        </div>  
    </div>
</div>

@endsection

@section('additional_javascript')
	<script src="{{ asset('js/plugins/select2.min.js') }}"></script>   
    <script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
	<script type="text/javascript">
		let dxc = $('input[name="dxc"]').val();
		let active_id = $('#did').val();
		console.log(active_id);
		
		if(dxc){
			let data = <?=json_encode($dxcs);?>;
			$.each(data, function(key, value){
				if(value['host']==dxc){
					console.log('selected key', key);
					$('#dxc-selectble').val(key);
					loadSourceData(key);					
				}
			});
		}
		
		$.each($('.list-data .selectable-list-item'), function(key, value){
			if($(value).attr('did')==active_id){
				$(value).addClass('active');
			}
		});
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
			let data = <?=json_encode($dxcs);?>;			
			let content = "";
			if(data[key].datasources.length > 0){
				$("input[name='dxc']").val(data[key].host);
				var table = $('.table-dxc-data').DataTable();
				//clear datatable
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
		function loadSourceData(key){

			let data = <?=json_encode($dxcs);?>;			
			let content = "";
			if(data[key].datasources.length > 0){
				$("input[name='dxc']").val(data[key].host);
				var table = $('.table-dxc-data').DataTable();
				//clear datatable
				table.clear().draw();
				table.destroy();

				let datasources = data[key].datasources;
				$.each(datasources,function(key,value){
						let selected = "";
						console.log(value['did'],$('#did').val());
						if($('#did').val() == value['did']){
							selected = "selected";							
						}						
						content +='<tr class="selectable-list-item '+selected+'"  did="'+value['did']+'" parent-id="'+key+'">'
								+'<td>'+value['name']+'</td>'
								+'<td>'+value['type']+'</td>'
								+'</tr>';
				});				
				$('#data-body').html(content);

				setTimeout(function(){
					console.log('dsafa');
					//initTableWithDynamicRows();	
				}, 3000);
				
			}
		}
	</script>
@endsection
