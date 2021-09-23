@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><?php if($memberID != null){
                    echo 'Edit';
                }else{
                    echo "Add";
                } ?> Team Member</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.content.edit', $id) }}" class="m-nav__link m-nav__link--icon">
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
            <form class="m-form m-form--fit m-form--label-align-right" id="team_form" novalidate="novalidate" enctype="multipart/form-data">
                <input type="hidden" name="content_id" value="{{ $id??'' }}">
                <input type="hidden" name="teamIdx" value="{{ $memberID??'' }}">
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
                            <label class="form-control-label">Name </label> <span class="fields-msg">*</span>
                            <input type='text' name="name" class="form-control" value="{{isset($member->name)?$member->name:''}}" />
                        </div>
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Position </label> <span class="fields-msg">*</span>
                            <input type='text' name="position" class="form-control" value="{{isset($member->position)?$member->position:''}}" />
                        </div>
                        
                        

                        
						
		
						
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">LinkedIn Profile </label> <span class="fields-msg"></span>
                            <input type='text' name="linkdin_link" class="form-control" value="{{isset($member->linkdin_link)?$member->linkdin_link:''}}" />
                        </div>
                       
						
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                                <label class="form-control-label">Pic</label>
                                <input type="file" class="form-control m-input" name="uploadedFile" id="uploadedFile" accept="image/jpeg,image/gif,image/png,image/jpg,image"  onchange="ValidateImage('uploadedFile', this, 5, 200, 200);">
                                <small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image height & width should be greater than 200px*200px.<br>Maximum allowed file size is 5 MB.</small>
                            </div>
                                @php
                                $randNumber = rand(11,1001);
                                @endphp
                            @if(isset($member->pic))
                            <div class="col-md-2 m-form__group-sub pt-4">
                                <small class="field_help_text">Existing Image<br></small>
                                @if(!empty($member->pic) && file_exists(public_path("uploads/teams/thumb/".$member->pic))) 
                                    <img src="{{ asset('uploads/teams/thumb/'.$member->pic.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
                                @elseif(!empty($member->pic) && file_exists(public_path("images/home/trending/".$member->pic))) 
                                    <img src="{{ asset('uploads/teams/thumb/'.$member->pic) }}"  style="height: 60px;border: 1px solid #333;">
                                @else 
                                    <img src="{{ asset('images/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
                                @endif
                                
                            </div>
                            @endif
                    </div>
                 
                    </div>
                   
                    <div class="clearfix"></div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('admin.content.edit',$id) }}" class="btn btn-secondary">Cancel</a>
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
<script src="{{ asset('adminpanel/js/content_add_new.js') }}"></script>   
    <script type="text/javascript">
        $('select[name="subcontent"]').select2({
            placeholder: "Select hero",
            width: '100%',
        });
        $('select[name="content"]').select2({
            placeholder: "Select community",
            width: '100%',
        });
    </script>     
@endsection

