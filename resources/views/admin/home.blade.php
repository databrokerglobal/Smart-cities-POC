@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Homepage</b></h3>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
					<li class="m-nav__item m-nav__item--home">
						<a href="{{ route('admin.home') }}" class="m-nav__link m-nav__link--icon">
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
			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right" id="board_form" novalidate="novalidate">
				<input type="hidden" name="id" value="">
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
                        <div class="section-label"><b>Featured Data Section</b></div>
                    </div>
					<div class="form-group m-form__group row">
						<div class="col-md-6 m-form__group-sub">
							<label class="form-control-label">Featured Data Title *</label>
							<input type="text" class="form-control m-input" name="featured_data_title" placeholder="Enter Featured Data Title" value="">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Featured Data Content</label>
							<textarea class="form-control m-input summernote" rows="5" name="featured_data_content" placeholder="Enter Featured Data Content"></textarea>
						</div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="section-label"><b>Trending Section</b></div>
                    </div>
					<div class="form-group m-form__group row">
						<div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Trending Image 1</label>
							<input type="file" class="form-control m-input" name="trending_1" placeholder="Upload trending image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Trending Image 2</label>
							<input type="file" class="form-control m-input" name="trending_2" placeholder="Upload trending image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Trending Image 3</label>
							<input type="file" class="form-control m-input" name="trending_3" placeholder="Upload trending image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Trending Image 4</label>
							<input type="file" class="form-control m-input" name="trending_4" placeholder="Upload trending image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Trending Image 5</label>
							<input type="file" class="form-control m-input" name="trending_5" placeholder="Upload trending image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Trending Image 6</label>
							<input type="file" class="form-control m-input" name="trending_6" placeholder="Upload trending image" value="" accept=".gif,.jpg,.jpeg,.png">
						</div>
					</div>
                
                
                    <div class="form-group m-form__group row">
                        <div class="section-label"><b>New On Marketplace Section</b></div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Marketplace Title 1</label>
                            <input type="text" class="form-control m-input" name="marketplace_title_1" placeholder="Enter marketplace title" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Marketplace Location 1</label>
                            <input type="text" class="form-control m-input" name="marketplace_location_1" placeholder="Enter marketplace location" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Marketplace Image 1</label>
                            <input type="file" class="form-control m-input" name="marketplace_image_1" placeholder="Enter marketplace image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Marketplace Title 2</label>
                            <input type="text" class="form-control m-input" name="marketplace_title_2" placeholder="Enter marketplace title" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Marketplace Location 2</label>
                            <input type="text" class="form-control m-input" name="marketplace_location_2" placeholder="Enter marketplace location" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Marketplace Image 2</label>
                            <input type="file" class="form-control m-input" name="marketplace_image_2" placeholder="Enter marketplace image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Marketplace Title 3</label>
                            <input type="text" class="form-control m-input" name="marketplace_title_3" placeholder="Enter marketplace title" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Marketplace Location 3</label>
                            <input type="text" class="form-control m-input" name="marketplace_location_3" placeholder="Enter marketplace location" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Marketplace Image 3</label>
                            <input type="file" class="form-control m-input" name="marketplace_image_3" placeholder="Enter marketplace image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="section-label"><b>{{APPLICATION_NAME}} Team Picks</b></div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Team Picks Title 1</label>
                            <input type="text" class="form-control m-input" name="teampicks_title_1" placeholder="Enter team picks title" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Team Picks Location 1</label>
                            <input type="text" class="form-control m-input" name="teampicks_location_1" placeholder="Enter team picks location" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Team Picks Image 1</label>
                            <input type="file" class="form-control m-input" name="teampicks_image_1" placeholder="Enter team picks image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Team Picks Title 2</label>
                            <input type="text" class="form-control m-input" name="teampicks_title_2" placeholder="Enter team picks title" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Team Picks Location 2</label>
                            <input type="text" class="form-control m-input" name="teampicks_location_2" placeholder="Enter team picks location" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Team Picks Image 2</label>
                            <input type="file" class="form-control m-input" name="teampicks_image_2" placeholder="Enter team picks image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 m-form__group-sub">
                            <label class="form-control-label">Team Picks Title 3</label>
                            <input type="text" class="form-control m-input" name="teampicks_title_3" placeholder="Enter team picks title" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Team Picks Location 3</label>
                            <input type="text" class="form-control m-input" name="teampicks_location_3" placeholder="Enter team picks location" value="">
                        </div>
                        <div class="col-md-3 m-form__group-sub">
                            <label class="form-control-label">Team Picks Image 3</label>
                            <input type="file" class="form-control m-input" name="teampicks_image_3" placeholder="Enter team picks image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="section-label"><b>Featured Data Providers</b></div>
                    </div>
					<div class="form-group m-form__group row">
						<div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Providers Image 1</label>
							<input type="file" class="form-control m-input" name="providers_1" placeholder="Upload providers image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Providers Image 2</label>
							<input type="file" class="form-control m-input" name="providers_2" placeholder="Upload providers image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Providers Image 3</label>
							<input type="file" class="form-control m-input" name="providers_3" placeholder="Upload providers image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Providers Image 4</label>
							<input type="file" class="form-control m-input" name="providers_4" placeholder="Upload providers image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Providers Image 5</label>
							<input type="file" class="form-control m-input" name="providers_5" placeholder="Upload providers image" value="" accept=".gif,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-2 m-form__group-sub">
                            <label class="form-control-label">Providers Image 6</label>
							<input type="file" class="form-control m-input" name="providers_6" placeholder="Upload providers image" value="" accept=".gif,.jpg,.jpeg,.png">
						</div>
					</div>
                </div>

				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="submit" class="btn btn-success">Save</button>
								<a href="{{ route('admin.updates') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ asset('adminpanel/js/home.js') }}"></script>        
@endsection

