@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><?php if($storyID != null){
                    echo 'Edit';
                }else{
                    echo "Add";
                } ?> Story</h3>
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
            <form class="m-form m-form--fit m-form--label-align-right" id="stories_form" novalidate="novalidate" enctype="multipart/form-data">
                <input type="hidden" name="content_id" value="{{ $id??'' }}">
                <input type="hidden" name="storyIdx" value="{{ $storyID??'' }}">
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
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Title </label> <span class="fields-msg">*</span>
                            <input type='text' name="title" class="form-control" value="{{isset($story->title)?$story->title:''}}" />
                        </div>
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Year </label> <span class="fields-msg">*</span>
                            <select class="form-control m-input" name="year">
                                <option value="">Select</option>
                                @foreach(YEAR_RANGE as $year)
                                    @if( isset($story->year) && $story->year == $year)
                                        <option value="{{ $year }}" selected>
                                            {{ $year }}
                                        </option>
                                    @else
                                        <option value="{{ $year }}" >
                                            {{ $year }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        

                        
						
		
						
					</div>
                 
                    </div>
                    <div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Description</label> <span class="fields-msg"></span>
							<textarea class="form-control m-input" rows="5" name="description" placeholder="Enter Description">{{ isset($story->description)?$story->description:'' }}</textarea>
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
<script src="{{ asset('js/plugins/summernote-image-attributes.js') }}"></script>   
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

