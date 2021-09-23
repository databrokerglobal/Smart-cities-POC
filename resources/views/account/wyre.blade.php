@extends('layouts.app')

@section('title', 'Wallet | Databroker ')

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
                    left: -16px;                }
            }
			
    </style>
@endsection
<div class="container-fluid app-wapper profile" ng-app="myApp" ng-controller="myCtrl">
	<div id="wallet" class="app-section app-reveal-section align-items-center">
	    <div class="top-bg-image"></div>
	    
		<div class="container">           
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-title text-primary">Wyre - Card Processing</div>

                    <p> Please submit the button below to make payment.</p>
                </div>
                                                              
            </div>
            <br/>
                <div class="row">
                      @if(isset($cardResponse))
                      <div class="response_data"> 
                        Last transaction response:                                          
                      <?php
                          echo "<pre><strong>Card Processing Response:</strong>"; print_r($cardResponse);
                          echo "<pre><strong>Authorize Response:</strong>"; print_r($authorizeResponse);
                          echo "<pre><strong>Auth Code Response:</strong>"; print_r($authCodeResponse);

                      ?>
                       </div>
                      @endif
                </div>
           
            <form method="POST" action="{{ route('account.wyre.makepayment') }}" autocomplete="off">
                        @csrf
                       @if(isset($cardDetails)) 
                       <?php     
                              $card = $cardDetails; 
                                                    
                                  $number   =    isset($card['debitCard']['number']) ? $card['debitCard']['number'] : "";
                                  $year     =    isset($card['debitCard']['year']) ? $card['debitCard']['year'] : "";
                                  $month    =    isset($card['debitCard']['month']) ? $card['debitCard']['month'] : "";
                                  $cvv      =    isset($card['debitCard']['cvv']) ? $card['debitCard']['cvv'] : "";                      
                              ?>
                            <div class="row">
                                  <div><label for="ContractDate">Card Number: </label> <span>   {{$number}}</span></div>
                            </div>
                            <div class="row">
                                  <div><label for="ContractDate">Card Month/Year: </label> <span>   {{$month}}/{{$year}}</span></div>
                            </div>
                            
                            <div class="row">
                                  <div><label for="ContractDate">Card CVV: </label> <span>   {{$cvv}}</span></div>
                            </div>
                                                     
                            <?php    

                              $street1    =   isset($card['address']['street1']) ? $card['address']['street1'] : ""; 
                              $city       =   isset($card['address']['city']) ? $card['address']['city'] : ""; 
                              $state      =   isset($card['address']['state']) ? $card['address']['state'] : ""; 
                              $postalCode  =  isset($card['address']['postalCode']) ? $card['address']['postalCode'] : "";   
                              $country    =   isset($card['address']['country']) ? $card['address']['country'] : "";                              
                              ?>
                              <div class="row"><div><label for="ContractDate">Address Street1: </label> <span>   {{$street1}}</span></div></div>
                              <div class="row"><div><label for="ContractDate">Address City: </label> <span>   {{$city}}</span></div></div>
                              <div class="row"><div><label for="ContractDate">Address State: </label> <span>   {{$state}}</span></div></div>
                              <div class="row"><div><label for="ContractDate">Address PostalCode: </label> <span>   {{$postalCode}}</span></div></div>
                              <div class="row"><div><label for="ContractDate">Address Country: </label> <span>   {{$country}}</span></div></div>
                            
                              <div class="row">
                                  <div><label for="ContractDate">reservationId: </label> <span>  {{isset($card['reservationId']) ? $card['reservationId'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">amount: </label> <span>  {{isset($card['amount']) ? $card['amount'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">sourceCurrency: </label> <span>  {{isset($card['sourceCurrency']) ? $card['sourceCurrency'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">destCurrency: </label> <span>  {{isset($card['destCurrency']) ? $card['destCurrency'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">dest: </label> <span>  {{isset($card['dest']) ? $card['dest'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">referrerAccountId: </label> <span>  {{isset($card['referrerAccountId']) ? $card['referrerAccountId'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">givenName: </label> <span>  {{isset($card['givenName']) ? $card['givenName'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">familyName: </label> <span>  {{isset($card['familyName']) ? $card['familyName'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">email: </label> <span>  {{isset($card['email']) ? $card['email'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">phone: </label> <span>  {{isset($card['phone']) ? $card['phone'] : ""}}</span></div>
                              </div>
                              <div class="row">
                                  <div><label for="ContractDate">referenceId: </label> <span>  {{isset($card['referenceId']) ? $card['referenceId'] : ""}}</span></div>
                              </div>
                              
                          

                        <div class="row">
                            <div class="col info-text flex-vend">
                                <button type="submit" class="customize-btn">Make Payment</button>
                            </div>
                        </div>
                        @endif
                    </form>

            
             
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
				<p class="para text-center" id="showkey" style="overflow-wrap: break-word;"></p>    
      </div>            
      <div class="modal-footer text-left" style="margin:auto">             
        <button type="button" class="button secondary-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('additional_javascript')    
	<script src="{{ asset('js/copy_data.js') }}"></script>
@endsection