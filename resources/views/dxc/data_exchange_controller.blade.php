@extends('layouts.app')

@section('title', 'Data exchange controller | Databroker ')

@section('additional_css')
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
			
			.faq-btn-link{
					text-decoration: none;
					text-transform: capitalize !important;
					font-size:18px;
					color:blue !important;
			}
			.btn.btn-default.faq-btn-link:active, .btn.btn-default.faq-btn-link:focus, .btn.btn-default.faq-btn-link:hover, .btn.faq-btn-link:active, .btn.faq-btn-link:focus, .btn.faq-btn-link:hover{
					color: blue !important;
			}
			.customize-button-copy{
				height: 30px;
				padding-top: 5.3%;
				padding-left: 30px;
				padding-right: 30px;
				min-width: 100px;			
				display: inline-block;
				background:#EBF0F4 !important;
				margin: 0px 0px !important;
			}
			.dxc-lable-div{
				position: relative;
    		bottom: 7px;
				left:-12px;
			}
			
			.btn-newKey{
				position: relative;
				color: #FF6B5B !important;
			}
			.key-sub-title{
				color: #FF6B5B !important;
			}
			#copy{
				color:green;font-size:13px;text-align: center;
				display:none;
			}		
    </style>
@endsection

@section('content')
<div class="container-fluid app-wapper data-offer">
	<div class="bg-pattern1-left"></div>
    <div class="container myaccount">
    	<div class="app-section app-reveal-section align-items-center mydxc dxc_content_border">
    		<div class="row blog-header">
	    		<div class="col col-12">
					<h2>My Data Exchange Controllers </h2>
				</div>
			</div>
			<div class="app-monetize-section-item0 ml-0 dxc-item0"></div>
			<div class="blog-content" style="margin: 0 2%;">
					<p id='copy' style=''>  Copied to clipboard</p>
					<div class="row">																					
												<div class="col-md-3 col-sm-12 col-12 dxc-lable-div">													
														<h4 class="dxc-label key-sub-title"> ACCOUNT ID:</h4>
												</div>
												<div class="col-md-3 col-sm-4 col-6">
														<a type="button" onclick='copykey(&quot;<?=$address?>&quot;,this)' class="button customize-btn customize-button-copy mgh25">Copy </a>
														
												</div>
												<div class="col-md-3 col-sm-4 col-6">
														<a type="button"  onclick="showKey(&quot;<?=$address?>&quot;,&quot;ACCOUNT ID:&quot;)" class="button customize-btn customize-button-copy mgh25">Show </a>
														
												</div>								
						</div>
						<div class="row ">															
											<div class="col-md-3 col-sm-12 col-12 dxc-lable-div">													
													<h4 class="dxc-label key-sub-title"> DXC KEY:</h4>
											</div>
											<div class="col-md-3 col-sm-4 col-6">
													<a type="button" onclick='copykey(&quot;<?=$apiKey?>&quot;,this)' class="button customize-btn customize-button-copy mgh25">Copy </a>
													
											</div>
											<div class="col-md-3 col-sm-4 col-6">
													<a type="button" onclick="showKey(&quot;<?=$apiKey?>&quot;,&quot;DXC KEY:&quot;)" class="button customize-btn customize-button-copy mgh25">Show </a>
													
											</div>
											<div class="col-md-3 col-sm-4 col-6">
													<a href="#" class="btn-newKey">Generate New key</a>													
											</div>								 
						</div>																			
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-12 col-sm-12">
						<br>
						<h4> Available DXC's :</h4>
						<table class="table dxctable mt-30">
					        <thead>
					          	<tr>
					          	<!-- 	<th>
					          			<div class="form-check">
							                <label class="form-check-label">
							                	<input type="checkbox" class="form-check-input form-check-input-all">
							                	<span class="form-check-sign">
			                                        <span class="custom-check check"></span>
			                                    </span>
							                </label>
							            </div>
					          		</th> -->
						            <th scope="col">DXC</th>
						            <th scope="col">Available Data Sources</th>
						            <th scope="col">Status</th>
												<th scope="col"></th>
												<th scope="col"></th>
					          	</tr>
					        </thead>
					        <tbody>
									
					        	@if(count($dxcs)>0)
											@foreach($dxcs as $key=>$dxc)
											@php 
												$now = strtotime(date('Y-m-d H:i:s'));
												$lastsync =  $dxc->latestSync;
												$seconds_diff = $now - $lastsync;
												$diff_min = $seconds_diff/60;
											@endphp
											
											<?php if($dxc->acceptanceStatus=='ACCEPTED') { ?>
					          	<tr class="enabled-background">
											<?php }else if($dxc->acceptanceStatus=='PENDING') { ?>
					          		<tr class="pending-background">
											<?php }else { ?>
					          		<tr class="disabled-background">
											<?php } ?>
						            <!-- <td>
											<div class="form-check">
															<label class="form-check-label">
																	<input type="checkbox"  name='host' value='<?=$dxc->host?>' class="form-check-input">
																	<span class="form-check-sign">
																								<span class="custom-check check"></span>
																						</span>
																</label>
														</div>
													</td> -->
						            <td>{{$dxc->host}}</td>
						            <td><!-- <a href="#"> -->{{count($dxc->datasources)}}<!-- </a> --></td>
											<td>
												@if($dxc->acceptanceStatus=="ACCEPTED")
														@if($diff_min <= 120)
															<div class=' dot-success green-dot center-align'></div>
														@else
															<div class=' dot-error inactive-dot center-align'></div>
														@endif
												@else
														<div class='dot-error pending-dot center-align'></div>
												@endif
											</td>
						        	<td>
												
											<div class="custom-control custom-switch">
												@if($dxc->acceptanceStatus=="ACCEPTED")
													<input type="checkbox" class="custom-control-input " id="customSwitch<?=$key?>" onclick='toggleDxcStatus(&quot;<?=$dxc->host?>&quot;,0)'  checked>
												@else
													<input type="checkbox" class="custom-control-input" id="customSwitch<?=$key?>" onclick='toggleDxcStatus(&quot;<?=$dxc->host?>&quot;,1)'>
												@endif
												<label class="custom-control-label" for="customSwitch<?=$key?>">
												@if($dxc->acceptanceStatus=="ACCEPTED")						        												
													<span>Authorized</span>
														@elseif($dxc->acceptanceStatus=="PENDING")
													<span>Pending</span>
														@else
													<span>Disabled </span>
														@endif	
												</label>
											</div>
											
											</td>
											<td>
												<a class='btn btn-sm btn-danger accept-btn ' href="<?=$dxc->host?>">Access DXC </a>
											</td>
								
					          	</tr>
					          		@endforeach
					          	@endif
					        </tbody>
				      	</table>
					</div>
				</div>			
			</div>						
		</div>
												
		<div class='row blog-content dxcblog dxc-overview' > 
				<div class="nav-tabs-wrapper mt-30">
			                <ul class="nav nav-tabs">
			                	
			                    <li class="nav-item">
			                        <a class="nav-link active" href="#overview">{{ trans('pages.overview') }}</a>
			                    </li>
			                    
			                    <li class="nav-item">
			                        <a class="nav-link" href="#features_capacities">{{ trans('pages.features_capacities') }}</a>
			                    </li>
			                    
			                    <li class="nav-item">
			                        <a class="nav-link" href="#faq">{{ trans('pages.faq') }}</a>
			                    </li>
			                    
			                    <li class="nav-item">
			                        <a class="nav-link" href="#tech_support">{{ trans('pages.tech_support') }}</a>
			                    </li>
			                    
			                </ul>
					</div>
					<div class="link-content col-md-12" >
								<div id='overview'>
											<h4>{{ trans('pages.overview') }}</h4>
											<div class="app-monetize-section-item0 ml-0 dxc-item0"></div>
											<table class="table dxctable mt-30">
											<thead>
													<tr>											
														<th scope="col">Version</th>
														<th scope="col">Platform</th>
														<th scope="col">What's New</th>
														<th scope="col">Installation </th>
													</tr>
											</thead>
											<tbody>
											@foreach($dxc_versions as $version)
													<tr>
														<td> {{$version->version}} </td>
														<td>{{$version->plotform}}</td>
														<td>{{$version->whats_new}}</td>
														<td>														
															<a class='dxc-action' href="{{ asset($version->instruction_path)}}" download> Instructions</a>
															<a class='dxc-action' href="{{asset($version->setup_file_path)}}" download> Setup Files</a>
														</td>
													</tr>
											@endforeach																					
										</tbody>
											
								</table>
									<p class='para'>

									The Data eXchange Controller is the on-premises DXC software. Installed on the data
										provider’s system, it allows data to be safely and securely transferred from the seller to the
										buyer with just a few clicks.									
									</p>
									<p class='para'>

									The DXC provides connectivity and visibility to your data. By using unique IDs for each
										specific data ‘product’, the DXC opens a gateway allowing the buyer to access only the
										product(s) they have purchased, while keeping your database secured. This creates an
										extra layer of trust. Data always remains on your premises, and stays under your complete
										control.
									</p>
														
									</div>
								<div  id='features_capacities' class="mt-30" id="overview ">
								
										<h4>{{ trans('pages.features_capacities') }}</h4>
										<div class="app-monetize-section-item0 ml-0 dxc-item0"></div>
										<ol class=' mt-30'>

														<li>	
														<p class='para'><b>Easy installation and seamless integration through APIs</b></p>
															
														<p class='para'>

															The DXC software is easily and remotely deployable on your premises. <b>Designed to reduce
																			your DXC deployment time, the data exchange connectivity is automatically
																			established right after the software is installed.</b> Also, tailored to fit any IT environment, it
																			can run on any premises, sensors, servers, hardwares, IoT platforms.
															</p>
														</li>
														<li>	
														<p class='para'><b>Manages all aspects of your data transaction</b></p>
															
														<p class='para'>

																	Once the DXC is up and running, data products are valid for purchase. The DXC offers
																	capabilities <b>to access</b> the right “ready-to-purchase” data product(s), <b>manage</b> and <b>keep
																	track of data transfer </b> directly on the data provider’s premises.
															</p>
														</li>
														<li>	
														<p class='para'><b>High performance and scalability</b></p>
															
														<p class='para'>

																The DXC lets you achieve more with less. Designed to support multiple data sources and
																large data volumes, to top it all off, the DXC can be distributed across multiple locations
																(sensors, servers, etc.). A mix of high performance and scalability results in enhanced
																efficiency, and a single data transfer system.
															</p>
														</li>
										</ol>
												
								</div>
								<div id='faq' class='mt-30'>
											<h4>{{ trans('pages.faq') }}</h4>
											<div class="app-monetize-section-item0 ml-0 " ></div>
											<div style='margin-bottom:30px'></div>
												<div id="accordion" >
														<div class="card accordion">
															<div class="card-header" id="headingOne">
																<h5 class="mb-0">
																	<button  class="btn btn-link faq-btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																			1. How do I make a data product available for purchase?
																	</button>
																</h5>
															</div>

															<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
																<div class="card-body">
																		<p class='para'>Once you have published a data product on the marketplace, there is still one step
																					needed to make it available for purchase: mapping the data product with the related
																									data source you have declared in the Data eXchange Controller (DXC).</p>
																		<p class='para'>This is done using a unique product ID. Note that the DXC needs to be running.</p>
																</div>
															</div>
														</div>
														<div class="card accordion">
															<div class="card-header" id="headingTwo">
																<h5 class="mb-0">
																	<button class="btn btn-link faq-btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
																		2. How data is transferred from the data provider to the buyer?
																	</button>
																</h5>
															</div>
															<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
																<div class="card-body">
																		<p class='para'>
																			Databroker provides a secure and controlled way to share your data without passing via
																			an intermediary. This is made possible thanks to a small piece of software, known as a
																				Data eXchange Controller (DXC).</p>
																		<p class='para'>Unless your data product is free of charge and you provide a direct link (URL) to data
																				users, use of the DXC is mandatory.

																		</p>
																</div>
															</div>
														</div>
														<div class="card accordion">
															<div class="card-header" id="headingThree">
																<h5 class="mb-0">
																	<button class="btn btn-link faq-btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
																		3. How do I know when I’ve sold data?
																	</button>
																</h5>
															</div>
															<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
																<div class="card-body">
																	<p class='para'>

																				When a buyer has purchased one of your data products, you will receive an email
																					confirmation with the buyer information, details of the data product sold and the price.
																					You can also find this information in the My sales section of your account.
																	</p>
																</div>
															</div>
														</div>
													</div>											
							</div>
							<div id='tech_support' class='mt-30'>
											<h4>{{ trans('pages.tech_support') }}</h4>
											<div class="app-monetize-section-item0 ml-0 " ></div>
											<div style='margin-bottom:30px'></div>
											<p class='para'>If you face any challenge, please email us at <a href="javascript:void(0)">support@databroker.global </a> and we would be happy to help. </p>
									</div>
			
					</div>
		</div>
	</div>
</div>


<div class="modal fade" id="showKeyModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">     
				<h3 class="h3" id='title'></h3>   
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p class="para text-center" id="showkey" style="overflow-wrap: break-word;word-break:break-all"></p>    
      </div>            
      <div class="modal-footer text-left" style="margin:auto">             
        <button type="button" class="button secondary-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
		<script src="{{ asset('js/copy_data.js') }}"></script>
    <script type="text/javascript">
    	$(".form-check-input-all").change(function(e){
    		$(".form-check-input").prop('checked', $(this).prop('checked'));
    	});
    	$(".form-check-input").change(function(e){
    		if(!$(this).prop('checked'))
    			$('.form-check-input-all').prop('checked', false);
    	});
    	$(".btn-newKey").click(function(){
    		var address = $("#address").val();
    		swal({
			    title: "Are you sure to generate a new key?",
			    text: "You will need to update all running DXC's after you confirm.",
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
			      	$.ajax({
				        headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        },
				        url: '/dxc/updateApiKey/'+address,
				        method: 'get',
				        success: function(res){
				          if(res == "success"){
				            window.location.href = "/dxc";
				          }
				        }
			      	});
			    }
			});
    	});
		
			function updateHosts(){

				 $('#accept').attr('disabled',true).css('cursor','not-allowed');
				let hosts = [];
				$. each($("input[name='host']:checked"), function(){
						hosts.push($(this).val());
				});
				console.log(hosts);
				$.ajax({
				        headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        },
				        url: '/dxc/updateDxcStatus',
								type: 'POST',
								data:{dxcs:hosts},
				        success: function(res){
				          if(res == "success"){
				            window.location.href = "/dxc";
				          }
				        }
			  });



			}
	function toggleDxcStatus(host,status){

		console.log(host,status);
				$.ajax({
				        headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        },
				        url: '/dxc/updateDxcStatus',
								type: 'POST',
								data:{dxc:host,status:status == 1 ? true : false},
				        success: function(res){
				          if(res == "success"){
				            window.location.href = "/dxc";
				          }
				        }
			  });

	}
	
    </script>
@endsection