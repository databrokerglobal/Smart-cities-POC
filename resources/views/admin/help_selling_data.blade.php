@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Help - Selling Data </b>Title and Intro</h3>
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
				<input type="hidden" name="helpTopicIdx" value="{{ isset($header)? $header->helpTopicIdx : 0 }}">
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
							<label class="form-control-label">Title </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="title" placeholder="Enter title" value="{{ isset($header)? $header->title: '' }}">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Description</label> <span class="red">*</span>
							<textarea class="form-control m-input"  id="editor" rows="5" name="description" placeholder="Enter introduction">{{ isset($header)? $header->description : '' }}</textarea>
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
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
    <script src="{{ asset('adminpanel/js/help_selling_data.js') }}"></script>        
@endsection

