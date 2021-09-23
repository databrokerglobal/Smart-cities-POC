@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                @if(isset($id))    
                Edit
                @else
                Add
                @endif
                Partner</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.partners') }}" class="m-nav__link m-nav__link--icon">
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
                @if(isset($id))
                <input type="hidden" name="id" value="{{ $id??'' }}">
                @endif
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
                            <input type='text' name="title" class="form-control character-count" value="{{isset($detail->title)?$detail->title:''}}" maxlength="250" />
                            <div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>250</span> Characters</div>
                        </div>
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Select Type </label> <span class="red">*</span>
                                <select class="form-control m-input" name="partner_type">
                                    <option value="">Select</option>
                                    @foreach(PARTNER_TYPE as $key=>$type)
                                        @if( isset($detail->partner_type) && $detail->partner_type == $key)
                                            <option value="{{ $key }}" selected>
                                                {{ $type }}
                                            </option>
                                        @else
                                            <option value="{{ $key }}" >
                                                {{ $type }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                    
                        <div class="col-md-4 m-form__group-sub">
                                <label class="form-control-label">Logo</label>
                                <input type="file" class="form-control m-input" name="uploadedFile" id="uploadedFile" accept="image/jpeg,image/gif,image/png,image/jpg,image"  onchange="ValidateImage('uploadedFile', this, 5, 100, 80);">
                                <small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image height & width should be greater than 100px*80px.<br>Maximum allowed file size is 5 MB.</small>
                            </div>
                                @php
                                $randNumber = rand(11,1001);
                                @endphp
                            @if(isset($detail->logo))
                            <div class="col-md-4 m-form__group-sub pt-4">
                                <small class="field_help_text">Existing logo<br></small>
                                @if(!empty($detail->logo) && file_exists(public_path("uploads/partners/".$detail->logo))) 
                                    <img src="{{ asset('uploads/partners/'.$detail->logo.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
                                @elseif(!empty($detail->logo) && file_exists(public_path("uploads/partners/".$detail->logo))) 
                                    <img src="{{ asset('uploads/partners/'.$detail->logo) }}"  style="height: 60px;border: 1px solid #333;">
                                @else 
                                    <img src="{{ asset('images/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
                                @endif
                                
                            </div>
                            @endif
                            <div class="col-md-4 m-form__group-sub">
							<label for="exampleTextarea">URL</label> <span class="fields-msg"></span>
                            <input type='text' name="url" class="form-control character-count" value="{{isset($detail->url)?$detail->url:''}}"  maxlength="80"/>
                            <div class="char-counter field_help_text">Maximum allowed: <span>0</span> / <span>80</span> Characters</div>
						</div>
                    </div>
                  
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('admin.partners') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/partners_add_new.js') }}"></script>   
    
@endsection

