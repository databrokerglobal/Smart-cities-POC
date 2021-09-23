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
                Theme</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.themes') }}" class="m-nav__link m-nav__link--icon">
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
                <input type="hidden" name="themeIdx" value="{{ $id??'' }}">
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
                            <input type='text' name="themeName" class="form-control" value="{{isset($detail->themeName)?$detail->themeName:''}}" />
                        </div>
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Select Community </label> <span class="red">*</span>
                                <select class="form-control m-input" name="communityIdx">
                                    <option value="">Select</option>
                                    @foreach($communities as $community)
                                        @if( isset($detail->communityIdx) && $detail->communityIdx == $community->communityIdx)
                                            <option value="{{ $community->communityIdx }}" selected>
                                                {{ $community->communityName }}
                                            </option>
                                        @else
                                            <option value="{{ $community->communityIdx }}" >
                                                {{ $community->communityName }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Text</label> <span class="fields-msg"></span>
							<textarea class="form-control m-input"  id="editor"  rows="2" name="themeText" placeholder="Enter Description">{{ isset($detail->themeText)?$detail->themeText:'' }}</textarea>
						</div>
                    </div>
                    
                    </div>
                    
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('admin.themes') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/themes_add_new.js') }}"></script>   
    
@endsection

