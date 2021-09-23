@extends('layouts.app')

@section('title', 'Account and profile info | Databroker')
@section('description', '')

@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fl.uid app-wapper myaccount">
    <div class="bg-pattern1-left"></div>
	<div class="app-section app-reveal-section align-items-center">	    
		<div class="container">
        <h3><b>My Dashborad</b></h3>
        <br>
        <div class='row'>
            <div class='col-md-4'>
                <div class="label ">
                    <span><b>Administrator:</b> </span>
                        <span class="">{{$admin->firstname}} {{$admin->lastname}}</span>
                    </div>
            </div>
            <div class='col-md-4'>
                <div class="label companyname1">
                    <span><b>Account name: </b> </span>
                    <span class="">{{$company->companyName}}</span>
                </div>
            </div>
           
        
        </div>
                                
                                
            <div class='row myaccount'>
                    
                    <div class='col-md-4'>                       
                            <div class="blog-header myaccount">
                                <h3 class='header'>{{ trans('home.me_buyer') }}</h3>
                                @if(count($bids) || count($purchases))
                                    <h5> {{ trans('home.me_buyer') }} </h5>
                                    @if(count($bids))
                                    <a class="dropdown-item" href="{{ route('profile.buyer_bids') }}"> {{ trans('home.bids_sent') }} </a>
                                    @endif
                                    @if(count($purchases))
                                    <a class="dropdown-item" href="{{ route('account.purchases') }}"> {{ trans('home.purchases') }} </a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                @endif
                            </div>
                    </div>
                    <div class='col-md-4'>                       
                            <div class="blog-header myaccount">
                                    <h3 class='header'>{{ trans('home.me_seller') }}</h3>
                                    <a class="dropdown-item" href="{{ route('account.company') }}"> {{ trans('home.company_profile') }} </a>
                                    <a class="dropdown-item" href="{{ route('dxc.data_exchange_controller') }}"> {{ trans('home.data_exchange_controller') }} </a>
                                    <a class="dropdown-item" href="{{ route('data_offers_overview' )}}"> {{ trans('home.my_data_offers_and_products') }} </a>
                                    @php
                                    $products = \App\Models\OfferProduct::join('offers', 'offers.offerIdx', '=', 'offerProducts.offerIdx')
                                                                        ->join('providers', 'providers.providerIdx', '=', 'offers.providerIdx')
                                                                        ->join('users', 'users.userIdx', '=', 'providers.userIdx')
                                                                        ->where('users.userIdx', Auth::user()->userIdx)
                                                                        ->get();
                                    $sales = \App\Models\Sale::where('sellerIdx', Auth::user()->userIdx)->get();
                                    @endphp
                                    @if(count($products))
                                    <a class="dropdown-item" href="{{ route('profile.seller_bids') }}"> {{ trans('home.bids_received') }} </a>
                                    @endif
                                    @if(count($sales))
                                    <a class="dropdown-item" href="{{ route('account.sales') }}"> {{ trans('home.my_sales') }} </a>
                                    @endif
                            </div>
                    </div>
                    <div class='col-md-4'>                       
                            <div class="blog-header myaccount">
                                
                                <h3 class='header'>Account info</h3>
                                
                                <a class="dropdown-item" href="{{ route('account.profile') }}"> {{ trans('home.account_profile_info') }} </a>
                                <a class="dropdown-item" href="{{ route('account.wallet') }}"> {{ trans('home.wallet') }} </a>
                                
                            </div>
                    </div>
            </div>
            
		</div>
	</div>
</div>


@endsection

@section('additional_javascript')    
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var path = window.location.search;
            console.log(path);
            if(path.split("?")[1]){
                var im = path.split("?")[1].split('=')[1];
                if(im==1) $("#inviteBtn").trigger('click');
            }
            $("input[name='password']").on("keyup", function(e){
                var has8letters = false;
                var hasupperletter = false;
                var hasdigit = false;
                var text = $(this).val();
                if(text.length >= 8) has8letters = true;
                else has8letters = false;
                if(text.length!=0){
                    for(var i=0; i<text.length; i++){
                        if(text[i]>='A' && text[i]<='Z')
                            hasupperletter = true;
                        if(text[i]>='0' && text[i]<='9')
                            hasdigit = true;
                    }
                }
                if(has8letters) $(this).siblings('.feedback').find('.has8letters').addClass('passed');
                else $(this).siblings('.feedback').find('.has8letters').removeClass('passed');
                if(hasupperletter) $(this).siblings('.feedback').find('.hasupperletter').addClass('passed');
                else $(this).siblings('.feedback').find('.hasupperletter').removeClass('passed');
                if(hasdigit) $(this).siblings('.feedback').find('.hasdigit').addClass('passed');
                else $(this).siblings('.feedback').find('.hasdigit').removeClass('passed');
                if(has8letters && hasupperletter && hasdigit) $(this).siblings('.feedback').addClass('text-green');
                else $(this).siblings('.feedback').removeClass('text-green');
            });
            $("input[name='password_confirmation']").on("keyup", function(e){
                var password = $("input[name='password']").val();
                var confirm = $(this).val();
                console.log(password.indexOf(confirm));
                if(confirm == password) {
                    $(this).siblings('.feedback').html("<strong class='text-green'>Passwords match.</strong>");
                }else if(password.indexOf(confirm)){
                    $(this).siblings('.feedback').html("<strong class='text-red'>Passwords do not match.</strong>");
                }else{
                    $(this).siblings('.feedback').html("<strong class='text-red'></strong>");
                }
            });
        })
    </script>
@endsection