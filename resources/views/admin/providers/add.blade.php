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
                provider</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.providers') }}" class="m-nav__link m-nav__link--icon">
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
                <input type="hidden" name="providerIdx" value="{{ $id??'' }}">
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
                            <label class="form-control-label">User </label>
                            <div class="form-control">{{$detail->user->firstname}} {{$detail->user->lastname}}</div>
                        </div>
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Region </label> <span class="red">*</span>
                            
                            <select class="form-control m-input" name="regionIdx">
								<option value="">Select</option>
								@foreach($regions as $regionIdx=>$regionName)
									@if( isset($detail) && $regionIdx == $detail->regionIdx)
										<option value="{{ $regionIdx }}" selected>
											{{ $regionName }}
										</option>
									@else
										<option value="{{ $regionIdx }}" >
											{{ $regionName }}
										</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Company URL </label> <span class="red">*</span>
                            <input type='text' name="companyURL" class="form-control" value="{{isset($detail->companyURL) ? $detail->companyURL:''}}" />
                        </div>
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Company Name </label> <span class="red">*</span>
                            <input type='text' name="companyName" class="form-control" value="{{isset($detail->companyName) ? $detail->companyName:''}}" />
                        </div>
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Company VAT </label> <span class="red">*</span>
                            <input type='text' name="companyVAT" class="form-control" value="{{isset($detail->companyVAT) ? $detail->companyVAT:''}}" />
                        </div>
                    </div>
                   
               
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                                <label class="form-control-label">Image</label>
                                <input type="file" class="form-control m-input" name="uploadedFile" id="uploadedFile" accept="image/jpeg,image/gif,image/png,image/jpg,image"  onchange="ValidateImage('uploadedFile', this, 5, 200, 200);">
                                <small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image height & width should be greater than 200px*200px.<br>Maximum allowed file size is 5 MB.</small>
                            </div>
                                @php
                                $randNumber = rand(11,1001);
                                @endphp
                            @if(isset($detail->companyLogo))
                            <div class="col-md-2 m-form__group-sub pt-4">
                                <small class="field_help_text">Existing Image<br></small>
                                @if(!empty($detail->companyLogo) && file_exists(public_path("uploads/company/thumb/".$detail->companyLogo))) 
                                    <img src="{{ asset('uploads/company/thumb/'.$detail->companyLogo.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
                                @elseif(!empty($detail->companyLogo) && file_exists(public_path("uploads/company/".$detail->companyLogo))) 
                                    <img src="{{ asset('uploads/company/'.$detail->companyLogo) }}"  style="height: 60px;border: 1px solid #333;">
                                @else 
                                    <img src="{{ asset('images/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
                                @endif
                                
                            </div>
                            @endif
                    </div>
                   

                    </div>
                    
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('admin.providers') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/providers_add_new.js') }}"></script>   
    
@endsection

