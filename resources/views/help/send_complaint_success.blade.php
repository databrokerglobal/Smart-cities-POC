@extends('layouts.data')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8" id="file-complaint-success-msg">
            	<div class="success-msg">
                    <h1 class="text-primary text-center text-bold">We have received your complaint.</h1>
					<h4 class="text-center text-bold">A member of the Databroker team will contact you shortly.</h4>
                </div>
                <div class="form-group row mb-0">                        
                    <div class="col-md-4">                                
                    </div>
                    <div class="col-md-4">                                
                        <a href="{{ route('help.file_complaint') }}"><button class="customize-btn">{{ trans('data.continue') }}</button></a>
                    </div>
                    <div class="col-md-4">                                
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection