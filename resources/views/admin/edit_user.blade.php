@extends('layouts.admin')

@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style type="text/css">
    	.other_industry{display: none;}
    	.other_role{display: none;}
    </style>
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Edit user</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="{{ route('admin.users') }}" class="m-nav__link m-nav__link--icon">
							<i class="m-nav__link-icon la la-home"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
	<div class="m-content">
		<!--begin::Portlet-->
		<div class="m-portlet">

		<div class="col-sm-12 text-right">
			<span class="fields-msg">*
				<em>{{ FIELDS_REQUIRED_MESSAGE }}</em>
			</span>
		</div>

			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right" id="board_form" novalidate="novalidate">
                <input type="hidden" name="userIdx" value="{{ isset($user)? $user->userIdx : 0 }}">
				<div class="m-portlet__body">
					<div class="m-form__content">
						<div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_1_msg">
							<div class="m-alert__icon">
								<i class="la la-warning"></i>
							</div>
							<div class="m-alert__text">
								Oh snap! Change a few things up and try submitting again.
							</div>
							<div class="m-alert__close">
								<button type="button" class="close" data-close="alert" aria-label="Close">
								</button>
							</div>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">First Name </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="firstname" placeholder="First Name" value="{{ isset($user)? $user->firstname : '' }}">
                        </div>
						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Last Name </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="lastname" placeholder="Last Name" value="{{ isset($user)? $user->lastname : '' }}">
                        </div>
                    </div>
					<div class="form-group m-form__group row">
						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Email </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="email" placeholder="Email" value="{{ isset($user)? $user->email : '' }}">
						</div>
						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Job Title </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="jobTitle" placeholder="Enter Job Title" value="{{ isset($user)? $user->jobTitle : '' }}">
						</div>
					</div>
					<div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Industry </label> <span class="red">*</span>
							<select id="businessName2" class="" name="businessName2" placeholder="Which industry are you in?">
                                <option></option>
                            @foreach ($businesses as $business)
                                @if($user->businessName===$business->businessName)
                                <option value="{{$business->businessName}}" selected>{{ $business->businessName }}</option>
                                @else
                                <option value="{{$business->businessName}}">{{ $business->businessName }}</option>
                                @endif
                            @endforeach
                             </select>
						</div>
						<div class="col-md-6 m-form__group-sub other_industry">
							<label class="form-control-label">Other industry </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="businessName" placeholder="Industry" value="{{ isset($user)? $user->businessName : '' }}">
						</div>
                    </div>
					<div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Role </label> <span class="red">*</span>
							<select id="role2" class="" name="role2" placeholder="What role do you have?">
                                <option></option>
                                @if($user->role=='Business')
                                <option value="Business" selected>Business</option>
                                <option value="Technical">Technical</option>
                                <option value="Other">Other</option>
                                @elseif($user->role=='Technical')
                                <option value="Business">Business</option>
                                <option value="Technical" selected>Technical</option>
                                <option value="Other">Other</option>
                                @else
                                <option value="Business">Business</option>
                                <option value="Technical">Technical</option>
                                <option value="Other" selected>Other</option>
                                @endif
                             </select>
						</div>
						<div class="col-md-6 m-form__group-sub other_role">
							<label class="form-control-label">Other role </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="role" placeholder="Role" value="{{ isset($user)? $user->role : '' }}">
						</div>
                    </div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
            </form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
	</div>
</div>
@endsection

@section('additional_javascript')
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/edit_user.js') }}"></script>  
    <script type="text/javascript">
    	$('select[name="businessName2"]').select2({
            placeholder: "Which industry are you in?",
            width: '100%',
        });
    	$('select[name="role2"]').select2({
            placeholder: "What role do you have?",
            width: '100%',
        });
        if($('select[name="businessName2"]').val()==="Other industry"){
    		$('.other_industry').show();
    	}
    	else $('.other_industry').hide();
        if($('select[name="role2"]').val()==="Other"){
    		$('.other_role').show();
    	}
    	else $('.other_role').hide();
        $('select[name="businessName2"]').change(function(){
        	var option = $(this).val();
        	if(option==="Other industry"){
        		$('.other_industry').show();
        	}
        	else $('.other_industry').hide();
        });
        $('select[name="role2"]').change(function(){
        	var option = $(this).val();
        	if(option==="Other"){
        		$('.other_role').show();
        	}
        	else $('.other_role').hide();
        });
    </script>      
@endsection

