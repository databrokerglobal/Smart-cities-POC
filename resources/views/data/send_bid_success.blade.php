@extends('layouts.data')

@section('title', 'Bid has been sent | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
            	<div class="success-msg">
					<h1 class="text-primary text-center text-bold">{{trans('data.bid_send_success')}} {{$companyName}}</h1>
                	<h4 class="text-center text-bold">You'll receive an email when they respond to your bid.<br/>Remember that you can also follow up on your bids in the <a href="{{route('profile.buyer_bids')}}">Bids sent</a> section of your account.</h4>
                    @php
                        $companyName = $offer['company_slug'];
                        $title = $offer['offer_slug'];
                        $region = "";
                        foreach($offer['region'] as $key=>$r){
                            $region = $region .$r->slug;
                            if($key+1 < count($offer['region'])) $region = $region . "-";
                        }
                    @endphp
                	<a href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region])}}">
                		<button type="button" class="customize-btn">{{trans('data.continue')}}</button>
                	</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection