@extends('auth.auth_app')

@section('title', 'Wallet | Databroker ')

@section('content')

<div class="transak-frame">
<!-- Staging -->
<iframe id="transak" height="720" title="Transak On/Off Ramp Widget (Website)" src="{{TRANSAK_PAYMENT_URL}}?apiKey={{TRANSAK_API_KEY}}&defaultCryptoCurrency=ETH&fiatCurrency=GBP&fiatAmount=8&network=polygon&cryptoCurrencyCode=USDT&walletAddress={{TRANSAK_WALLET_ADDRESS}}&hostURL={{route('home')}}&redirectURL={{route('account.transak.success')}}&defaultPaymentMethod=credit_debit_card&disableWalletAddressForm=true&exchangeScreenTitle=Buy Data From Databroker Instantly" frameborder="no" allowtransparency="true" allowfullscreen="" style="display: block; width: 100%;"></iframe>
</div>
@endsection
@section('additional_javascript')  
<script>
$(document).ready(function(){
});
</script>
@endsection