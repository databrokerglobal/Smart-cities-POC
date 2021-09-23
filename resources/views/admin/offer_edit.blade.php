@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Edit Offer</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.offers') }}" class="m-nav__link m-nav__link--icon">
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
                <input type="hidden" name="offerIdx" value="{{ $id??'' }}">
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
                            <label class="form-control-label">Title </label> <span class="red">*</span>
                            <input type='text' name="offerTitle" class="form-control" value="{{$offer->offerTitle}}" />
                        </div>
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Select community </label> <span class="red">*</span>
                            <select class="form-control m-input" name="communityIdx">
                                <option value="">Select</option>
                                @foreach($communities as $community)
                                    @if( isset($offer) && $offer->communityIdx == $community->communityIdx)
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
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Status </label> <span class="red">*</span>
                            <select class="form-control m-input" name="status">
                                <option value="">Select</option>
                                @foreach(STATUS as $key=>$value)
                                    @if( isset($offer) && $offer->status == $key)
                                        <option value="{{ $key }}" selected>
                                            {{ $value }}
                                        </option>
                                    @else
                                        <option value="{{ $key }}" >
                                            {{ $value }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        
						
		
						
					</div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Select Provider </label> <span class="red">*</span>
                            <select class="form-control m-input" name="providerIdx">
                                <option value="">Select</option>
                                @foreach($providers as $provider)
                                    @if( isset($offer) && $offer->providerIdx == $provider->providerIdx)
                                        <option value="{{ $provider->providerIdx }}" selected>
                                            {{ $provider->companyName }}
                                        </option>
                                    @else
                                        <option value="{{ $provider->providerIdx }}" >
                                            {{ $provider->companyName }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Region </label> <span class="red"></span>
                            <div class="form-group">
                             @if(count($offer->region) > 0)
                                    <?php $regionName = []; ?>
                                    @foreach($offer->region as $regionVal)
                                        <?php $regionName[] = $regionVal->regionName ?>
                                    @endforeach
                                    {{implode(',',$regionName)}}
                                @else
                                -
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 m-form__group-sub">
                            <label class="form-control-label">Theme </label> <span class="red"></span>
                            <div class="form-group">
                            @if(count($offer->theme) > 0)
                                    <?php $themes = []; ?>
                                    @foreach($offer->theme as $theme)
                                        <?php $themes[] = $theme->themeName ?>
                                    @endforeach
                                    {{implode(',',$themes)}}
                                @else
                                -
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
						<div class="col-md-4 m-form__group-sub">
							<label class="form-control-label">Image</label>
							<input type="file" class="form-control m-input" name="offerImage" id="offerImage" accept="image/jpeg,image/gif,image/png,image/jpg,image"  onchange="ValidateImage('offerImage', this, 5, 1200, 800);">
							<small class="field_help_text">Allowed file types are gif, png, jpg and jpeg only.<br>Image height & width should be greater than 1200px*800px.<br>Maximum allowed file size is 5 MB.</small>
						</div>
							@php
							$randNumber = rand(11,1001);
							@endphp
						@if(isset($offer))
						<div class="col-md-2 m-form__group-sub pt-4">
							<small class="field_help_text">Existing Image<br></small>
							@if(!empty($offer->offerImage) && file_exists(public_path("uploads/offer/thumb/".$offer->offerImage))) 
								<img src="{{ asset('uploads/offer/thumb/'.$offer->offerImage.'?randN='.$randNumber) }}"  style="height: 60px;border: 1px solid #333;">
							@elseif(!empty($offer->offerImage) && file_exists(public_path("images/home/trending/".$offer->offerImage))) 
								<img src="{{ asset('uploads/offer/thumb/'.$offer->offerImage) }}"  style="height: 60px;border: 1px solid #333;">
							@else 
								<img src="{{ asset('images/default.png') }}" alt="No Image" style="height: 60px;border: 1px solid #333;">
							@endif
							
						</div>
						@endif
                    </div>
                    <div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Description</label> <span class="red">*</span>
							<textarea class="form-control m-input"  id="editor"  rows="5" name="offerDescription" placeholder="Enter Description">{{ $offer->offerDescription??'' }}</textarea>
						</div>
					</div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('admin.offers') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/offer_add_new.js') }}"></script>   
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

