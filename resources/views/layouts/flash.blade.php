<div class="flash-alert-msg">
	@if(Session::has('flash_success'))
	<div class="alert jq-auto-hide alert-success alert-dismissable m-t-20">	
		<i class="icon fa fa-check"></i>
		{{Session::get('flash_success')}}
	</div>
	@endif

	@if(Session::has('flash_error'))
	<div class="alert jq-auto-hide alert-danger alert-dismissable m-t-20">	
		<i class="icon fa fa-ban"></i>
		{{Session::get('flash_error')}}
	</div>
	@endif

	@if(Session::has('flash_error_no_hide'))
	<div class="alert alert-danger alert-dismissable m-t-20">	
		<i class="icon fa fa-ban"></i>
		{{Session::get('flash_error_no_hide')}}
	</div>
	@endif
</div>