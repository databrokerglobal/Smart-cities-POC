@extends('layouts.data')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
            	<div class="success-msg">
					<h1 class="text-primary text-center text-bold">Email Verified Successfully.</h1>                	
					<div class="buttons flex-vcenter">
	                    <a href="{{route('register_nl')}}">
	                    	<button type="button" class="customize-btn btn-next">Continue</button>
	                    </a>
	                </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection