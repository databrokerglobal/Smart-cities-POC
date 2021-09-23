@extends('layouts.app')

@section('title', 'Wallet | Databroker ')

@section('content')
<div class="container-fluid app-wapper profile" ng-app="myApp" ng-controller="myCtrl">
	<div id="wallet" class="app-section app-reveal-section align-items-center">
	    <div class="top-bg-image"></div>
	    
		<div class="container">           
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-title text-primary">Transak - Payment Processing</div>

                    <p> Please make payment.</p>
                </div>
                                                              
            </div>             
		</div>
	</div>
</div>
@endsection

@section('additional_javascript')    
<script src="https://global.transak.com/sdk/v1.1/widget.js" async></script>
<script>
    function launchTransak() {
      let transak = new TransakSDK.default({
        apiKey: '{{TRANSAK_API_KEY}}', // Your API Key
        environment: '{{TRANSAK_ENV}}', // STAGING/PRODUCTION
        defaultCryptoCurrency: 'ETH',
        walletAddress: '{{TRANSAK_WALLET_ADDRESS}}', // Your customer wallet address
        themeColor: '#7EF5DD', // App theme color in hex
        fiatCurrency: 'EUR', // INR/GBP
        fiatAmount: 9,
        networks: 'polygon',        
        cryptoCurrencyCode: 'USDT',
        defaultPaymentMethod : 'credit_debit_card',
        disableWalletAddressForm: true,
        email: 'viktor@settlemint.com', // Your customer email address
        redirectURL: '{{route('account.transak.success')}}',
        hostURL: window.location.origin,
        widgetHeight: '580px',
        widgetWidth: '100%',
        exchangeScreenTitle : 'Buy Data From Databroker Instantly'
      });
      transak.init();
      // To get all the events
      transak
        .on(transak.ALL_EVENTS, (data) => {
          console.log(data)
        });
      // This will trigger when the user marks payment is made.
      transak.on(transak.EVENTS.TRANSAK_ORDER_SUCCESSFUL, (orderData) => {
        console.log(orderData);
        //transak.close();
      });
    }
    window.onload = function() {
      launchTransak()
    }
  </script>
@endsection