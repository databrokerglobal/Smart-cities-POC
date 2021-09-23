@extends('layouts.app')

@section('title', 'Add a new data product | Databroker')
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
        		<input type="hidden" name="offerIdx" value="{{ $offer['offerIdx'] }}">
        		<div class="blog-header mgt60">
	                <h1 class="h1-small">Add a new data product</h1>
	                <h3 class="h3 text-normal">This data product is related to the following data offer:</h3>
	                <h3 class="h3"> {{ $offer['offerTitle'] }} </h3>
	                @if($offer['region'])
	                <span class="para offer-location">
	                	@foreach($offer['region'] as $region)
		            		<span>{{ $region->regionName }}</span>
		            	@endforeach
		            </span>
		            @endif
	            </div>
	            <div class="divider-green mgh40"> </div>
	            <div class="content">
	            	<div class="row">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">What is the specific data product are you selling? <i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.what_product_tooltip') }}">help</i></h4>

							<div class="text-wrapper">
								<textarea name="productTitle" class="round-textbox user-message min-h100" placeholder="{{ trans('pages.your_message') }}"  maxlength="1000"></textarea>							
								<div class="error_notice productTitle"> This field is required</div>
								<div class="char-counter"><span>0</span> / <span>1000</span> characters</div>
							</div>
						</div>
					</div>
	            	<div class="row">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">Which region does the data cover? 
							<i class="material-icons text-grey text-top" data-toggle="tooltip" 
							data-placement="auto"  title="" data-container="body" 
							data-original-title="{{ trans('description.product_datacover_tooptip') }}">help</i></h4>

				        	<div class="custom-dropdown-container">
		                        <div class="custom-dropdown" tabindex="1">
		                            <div class="select">
		                                <span>Please Select</span>
		                            </div>
		                            <input type="hidden" id="offercountry" name="offercountry" value="">
		                            <ul class="custom-dropdown-menu region-select" style="display: none;">
		                            	<h4>{{ trans('pages.select_region') }}:</h4>
		                            	@foreach ($regions as $region)
			                               	<div class="check_container">
						                        <label class="pure-material-checkbox">
						                            <input type="checkbox" class="form-control no-block check_community" name="region[]" region="{{$region->regionName}}" value="{{$region->regionIdx}}">
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
		                    </div>    
		                    <div class="error_notice offercountry"> This field is required</div>
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
				                    <label class="orm-check-label para">
										<span> Publicly<span>
									  <input type="checkbox" name="offerType[]" class='product_type form-check-input' onChange="checkProductType('public')" checked=true value="PUBLIC">
									  <span class="form-check-sign">
                                        <span class="custom-check check"></span>
                                    	</span>
									</label>
								</div>
								<div class="mb-10 form-check">
									<label class="orm-check-label para">Privately 
										
									  <input type="checkbox" name="offerType[]" class='product_type form-check-input' onChange="checkProductType('private')" value="PRIVATE">
									  <span class="form-check-sign">
                                        <span class="custom-check check"></span>
                                    </span>
									</label>
										<a  id='add_users' style='display:none' title="add users" onclick="addUsersToProduct('addedit')">
												<i class="icon material-icons mdl-badge my-icon">person_add</i> 
											</a>	
								</div>								
							</div>
							<input type='hidden' id='addeditselected_users' name='addeditselected_users'>  
			                <span class="error_notice type"> Please select the product type.</span>
						</div>
						
						
					</div>
					<!-- Seleccted Users list -->
					<div class='row' id="selected_users_list" style='display:none'>							
					</div>

	            	<div class="row mgt30">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">In which format will the data be provided?<i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_data_provided_tooptip') }}">help</i></h4>
				        	<div class="radio-wrapper format">	
				        		<div class="mb-10">	                    
				                    <label class="container para">File
									  <input type="radio" name="format" value="File">
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="mb-10">
									<label class="container para">Api flow	
									  <input type="radio" name="format" value="Api flow">
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="mb-0">
									<label class="container para">Stream
									  <input type="radio" name="format" value="Stream">
									  <span class="checkmark"></span>
									</label>
								</div>
			                </div>
			                <span class="error_notice format"> Please select the data format.</span>
						</div>
					</div>
	            	<div class="row mgt30">
	            		<div class="col-lg-12">
			                <h4 class="h4_intro text-left">How will you handle pricing for this data product?<i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_pricing_tooptip') }}">help</i></h4>
				        	<div class="radio-wrapper period">
				        		<div class="mb-10">
				        			<label class="container para">FREE
										<input type="radio" name="period" value="free">
										<span class="checkmark"></span>
									</label>
									<div class="period_select">
										<span class="para mlr-20">for access to this data for </span>
							        	<div class="adv-combo-wrapper custom-select2">
						                    <select name="free_period" data-placeholder="Please select a period" class="no-search">
						                    	<option></option>
						                    	<option value="day">1 day</option>
						                    	<option value="week">1 week</option>
						                    	<option value="month">1 month</option>
						                    	<option value="year">1 year</option>
						                    </select>						                    
						                </div>
						                			                
									</div>	
									<span class="error_notice free_period"> Please select a period.</span>
									
				        		</div>		                    		                    
								<div class="mb-10">
									<label class="container para">I will set a price. No bidding is possible.
									  <input type="radio" name="period" value="no_bidding">
									  <span class="checkmark"></span>
									</label>
									<div class="period_select">
										<div class="flex-box">
											<label class="pure-material-textfield-outlined price-label mb-0 p-0">
												<span class="currency">€ </span><input type="number" step="1" name="no_bidding_price"
													 class="form-control2 input_data bidding_price" placeholder="0.00" value=""> 
											</label>
											<span class="select-period-content">(tax incl.)</span>
											<span class="para mlr-20 select-period-content">for access to this data for</span>
											<div class="adv-combo-wrapper custom-select2">
												<select name="no_bidding_period" data-placeholder="Please select a period" class="no-search  bidding_period">
													<option></option>
													<option value="day">1 day</option>
													<option value="week">1 week</option>
													<option value="month">1 month</option>
													<option value="year">1 year</option>
												</select>				                    				                        
											</div>	
											<span class="para mlr-20 add-price cursur-pointer" role="nobid"><i class="fa fa-plus select-period-content"></i></span>	
										</div>		
										<div class="errors">
											<span class="error_notice no_bidding_price"> Price is required. </span>
								            <span class="error_notice no_bidding_period"> Please select a period.</span>
											<span class="error_notice no_bidding_price_min"> Price should be higher than € 1</span>
											<span class="error_notice no_bidding_price_max"> Price should be less than € 999999999 and upto 2 decimal places.</span>
											<span class="error_notice no_bidding_add_single_period"> Please add atleast one price period to proceed.</span>
											<span class="error_notice nobid_repeat">The combination of price and period is already selected before. Please select the new combination.</span>
										</div>
										<div class="selected_price_periods mt-10">	
											 <input type="hidden" id="nobid_priceperiod" name="nobid_priceperiod[]" value="" />
										</div>
												                
									</div>
				                </div>
				                <div class="mb-10">
				                	<label class="container para">I will set a price, but buyers can also send bids.
									  <input type="radio" name="period" value="bidding_possible">
									  <span class="checkmark"></span>
									</label>
				                	<div class="period_select">
										<div class="flex-box">
											<label class="pure-material-textfield-outlined price-label mb-0 p-0">
												<span class="currency">€ </span><input type="number" step="1" 
														name="bidding_possible_price" class="form-control2 input_data bidding_price" placeholder="0.00" value=""> 
											</label>
											<span class="select-period-content">(tax incl.)</span>
											<span class="para mlr-20 select-period-content">for access to this data for</span>
											<div class="adv-combo-wrapper custom-select2 ">
												<select name="bidding_possible_period"  data-placeholder="Please select a period" class="no-search bidding_period">
													<option></option>
													<option value="day">1 day</option>
													<option value="week">1 week</option>
													<option value="month">1 month</option>
													<option value="year">1 year</option>
												</select>				                    				                        
											</div>
											<span class="para mlr-20 add-price cursur-pointer" role="bid"><i class="fa fa-plus  select-period-content"></i></span>
										</div>
						                <div class="errors">
											<span class="error_notice bidding_possible_price"> Price is required. </span>
									        <span class="error_notice bidding_possible_price_min"> Price should be more than € 1.</span>
											<span class="error_notice bidding_possible_price_max"> Price should be less than € 999999999 and upto 2 decimal places.</span>
											<span class="error_notice bidding_possible_period"> Please select a period.</span>
											<span class="error_notice bidding_add_single_period"> Please add atleast one price period to proceed.</span>
											<span class="error_notice bid_repeat">The combination of price and period is already selected before. Please select the new combination.</span>
										 </div>
										 <div class="selected_price_periods mt-10">
											 <input type="hidden" id="bid_priceperiod" name="bid_priceperiod[]" value="" />	
										</div>										 
									</div>
				                </div>							
				                <div class="mb-10">
				                	<label class="container para">I will not set a price. Interested parties can send bids.
									  <input type="radio" name="period" value="bidding_only">
									  <span class="checkmark"></span>
									</label>	
									<div class="period_select">									
										<span class="para mlr-20">for access to this data for</span>
							        	<div class="adv-combo-wrapper custom-select2">
						                    <select name="bidding_only_period" data-placeholder="Please select a period" class="no-search">
						                    	<option></option>
						                    	<option value="day">1 day</option>
						                    	<option value="week">1 week</option>
						                    	<option value="month">1 month</option>
						                    	<option value="year">1 year</option>
						                    </select>				                    				                        
						                </div>
									</div>
									<div class="error_notice bidding_only_period"> Please select a period.</div>
				                </div>
		                   		<div class="error_notice period">Please set how you will handle the pricing for the data.</div>
			                </div>
						</div>
					</div>
					<div class="row mgt30">
						<div class="col-6">
							<h4 class="h4_intro text-left">Identify your data source</h4>
						</div>
					</div>
					<div class="row " style='display:none' id='self-source'>
						<div class="col-lg-6">
							<div class="col-lg-12">
								<div class="radio-wrapper format">	
									<div class="mb-10">	                    
										<label class="container para">I Will enter a URL
											<input type="radio" name="sourcetype" id='self-data-source' value="self">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-lg-12 ml-30">
								<label class="pure-material-textfield-outlined">
									<input type="text" id="dataUrl" name="dataUrl" class="form-control input_data w-100" placeholder=" " value="">
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
											<input type="radio" name="sourcetype" id='dxc-data-source' checked="true" value="dxc">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-lg-12 ml-30" >
								<div class="list-dxc-container">
									<p class="para fs-16 lh-1">Select the DXC</p>
									<input type="hidden" name="dxc" id="dxc" value="{{$dxcs[0]->host}}">
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
								<input type="hidden" name="did" id="did" value="">
								<table class="table border-grey table-dxc-data">
										<thead>
											<tr>
												<th class="text-bold fs-16 text-black">Data</th>
												<th class="text-bold fs-16 text-black">Type</th>
											</tr>
										</thead>
										<tbody class="selectable-list list-data" id='data-body'>
											@php $i=0; @endphp
											@foreach($dxcs as $key=>$dxc)
												@if($dxc->acceptanceStatus=="ACCEPTED")
													
													<?php foreach($dxc->datasources as $index=>$pp){
															if($i > 0)  break; ?>														
														
															<tr class="selectable-list-item"  did="{{$pp->did}}" parent-id="{{$key}}">
																<td>{{$pp->name}}</td>
																<td>{{$pp->type}}</td>
															</tr>
														
													<?php }?>
													@php $i++; @endphp
												@endif
											@endforeach
										</tbody>
								  </table>
							</div>
							<span class="error_notice dxcDataSource ml-30 mt-10"> Please select the DXC and Data Source where the buyer can get the data for free.</span>
						</div>
					</div>						
					@endif					
	            	<div class="row mgt30">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">Is there any additional information that might be useful for a potential buyer? (optional)<i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_potential_buyer_tooptip') }}">help</i></h4>
				        	<div class="text-wrapper">
								<textarea name="productMoreInfo" class="round-textbox user-message min-h200" placeholder="{{ trans('pages.your_message') }}" maxlength="1000"></textarea>
								<div class="char-counter"><span>0</span> / <span>1000</span> characters</div>
							</div>
						</div>
					</div>
	            	<div class="row mgt30">
	            		<div class="col-lg-6">
			                <h4 class="h4_intro text-left">Provide a URL where the buyer can read the data license. <i class="material-icons text-grey text-top" data-toggle="tooltip" data-placement="auto"  title="" data-container="body" data-original-title="{{ trans('description.product_license_url_tooptip') }}">help</i></h4>
				        	<label class="pure-material-textfield-outlined">
		                        <input type="text" id="licenseUrl" name="licenceUrl" class="form-control2 input_data" placeholder=" "  value="">
		                        <span>{{ trans('pages.enter_url') }}</span>	                        
		                    </label>
		                   	<div class="error_notice licenceUrl"> You must provide a URL where the buyer can consult the data licence.</div>
						</div>
					</div>
					<div class="row mgt40">
						<div class="col-lg-6">
							<button class="customize-btn" type="submit">PUBLISH NOW</button><!-- submit and redirect to #38 -->
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
		/* let active_id = $('.list-dxc .selectable-list-item.active').attr('item-id'); */
		let active_id = $('#dxc').val();
		$.each($('.list-data .selectable-list-item'), function(key, value){
			console.log($(value).attr('parent-id'));
			if($(value).attr('parent-id')==active_id){
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
		/* $('.list-data .selectable-list-item').on('click',function(e){ */
			console.log('helo');
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
	</script>
@endsection
