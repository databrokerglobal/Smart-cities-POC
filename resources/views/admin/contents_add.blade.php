@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Add Content</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.contents') }}" class="m-nav__link m-nav__link--icon">
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
            <form class="m-form m-form--fit m-form--label-align-right" id="board_content_add_form" novalidate="novalidate" enctype="multipart/form-data">                
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
                            <input type='text' name="content_title" class="form-control character-count" value="" maxlength="250" />
                            <div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>250</span> Characters</div>
                        </div>  
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Meta Title</label> <span class="red">*</span>
                            <input type='text' name="meta_title" class="form-control character-count" value="" maxlength="250" />
                            <div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>250</span> Characters</div>
                        </div>                        					                                               
					</div>
                    </div>
                    
                    <div class="form-group m-form__group row">                           
						
                            <div class="col-md-6 m-form__group-sub">
                                    <label class="form-control-label">Page URL</label> <span class="red">*</span>
                                    <input type='text' name="content_page_url" class="form-control character-count" value="" maxlength="80" />
                                    <div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>80</span> Characters</div>
                            </div>
                            <div class="col-md-6 m-form__group-sub">
                                <label class="form-control-label">Content Image</label>
                                <input type="file" class="form-control m-input" name="content_image_path" id="content_image_path" accept="image/jpeg,image/gif,image/svg,image/png,image/jpg,image"  onchange="ValidateImage('', this, 5, 800, 1200);">
                                <small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image height & width should be greater than 1200px*800px.<br>Maximum allowed file size is 5 MB.</small>
                            </div>

					</div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                                    <label class="form-control-label">Sort Order</label> <span class="red">*</span>
                                    <input type='number' min='1' name="sortOrder" class="form-control"  value="" />
                        </div>
                        <div class="col-md-6 m-form__group-sub">
                                    <label class="form-control-label">Status</label> <span class="red">*</span>
                                    <select  name="isActive" class="form-control" >
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
						<div class="col-md-6 m-form__group-sub">
							<label for="exampleTextarea">Content Meta Data</label> <span class="red">*</span>
							<textarea class="form-control m-input character-count"  
                                     rows="5" name="meta_data" placeholder="Enter Meta Data" maxlength="2000"></textarea>
                                     <div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>2000</span> Characters</div>
						</div>
					</div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-9 ml-lg-auto">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ route('admin.contents') }}" class="btn btn-secondary">Cancel</a>
                                </div>
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
    <script src="{{ asset('adminpanel/js/content_edit.js') }}"></script>           
@endsection

