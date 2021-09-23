@extends('layouts.admin')
@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/jquery.minicolors.css') }}">
@endsection

@section('content')
<div class="">
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
                        <a href="{{ route('admin.settings.theming') }}" class="m-nav__link m-nav__link--icon">
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
                            <label class="form-control-label">Header Background Color </label> <span class="red">*</span>
                            <input type='text' name="header_color" class="form-control color-picker" autocomplete="off" value="{{isset($detail->header_color)?$detail->header_color:''}}" />
                            <small class="field_help_text">This color is used for header background.</small>
                        </div>
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Footer Background Color </label> <span class="red">*</span>
                            <input type='text' name="footer_color" class="form-control color-picker" autocomplete="off" value="{{isset($detail->footer_color)?$detail->footer_color:''}}" />
                            <small class="field_help_text">This color is used for footer background.</small>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Primary Button Color </label> <span class="red">*</span>
                            <input type='text' name="primary_button_color" class="form-control color-picker" autocomplete="off"  value="{{isset($detail->primary_button_color)?$detail->primary_button_color:''}}" />
                            <small class="field_help_text">This color is used for all primary buttons accross the website.</small>
                        </div>
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Secondary Button Color </label> <span class="red">*</span>
                            <input type='text' name="secondary_button_color" class="form-control color-picker" autocomplete="off"   value="{{isset($detail->secondary_button_color)?$detail->secondary_button_color:''}}" />
                            <small class="field_help_text">This color is used for all secondary buttons accross the website.</small>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Search Button Color </label> <span class="red">*</span>
                            <input type='text' name="search_button_color" class="form-control color-picker" autocomplete="off"  value="{{isset($detail->search_button_color)?$detail->search_button_color:''}}" />
                            <small class="field_help_text">This color is used for search background color which is placed on header.</small>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Body Text Size </label> <span class="red">*</span>
                            <select class="form-control m-input" name="body_text_size">
                                    <option value="">Select</option>
                                    @foreach(TEXT_SIZE as $key=>$type)
                                        @if( isset($detail->body_text_size) && $detail->body_text_size == $key)
                                            <option value="{{ $key }}" selected>
                                                {{ $type }} px
                                            </option>
                                        @else
                                            <option value="{{ $key }}" >
                                                {{ $type }} px
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="field_help_text">Default font size in the body.</small>
                        </div>
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Body Font Family </label> <span class="red">*</span>
                            <select class="form-control m-input" name="body_font_family">
                                    <option value="">Select</option>
                                    @foreach(FONT_FAMILY as $key=>$type)
                                        @if( isset($detail->body_font_family) && $detail->body_font_family == $key)
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
                                <small class="field_help_text">Default font family for all texts.</small>
                        </div>
                    </div>
                  </div>
                    
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('admin.settings.theming') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/settings_add_new.js') }}"></script>   
    <script src="{{ asset('js/plugins/jquery.minicolors.min.js') }}"></script>   
    <script>
    $(document).ready( function() {

  
        $('.color-picker').minicolors({
            change: function(hex, opacity) {
            var log;
            try {
              log = hex ? hex : 'transparent';
              if( opacity ) log += ', ' + opacity;
              console.log(log);
            } catch(e) {}
          },
          theme: 'default'
        });

     

    });
  </script>
    
@endsection

