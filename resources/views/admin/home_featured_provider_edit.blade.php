@extends('layouts.admin')

@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Home</b> Featured Data Providers</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="{{ route('admin.home_featured_provider') }}" class="m-nav__link m-nav__link--icon">
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
                <input type="hidden" name="id" value="{{ $id??'' }}">              
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
						<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Order </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="order" placeholder="Order in homepage" value="{{ isset($provider)? $provider->order : '' }}">
						</div>
						
                        <div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Select Provider </label> <span class="red">*</span>
							<select class="form-control m-input" name="providerIdx">
								<option value="">Select</option>
								@foreach($providers as $p)
									@if( isset($provider) && $provider->providerIdx == $p->providerIdx)
										<option value="{{ $p->providerIdx }}" selected>
											{{ $p->companyName }}
										</option>
									@else
										<option value="{{ $p->providerIdx }}" >
											{{ $p->companyName }}
										</option>
									@endif
								@endforeach
							</select>
							<div class="error"></div>
						</div>
						<div class="col-md-4 m-form__group-sub">
						<label class="form-control-label">Status</label> <span class="red">*</span>
								<select class="form-control m-input" name="active">
									@if(isset($statusList) && count($statusList)>0)
										@foreach($statusList as $statusKey=>$statusValue)
											@if( isset($provider) && $statusKey == $provider->active)
												<option value="{{ $statusKey }}" selected>
													{{ $statusValue }}
												</option>
											@else
												<option value="{{ $statusKey }}" >
													{{ $statusValue }}
												</option>
											@endif
										@endforeach
									@endif
								</select>
						</div>
                    </div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="{{ route('admin.home_featured_provider') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/home_featured_provider_add_new.js') }}"></script>  
    <script type="text/javascript">
    	$('select[name="providerIdx"]').select2({
            placeholder: "Select provider",
            width: '100%',
        });
    </script>      
@endsection

