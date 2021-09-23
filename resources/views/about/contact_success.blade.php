@extends('layouts.data')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
            	<div class="success-msg">
					<h1 class="text-primary text-center text-bold">{{trans('contact.received_success')}}</h1>
				</div>
				<div class="row">
					<div class="col-md-4">
					</div>
					<div class="col-md-8">
						<a href="{{route('account.wallet')}}">
							<button type="button" class="customize-btn btn-next">Go To Wallet Page</button>
						</a>
					</div>
				</div>
			</div>
			
		</div>
		
	</div>
</div>
@endsection