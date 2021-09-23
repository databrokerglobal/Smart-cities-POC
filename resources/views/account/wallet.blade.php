@extends('layouts.app')

@section('title', 'Wallet | Databroker')

@section('content')

@section('additional_css')
   
    <style type="text/css">
   		    
            .wallet-btn{
                height: 33px;
                padding-top: 3%;
                background:#EBF0F4 !important;
                display: inline-block;
            }
            .contact-btn{
                height: 33px;
                padding-top: 0.8%;
                background: #78E6D0 !important;
                color: black !important;
                margin-left: 1% !important;
                display: inline-block;
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
				left: -85px;
				color: #FF6B5B !important;
			}
			.key-sub-title{
				color: #FF6B5B !important;
			}
			#copy{
				color:green;font-size:13px;text-align: center;
			
            	display:none;
			}
            @media (min-width: 768px){
                .btn-newKey{                   
                    left: -16px;            
                 }
            }
			
    </style>
@endsection
<div class="container-fluid app-wapper profile" ng-app="myApp" ng-controller="myCtrl">
	<div id="wallet" class="app-section app-reveal-section align-items-center">
	    <div class="top-bg-image"></div>
	    
		<div class="container">
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-title text-primary">{{ trans('pages.wallet') }}</div>
                    <div class="label">
                        <span>Welcome to your {{APPLICATION_NAME}} Wallet. Here you will be able to manage your funds collected, export them via our redemption features and check your transaction history.</span>
                    </div>
                    <li class="more_dropdown">
                        <a href="javascript:void(0);" class="more_info">More Info <i class="material-icons">arrow_drop_down</i>
                            <i class="material-icons open">arrow_drop_up</i>
                        </a>
                        <div>You can also check your Total values in DTX and Euro as well as filling your wallet and exporting it to Apps and cold storage devices.</div>
                    </li>
                </div>                                              
            </div>
            <div class="row mt-40">
                <div class="col-lg-12">
                <p id='copy' style=''>  Copied to clipboard</p>
                <div class="row account-section">

                        <div class="col-md-8">
                                <div class="row"> 
                                    <div class="col-md-4  col-12 col-sm-12 dxc-lable-div">
                                            <!-- <span class='dxc-label'>Account ID:</span> -->
                                            <h4 class="dxc-label key-sub-title"> WALLET ADDRESS:</h4>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                            <a type="button" onclick='copykey(&quot;<?=$address?>&quot;,this)' class="button customize-btn customize-button-copy mgh25">Copy </a>
                                            
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                            <a type="button"  onclick="showKey(&quot;<?=$address?>&quot;,&quot;WALLET ADDRESS:&quot;)" class="button customize-btn customize-button-copy mgh25">Show </a>
                                            
                                    </div>
                                </div>                            
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4 col-12 col-sm-12 dxc-lable-div">
                                            <!-- <span class='dxc-label'>DXC KEY:</span> -->
                                            <h4 class="dxc-label key-sub-title"> API KEY:</h4>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                            <a type="button" onclick='copykey(&quot;<?=$apiKey?>&quot;,this)' class="button customize-btn customize-button-copy mgh25">Copy </a>
                                            
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-6">
                                            <a type="button" onclick="showKey(&quot;<?=$apiKey?>&quot;,&quot;API KEY:&quot;)" class="button customize-btn customize-button-copy mgh25">Show </a>
                                            
                                    </div>  
                                </div>                           
                            </div>
                        </div>
                   
                    <div class="wallet_fill">
                        <a type="button" class="button customize-btn wallet-btn  mgh25">Fill wallet </a>                        
                    </div>
                    <span class="hr-h text-grey">|</span>
                    <div class="wallet_fill">                        
                        <a type="button" class="button customize-btn wallet-btn  mgh25">Export wallet </a>
                    </div>                    
                </div>
                <div class="col-md-12">
                    <div class="label">For redeeming your balance please contact Databroker's Commercials Team.</div>
                </div>
                
                <a class="button customize-btn mgh25 contact-btn " href="{{route('contact_commercial_team')}}">Contact Commercials Team</a> 
                
            </div>

            <div class="row mt-30">
                <div class="col-lg-12">
                    <div class="flex-row">
                        <span class="fs-30 text-bold"> Total value of your wallet: </span>
                        <span class="text-warning fs-30 text-bold ml-15">DTX {{$balance->availableDTX}} / € {{$balance->availableEUR}}</span>
                    </div>
                </div>    
            </div>
            
			<div class="app-monetize-section-item0 ml-0 mt-30"></div>

            
			<div id="transactions" class="row">
                <div class="col-lg-10 col-12">
                    <h2 class="fs-30 text-bold">
                        <span>{{ trans('pages.transactions') }}</span>
                    </h2>                        
                    <table class="table">                      
                      <tbody>
                        @if(count($transactions) > 0)
                            @foreach($transactions as $transaction)
                            
                        <tr>                          
                            <td>{{date('d/m/Y H:i:s', strtotime($transaction->updatedAt))}}</td>
                            @if($transaction->amount > 0)
                            <td class="text-left">
                                <i class="material-icons text-warning">call_made</i><span class="text-warning">IN</span>
                            </td>
                            <td class="text-warning text-right plr-0">€{{number_format((float)$transaction->amount, 2, '.', '')}}</td>
                            <td class="text-warning pl-5 pr-0">({{$transaction->status}})</td>
                            <td class="plr-0">
                            @php
                                $redeem_date = strtotime('+30 days', strtotime($transaction->from));
                                $now = time();
                                $datediff = $redeem_date - $now;
                                $diff = round($datediff / (60*60*24));
                            @endphp
                            @if($transaction->status!="complete" && $transaction->deal_index !='' )
                                <span class="text-grey fs-12">
                                    @if($transaction->isBuyerSatisfiedWithData == 1)
                                        @if($diff < 30)
                                            <a href="{{route('account.sales_redeem', ['sid'=>$transaction->saleIdx])}}">Redeem</a>
                                        @else
                                            <a onclick="alert('Payouts can only happen 30 days after the start of the deal!')" href="#">Redeem</a>
                                        @endif
                                    @elseif($diff <= 0)
                                        <a href="{{route('account.sales_redeem', ['sid'=>$transaction->saleIdx])}}">Redeem</a>
                                    @elseif($transaction->isBuyerSatisfiedWithData == 2)
                                        <a onclick="showcomment('<?=$transaction->buyerComment?>')" href="#">Redeem</a>
                                    @else                                                                        
                                        <a onclick="alert('Payouts can only happen 30 days after the start of the deal!')" href="#">Redeem</a>
                                    @endif
                                    
                                    @if($diff>0)
                                    <span> in {{$diff}} days</span>
                                    @endif
                                </span>
                            @endif
                            </td>
                            @elseif($transaction->amount < 0)
                            <td class="text-left">
                                <i class="material-icons text-grey">call_received</i><span class="text-grey">OUT</span>
                            </td>
                            <td class="text-grey text-right plr-0">- €{{number_format(-(float)$transaction->amount, 2, '.', '')}}</td>
                            <td class="text-grey pl-5 pr-0">({{$transaction->status}})</td>
                            <td class="plr-0">
                            @php
                                $redeem_date = strtotime('+30 days', strtotime($transaction->from));
                                $now = time();
                                $datediff = $redeem_date - $now;
                                $diff = round($datediff / (60*60*24));
                            @endphp
                            @if($transaction->status!="complete" && $transaction->deal_index !='' )
                                <span class="text-grey fs-12">
                                    @if(!$transaction->isBuyerSatisfiedWithData)
                                        <a onclick="showPayoutModal(&quot;<?=$transaction->saleIdx?>&quot;)">Payout</a>                                     
                                    @endif                                   
                                </span>
                            @endif
                            </td>
                            @elseif($transaction->amount == 0)
                                @if($transaction->transactionType=="sold")
                            <td class="text-left">
                                <i class="material-icons text-warning">call_made</i><span class="text-warning">IN</span>
                            </td>
                            <td class="text-warning text-right plr-0">€{{number_format((float)$transaction->amount, 2, '.', '')}}</td>
                            <td class="text-warning pl-5 pr-0">({{$transaction->status}})</td>
                            <td></td>
                                @elseif($transaction->transactionType=="purchased")
                            <td class="text-left">
                                <i class="material-icons text-grey">call_received</i><span class="text-grey">OUT</span>
                            </td>
                            <td class="text-grey text-right plr-0">€{{number_format((float)$transaction->amount, 2, '.', '')}}</td>
                            <td class="text-grey pl-5 pr-0">({{$transaction->status}})</td>
                            <td></td>
                                @endif
                            @endif
                        </tr>                 
                            @endforeach
                        @endif
                      </tbody>
                    </table>    

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

<!-- Modal -->
<div class="modal fade" id="payoutModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form action="#">
            @csrf
                <p id="feedback_staus" style="text-align:center"></p>
                <div class="row">

                    <input type='hidden' name="feedback_saleIdx" id="feedback_saleIdx" value="">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="isBuyerSatisfiedWithData">Are you satisfied with seller data?</label>
                            <select id="isBuyerSatisfiedWithData" name="isBuyerSatisfiedWithData" class="form-control" data-style="warning" require>                            
                                <option value="1">YES</option>
                                <option value="2">NO</option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea  class="form-control input_data" placeholder="Enter your comment"
                             id="buyerComment" name="buyerComment" required></textarea>                                
                        </div>
                        <span style="color:red;display:none" id="err_buyerComment">Please enter your feedback</span>
                    </div>
                </div>                       
            
        </div>
        <div class="modal-footer">
        <button type="button" onclick="saveFeedback()"  class="btn btn-success" >Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
      
    </div>
  </div>
  
  @include('account.buyer_comment');

@endsection

@section('additional_javascript')    
	<script src="{{ asset('js/copy_data.js') }}"></script>
    <script>
        function showPayoutModal(saleIdx){
            $('#feedback_saleIdx').val(saleIdx);
            $('#payoutModal').modal('show');
        }
        function saveFeedback(){

            var saleIdx                  = $('#feedback_saleIdx').val();
            var isBuyerSatisfiedWithData = $('#isBuyerSatisfiedWithData').val();
            var buyerComment             = $('#buyerComment').val();
            var crsf = $("input[name='_token']").val();
            if(buyerComment == ''){
                $('#err_buyerComment').css('display','block');
                error = 1;
            }else{
                $('#err_buyerComment').css('display','none');
            }
            $.ajax({
                type:'post',
                url:'/update-sale-feedback',
                data:{_token: crsf,'saleIdx':saleIdx,'isBuyerSatisfiedWithData':isBuyerSatisfiedWithData,'buyerComment':buyerComment},
                success:function(response){                    
                    if(response){
                        $('#feedback_staus').html('Feedback saved successfully!').css('color','green');
                    }else{
                        $('#feedback_staus').html('Something went wrong please try again!').css('color','green');
                    }
                    $('#payoutModal').modal('hide');
                    window.location.reload();
                    
                },
                error:function(status){                    
                }
            })
        }
       
    </script>
@endsection