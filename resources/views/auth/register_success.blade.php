@extends('layouts.data')

@section('content')
<style>
	.success-img{
		height: 100px;
		width: 100px;
		margin: 0 auto;
		display: table;
	}
</style>
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="row justify-content-center mt-30 auth-section">
            <div class="col-md-8">
				
            	<div class="success-msg">
					<img class="success-img" src={{asset('images/success.jpg')}}>
					@if (session('resent'))
                        <div class="alert alert-success para" role="alert">
                            {{ __('New verification link has been sent to your email address.') }}
                        </div>
                    @endif
					<h2 class="text-primary text-center text-bold"> Registration completed successfully </h1>
					<p class='para'>Please check your registered email for email verification.</p>
					<p class='para'>{{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button style='color: blue;text-decoration: underline' type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click here to resend the verification mail') }}</button>.
                    </form> </p>                						
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('additional_javascript')
	<script>	
		$(document).ready(function(){			
			setTimeout(() => {
				$('.alert').css('display','none')
			}, 2000);
		});
	</script>
	<script>
	var data = <?=session('hubspot_signup_data') != null ? session('hubspot_signup_data'): '';?>;
	if(data != ''){
	var formdata = {                
                "fields": [                   
                    {
                    "name": "company",
                    "value": data['company']
                    },
                    {
                    "name": "lastname",
                    "value": data['lastname']
                    },
                    {
                    "name": "firstname",
                    "value": data['firstname']
                    },
                    {
                    "name": "email",
                    "value": data['email']
                    },
                    {
                    "name": "country",
                    "value": 'na'
                    },
                    {
                    "name": "industry",
                    "value": data['industry']
                    },
                    {
                    "name": "jobtitle",
                    "value": data['jobtitle']
                    },

                ]                        
            };
			$.ajax({
                method:'post',
                url : 'https://api.hsforms.com/submissions/v3/integration/submit/8639589/88010ef4-894d-4e95-aec0-a415512086e3',
                // Example request JSON:
                contentType: 'application/json',
                dataType:'json',
                data: JSON.stringify(formdata),
                success:function(response){					
					<?php
						Session::forget('hubspot_signup_data.');
					?>;					
                },
                error:function(status){
                    console.log(status);
                }
			});
	}
</script>
@endsection