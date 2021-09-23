@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                @if($id != null)

                Edit
                @else
                Add
                @endif
                
                Site Configuration</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.settings.configuration_list') }}" class="m-nav__link m-nav__link--icon">
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
                @if(isset($detail->id))
                <input type="hidden" name="id" value="{{ $detail->id??'' }}">
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
                            <label class="form-control-label">Application Name </label> <span class="red">*</span>
                            <input type='text' name="app_name" class="form-control" value="{{isset($detail->app_name)?$detail->app_name:''}}" />
                           
                        </div>
                        <div class='flex-x col-md-6'>
                            <div class="m-form__group-sub">
                                    <label class="form-control-label">Application Slogan</label> <span class="red">*</span>
                                    <input type='text' name="app_slogan" class="form-control" value="{{isset($detail->app_slogan)?$detail->app_slogan:''}}" />                                    
                            </div>
                                                           
                        </div>
                    </div>



                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Site Title </label> <span class="red">*</span>
                            <input type='text' name="site_title" class="form-control" value="{{isset($detail->site_title)?$detail->site_title:''}}" />
                        </div>
                        <div class='flex-x col-md-6'>
                            <div class="m-form__group-sub">
                                    <label class="form-control-label">Site Logo</label> <span class="red">*</span>
                                    <input type="file" class="form-control m-input" name="logo" id="logo" accept="image/jpeg,image/gif,image/png,image/jpg,image"  onchange="ValidateImageWithFixedSize('logo', this, 5, 70, 330);">
                                    <small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image width should be 330px and height should greater than 70px.<br>Maximum allowed file size is 5 MB.</small>
                            </div>   
                            <div>
                                @php
                                    $randNumber = rand(11,1001);
                                    @endphp
                                @if(isset($detail->logo))
                                <div class="m-form__group-sub pt-4">
                                    <small class="field_help_text">Existing logo<br></small>
                                    @if(!empty($detail->logo) && file_exists(public_path("uploads/logo/".$detail->logo))) 
                                        <img src="{{ asset('uploads/logo/'.$detail->logo.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
                                    @else 
                                        <img src="{{ asset('images/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
                                    @endif
                                    
                                </div>
                                @endif
                            </div>                            
                        </div>
                        
                    </div>
                    <div class="form-group m-form__group row">
                   
                            <div class='flex-x col-md-6'>
                                <div class=" m-form__group-sub">
                                    <label class="form-control-label">Footer Logo</label> <span class="red">*</span>
                                    <input type="file" class="form-control m-input" name="footer_logo" id="footer_logo" accept="image/jpeg,image/gif,image/png,image/jpg,image"  onchange="ValidateImageWithFixedSize('footer_logo', this, 5, 70, 300);">
                                    <small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image width should be 300px and height should be greater then 70px.<br>Maximum allowed file size is 5 MB.</small>
                                </div>
                                    @php
                                    $randNumber = rand(11,1001);
                                    @endphp
                                @if(isset($detail->footer_logo))
                                <div class="m-form__group-sub pt-4">
                                    <small class="field_help_text">Existing Logo<br></small>
                                    @if(!empty($detail->footer_logo) && file_exists(public_path("uploads/logo/".$detail->footer_logo))) 
                                        <img src="{{ asset('uploads/logo/'.$detail->footer_logo.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
                                    @else 
                                        <img src="{{ asset('images/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
                                    @endif
                                    
                                </div>
                                @endif
                            </div>

                            <div class='flex-x col-md-6'>
                            <div class=" m-form__group-sub">
                                <label class="form-control-label">Favicon</label> <span class="red">*</span>
                                <input type="file" class="form-control m-input" name="favi_icon" id="favi_icon" accept="image/x-icon"  onchange="ValidateImage('favi_icon', this, 1, 10, 10);">
                                <small class="field_help_text">Allowed file types are .ico only.<br>Image height & width should be greater than 10px*10px.<br>Maximum allowed file size is 1 MB.</small>
                            </div>
                                @php
                                $randNumber = rand(11,1001);
                                @endphp
                            @if(isset($detail->favi_icon))
                            <div class="m-form__group-sub pt-4">
                                <small class="field_help_text">Existing Logo<br></small>
                                @if(!empty($detail->favi_icon) && file_exists(public_path("uploads/logo/".$detail->favi_icon))) 
                                    <img src="{{ asset('uploads/logo/'.$detail->favi_icon.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
                                @else 
                                    <img src="{{ asset('images/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
                                @endif
                                
                            </div>
                            @endif
                            </div>
                    </div>
                    <div class="form-group m-form__group row">
                   
                       
                    </div>
                   
                    
                    </div>
                    
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('admin.settings.configuration_list') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/configuration_add_new.js') }}"></script>   
    
@endsection

