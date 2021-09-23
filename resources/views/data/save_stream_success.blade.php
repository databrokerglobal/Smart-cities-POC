@extends('layouts.data')

@section('title', 'You have been configured stream details | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
            	<div class="success-msg">
					<h1 class="text-primary text-center text-bold">{{trans('data.save_stream_success')}}</h1>
                	
                	<a href="{{route('account.purchases')}}">
                		<button type="button" class="customize-btn">Go to my purchases</button>
                	</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection