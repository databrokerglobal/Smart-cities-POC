@extends('layouts.admin')

@section('content')


<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">
					<b style="color: #9102f7;">{{ $communityNameLabel }}</b> New Article</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="{{ route('admin.usecases', [ 'id' => $communityIdx ]) }}" class="m-nav__link m-nav__link--icon">
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
			<form class="m-form m-form--fit m-form--label-align-right" id="board_form" novalidate="novalidate" enctype="multipart/form-data">
				<input type="hidden" name="id" value="">
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
						<div class="col-md-7 m-form__group-sub">
							<label class="form-control-label">Article Title </label> <span class="red">*</span>
							<input type="text" class="form-control m-input character-count" id ="articleTitle"  name="articleTitle" placeholder="Enter article title" value="" onkeyup="convertString('articleTitle', 'slug')" maxlength="250">
							<div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>250</span> Characters</div>
						</div>
						<div class="col-md-2 m-form__group-sub">
							<label class="form-control-label">Published Date </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="published" placeholder="DD/MM/YYYY" readonly="readonly" value="" autocomplete="off">
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Board Category </label> <span class="red">*</span>
							<select class="form-control m-input" name="communityIdx">
								<option value="">Select</option>
								@foreach($categories as $category)
										@if( $communityIdx == $category->communityIdx)
											<option value="{{ $category->communityIdx }}"  selected>
												{{ $category->communityName }}
											</option>
										@else
											<option value="{{ $category->communityIdx }}" >
												{{ $category->communityName }}
											</option>
										@endif
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group m-form__group row">
					<div class="col-md-7 m-form__group-sub">
							<label class="form-control-label">Slug </label> <span class="red">*</span>
							<input type="text" id ="slug" class="form-control m-input" name="slug"  value="" readonly onkeypress="return blockSpecialChar(event)">
							<small class="field_help_text">{{ FIELD_SLUG_MESSAGE }}</small>
                        </div>

					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Meta Title</label> <span class="red">*</span>
							<input type="text" class="form-control m-input character-count" name="meta_title" placeholder="Enter meta title" value="" maxlength="100">
							<div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>100</span> Characters</div>
						</div>
						<div class="col-md-8 m-form__group-sub">
							<label class="form-control-label">Meta Description</label> <span class="red">*</span>
							<input type="text" class="form-control m-input character-count" name="meta_desc" placeholder="Enter meta description" value="" maxlength="250">
							<div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>250</span> Characters</div>
						</div>
					</div>

					
					<div class="form-group m-form__group row">
					<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Image</label>
							<input type="file" class="form-control m-input" name="uploadedFile" id="uploadedFile" accept="image/jpeg,image/gif,image/png,image/jpg,image/svg"  onchange="ValidateImage('uploadedFile', this, 5, 1200, 800);">
							<small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image height & width should be greater than 1200px*800px.<br>Maximum allowed file size is 5 MB.</small>
						</div>
					
					
						<div class="col-md-6 m-form__group-sub">
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
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Article Content</label> <span class="red">*</span>
							<textarea class="form-control m-input" id="editor" rows="5" name="articleContent" placeholder="Enter article content"></textarea>
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="{{ route('admin.usecases', [ 'id' => $communityIdx ]) }}" class="btn btn-secondary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</form>
			<input id="communityIdx_id" name="communityIdx_id" type="hidden" value="{{ $communityIdx }}"/>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
	</div>
</div>
@endsection

@section('additional_javascript')
    <script src="{{ asset('adminpanel/js/usecases_add_new.js') }}"></script>        
@endsection

