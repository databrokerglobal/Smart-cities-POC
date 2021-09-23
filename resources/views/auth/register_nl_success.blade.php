@extends('layouts.data')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
            	<div class="success-msg">
					<h1 class="text-primary text-center text-bold">You successfully signed up for our NewsBytes.</h1>
                	<h4 class="text-bold">The latest {{APPLICATION_NAME}} updates delivered straight in your inbox!</h4>
					<div class="buttons flex-vcenter">
	                    <a href="{{(strpos($next_url, 'register_nl') !== false || !isset($next_url))? route('home'): $next_url}}">
	                    	<button type="button" class="customize-btn btn-next">Continue</button>
	                    </a>
	                </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection