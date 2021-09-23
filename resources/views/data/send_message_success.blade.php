@extends('layouts.data')

@section('title', 'Message has been sent | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
            	<div class="success-msg">
                    <h1 class="text-primary text-center text-bold">Your message to {{ $seller['companyName'] }} has been sent successfully</h2>
					<p class="para text-center text-bold">{{trans('data.received_success')}}</p>
                </div>
                <div class="form-group row mb-0">                        
                    <div class="col-md-4">                                
                    </div>
                    <div class="col-md-4">                    
                        @php
                            $companyName = $offer['company_slug'];
                            $title = $offer['offer_slug'];
                            $region = "";
                            foreach($offer['region'] as $key=>$r){
                                $region = $region . $r->slug;
                                if($key+1 < count($offer['region'])) $region = $region . "-";
                            }
                        @endphp            
                        <a href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region])}}"><button class="customize-btn">{{ trans('data.continue') }}</button></a>
                    </div>
                    <div class="col-md-4">                                
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection