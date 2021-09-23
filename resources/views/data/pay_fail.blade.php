@extends('layouts.data')

@section('title', 'Payment was failed | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="app-section app-reveal-section align-items-center">
        	<div class="row blog-header">
                <div class="col-md-12">
        			<h1>{{trans('data.payment_fail')}}</h1>
                	<p class="para text-bold">{{$message}}</p>
                </div>
    		</div>
            <div class="row blog-content">
                <a href="{{route('data.buy_data', ['id'=>$id, 'pid'=>$pid])}}">
                    <button type="button" class="customize-btn">Try again</button>
                </a>
            </div>
		</div>
	</div>
</div>
@endsection