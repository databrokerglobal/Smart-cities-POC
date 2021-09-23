@extends('layouts.data')

@section('title', 'Respond to bid | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
            	<div class="success-msg">
					<h1 class="text-primary text-center text-bold">{{trans('data.bid_responded_success', ['company' => $buyer->companyName])}}</h1>
                	<p>You can follow up on all bids received <a href="{{ route('profile.seller_bids') }}">in your account</a></p>
                	<a href="{{ route('profile.seller_bids') }}">
                		<button type="button" class="customize-btn">CONTINUE</button>
                	</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection