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
				<h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Homepage</b> Trending</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="{{ route('admin.home_trending') }}" class="m-nav__link m-nav__link--icon">
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
			<form class="m-form m-form--fit m-form--label-align-right" id="board_form" novalidate="novalidate"  enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $id??'' }}">
                <input type="hidden" name="active" value="0">
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
							<label class="form-control-label">Trending Title</label> <span class="red">*</span>
							<input type="text" class="form-control m-input character-count" name="title" placeholder="Enter trending title" value="{{ $board->title??'' }}" maxlength="33">
							<div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>33</span> Characters</div>
						</div>
						<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Order</label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="order" placeholder="Order in homepage" value="{{ $board->order??'' }}">
						</div>
						<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Status</label>
							<select class="form-control m-input" name="active">
								@if(isset($statusList) && count($statusList)>0)
									@foreach($statusList as $statusKey=>$statusValue)
										@if( isset($board) && $statusKey == $board->active)
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
                    
					<div class="form-group m-form__group row">
					<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Offer </label> <span class="red">*</span>
							<select class="form-control m-input" name="offerIdx">
								<option value="">Select</option>
								@foreach($offers as $offerIdx=>$offerTitle)
									@if( isset($board) && $offerIdx == $board->offerIdx)
										<option value="{{ $offerIdx }}" selected>
											{{ $offerTitle }}
										</option>
									@else
										<option value="{{ $offerIdx }}" >
											{{ $offerTitle }}
										</option>
									@endif
								@endforeach
							</select>
						</div>
						
				<!-- 	</div>
					<div class="form-group m-form__group row"> -->
						<!-- <div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Site URL of Logo is linked</label>
							<input type="text" class="form-control m-input" name="logo_url" placeholder="https://www.databroker.global" value="{{ $board->logo_url??'' }}">
						</div> -->
						<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Logo</label>
							<input type="file" class="form-control m-input" name="uploadedFile" id="uploadedFile" 
							accept="image/jpeg,image/gif,image/png,image/jpg,image/svg+xml"  onchange="ValidateImage('uploadedFile', this, 5, 60, 60);">
							<small class="field_help_text">Allowed file types are gif, png, jpg, jpeg and svg only.Image height & width should be greater than 60px*60px.Maximum allowed file size is 5 MB.</small>
						</div>
							@php
							$randNumber = rand(11,1001);
							@endphp
						@if(isset($board))
						<div class="col-md-4 m-form__group-sub pt-4">
							<small class="field_help_text">Existing Logo<br></small>
							@if(!empty($board->image) && file_exists(public_path("uploads/home/trending/thumb/".$board->image))) 
								<img src="{{ asset('uploads/home/trending/thumb/'.$board->image.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
							@elseif(!empty($board->image) && file_exists(public_path("uploads/home/trending/".$board->image))) 
								<img src="{{ asset('uploads/home/trending/'.$board->image) }}"  style="height: 60px;border: 1px solid #333;">
							@else 
								<img src="{{ asset('uploads/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
							@endif
							
						</div>
						@endif
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="{{ route('admin.home_trending') }}" class="btn btn-secondary">Cancel</a>
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
	<script src="{{ asset('adminpanel/js/home_trending_add_new.js') }}"></script>     
    <script type="text/javascript">
    	$('select[name="offerIdx"]').select2({
            placeholder: "Select offer",
            width: '100%',
        });
    </script>          
@endsection

