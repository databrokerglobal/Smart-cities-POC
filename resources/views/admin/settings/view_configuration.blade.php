@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                View Default Site Configuration</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <!-- <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.partners') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li> -->
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
                            <label class="form-control-label">Application Name </label> <span class="red"></span>
                            <div class="name-ty">{{$detail->app_name}}</div>
                           
                        </div>
                        <div class='flex-x col-md-6'>
                            <div class="m-form__group-sub">
                                    <label class="form-control-label">Application Slogan</label> <span class="red"></span>
                                    <div class="name-ty">{{$detail->app_slogan}}</div>                                  
                            </div>
                                                           
                        </div>
                    </div>




                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Site Title </label> <span class="red"></span>
                            <div class="name-ty">{{$detail->site_title}}</div>     
                        </div>
                        <div class='flex-x col-md-6'>
                        <div class="m-form__group-sub">
                                <label class="form-control-label">Site Logo</label> <span class="red"></span>
                                <div class="name-ty"><image width="300" src="{{asset('images/logos/site_logo.png')}}" /></div>
                            </div>
                               
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                   
                            <div class='flex-x col-md-6'>
                                <div class=" m-form__group-sub">
                                    <label class="form-control-label">Footer Logo</label> <span class="red"></span>
                                    <div class="name-ty"> <image width="300" src="{{asset('images/logos/site_footer_logo.png')}}" /></div>
                               
                                </div>
                                
                            </div>

                            <div class='flex-x col-md-6'>
                            <div class=" m-form__group-sub">
                                <label class="form-control-label">Favicon</label> <span class="red"></span>
                                <div class="name-ty"> <image width="30"  src="{{ asset('images/logos/favicon.ico') }}" /></div>
                            </div>
                            
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

