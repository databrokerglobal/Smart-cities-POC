@extends('layouts.admin')

@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style type="text/css">
    	.other_category{display: none;}
    </style>
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator">Updates Edit Article</h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="{{ route('admin.updates') }}" class="m-nav__link m-nav__link--icon">
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
						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Article Title </label> <span class="red">*</span>
							<input type="text" id ="articleTitle" class="form-control m-input character-count" name="articleTitle" placeholder="Enter article title" value="{{ $board->articleTitle??'' }}" onkeyup="convertString('articleTitle', 'slug')"  maxlength="250">
							<div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>250</span> Characters</div>
						</div>
						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Article Category </label> <span class="red">*</span>
							<select class="form-control m-input" id="article-category" name="category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                	@if($category == $board->category)
                                <option value="{{$category}}" selected>{{$category}}</option>
                                	@else
                                <option value="{{$category}}">{{$category}}</option>
                                	@endif
                                @endforeach
                                @if(!in_array($board->category, $categories))
                                <option value="Other" selected>Other</option>
                                @else
                                <option value="Other">Other</option>
                                @endif
                            </select>
						</div>
						<div class="col-md-3 m-form__group-sub other_category">
							<label class="form-control-label">Other Category </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="category1" placeholder="Other category" value="{{!in_array($board->category, $categories)?$board->category:''}}">
						</div>
					</div>
					<div class="form-group m-form__group row">

						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Slug </label> <span class="red">*</span>
							<input type="text" id ="slug" class="form-control m-input" name="slug"  value="{{ $board->slug ?? '' }}" readonly onkeypress="return blockSpecialChar(event)">
							<small class="field_help_text">{{ FIELD_SLUG_MESSAGE }}</small>
                        </div>

						<div class="col-md-3 m-form__group-sub">
							<label class="form-control-label">Published Date </label> <span class="red">*</span>
							<input type="text" class="form-control m-input" name="published" placeholder="DD/MM/YYYY" readonly value="{{ $board->published? date('d/m/Y', strtotime($board->published)):'' }}" autocomplete="off">
						</div>
						<div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Author </label> <span class="red">*</span>
							<input type="text" class="form-control m-input character-count" name="author" placeholder="Enter article author" value="{{ $board->author??'' }}"  maxlength="50">
							<div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>50</span> Characters</div>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Meta Title</label> <span class="red">*</span>
							<input type="text" class="form-control m-input character-count" name="meta_title" placeholder="Enter meta title" value="{{ $board->meta_title }}"  maxlength="100">
							<div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>100</span> Characters</div>
						</div>
						<div class="col-md-8 m-form__group-sub">
							<label class="form-control-label">Meta Description</label> <span class="red">*</span>
							<input type="text" class="form-control m-input character-count" name="meta_desc" placeholder="Enter meta description" value="{{ $board->meta_desc }}"  maxlength="250">
							<div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>250</span> Characters</div>
						</div>
					</div>
					<div class="form-group m-form__group row">
					<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Image</label>
							<input type="file" class="form-control m-input" name="uploadedFile" id="uploadedFile" accept="image/jpeg,image/gif,image/png,image/jpg,image/svg"  onchange="ValidateImage('uploadedFile', this, 5, 1200, 800);">
							<small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image height & width should be greater than 1200px*800px.<br>Maximum allowed file size is 5 MB.</small>
						</div>
							@php
							$randNumber = rand(11,1001);
							@endphp
						@if(isset($board))
						<div class="col-md-2 m-form__group-sub pt-4">
							<small class="field_help_text">Existing Image<br></small>
							@if(!empty($board->image) && file_exists(public_path("uploads/usecases/thumb/".$board->image))) 
								<img src="{{ asset('uploads/usecases/thumb/'.$board->image.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
							@elseif(!empty($board->image) && file_exists(public_path("uploads/usecases/".$board->image))) 
								<img src="{{ asset('uploads/usecases/'.$board->image) }}"  style="height: 60px;border: 1px solid #333;">
							@else 
								<img src="{{ asset('uploads/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
							@endif
							
						</div>
						@endif
					</div>	

					<div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Article Content</label> <span class="red">*</span>
							<textarea class="form-control m-input"  id="editor" rows="5" name="articleContent" placeholder="Enter article content">{{ $board->articleContent??'' }}</textarea>
						</div>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="{{ route('admin.updates') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/updates_add_new.js') }}"></script>        
    <script type="text/javascript">
    	$('select[name="category"]').select2({
            placeholder: "Select category",
            width: '100%',
        });
        let option = $('select[name="category"]').val();
        if(option=="Other") $('.other_category').show();
        else $('.other_category').hide();
        $('select[name="category"]').change(function(){
        	let option = $(this).val();
        	if(option=="Other") $('.other_category').show();
        	else $('.other_category').hide();
        });
    </script>    
@endsection

