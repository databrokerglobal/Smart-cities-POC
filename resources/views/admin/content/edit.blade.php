@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
   
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    
    <!-- END: Subheader -->
    <div class="m-content">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Edit <?php echo $content->title ?> Content</h3>
                
            </div>
        </div>
    </div>
        <!--begin::Portlet-->
        <div class="m-portlet">

        <div class="col-sm-12 text-right">
			<span class="fields-msg">*
				<em>{{ FIELDS_REQUIRED_MESSAGE }}</em>
			</span>
		</div>

            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right" id="board_form" novalidate="novalidate" enctype="multipart/form-data">
                <input type="hidden" name="contentIdx" value="{{ $id??'' }}">
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
                        <div class="col-md-12 m-form__group-sub">
                            <label class="form-control-label">Title </label> <span class="fields-msg">*</span>
                            <input type='text' name="title" class="form-control" value="{{$content->title}}" />
                        </div>
                       
                      

                        
						
		
						
					</div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-12 m-form__group-sub">
                            <label class="form-control-label">Sub Title </label> <span class="fields-msg"></span>
                            <textArea type='text' name="sub_title" class="form-control">{{$content->sub_title}}</textArea>
                        </div>
                       
                      

                        
						
		
						
					</div>
                    <div class="form-group m-form__group row">
						<div class="col-md-12 m-form__group-sub">
							<label for="exampleTextarea">Description</label> <span class="fields-msg"></span>
							<textarea class="form-control m-input"  id="editor"  rows="2" name="description" placeholder="Enter Description">{{ $content->description??'' }}</textarea>
						</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-12 ml-lg-auto" style="text-align:right">
                                <button type="submit" class="btn btn-success">Save</button>
                                <!-- <a href="{{ route('admin.offers') }}" class="btn btn-secondary">Cancel</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <!--end::Form-->
            
           
        </div>
        <?php if($id != 2){?>
        <hr>
            <div class="m-content">
            <div class="m-subheader ">
                <div class="d-flex align-items-center">
                    <div class="mr-auto width-100">
                        <h3 class="m-subheader__title m-subheader__title--separator">Stories</h3>
                        <div class="ggn-r"><a href="{{ route('admin.content.addstories',$id) }}" class="btn btn-primary text-right">Add Story</a></div>
                    </div>
                </div>
            </div>
            <div class="m-portlet">
                        <div class="m-portlet__body table-responsive">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="stories_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th align="center">Title</th>
                                        <th>Year</th>
                                        <th style="width:120px;">Created Date</th>
                                        <th style="width:120px;">Last Updated</th>
                                        <th class="action-col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stories as $index=>$story)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                        
                                            <td>{{ $story->title }}</td>
                                            <td>{{ $story->year }}</td>
                                        
                                            
                                            <td><span class="dateSort">{{strtotime($story->created_at) > 0 ?  $story->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($story->created_at) > 0 ?  $story->created_at->format(DATE_FORMAT) : '-'}}</td>
                                            <td><span class="dateSort">{{strtotime($story->updated_at) > 0 ?  $story->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($story->updated_at) > 0 ?  $story->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                            <td>
                                             @if($story->status == 1)
                                             <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('stories','{{ $story->storyIdx }}');" title="Click to Unpublish">
                                                <i class="la la-thumbs-up"></i></a>
                                               
                                             @else
                                                 <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('stories','{{ $story->storyIdx }}');" title="Click to Publish"><i class="la la-thumbs-down"></i></a>
                                             @endif
                                            <a href="{{ route('admin.content.addstories',[$id,$story->storyIdx]) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                            <i class="la la-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('stories','{{ $story->storyIdx }}');"><i class="la la-trash" title="Delete"></i>
                                            </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
            </div>

            </div>        
        <hr>
            <div class="m-content">
            <div class="m-subheader ">
                <div class="d-flex align-items-center">
                    <div class="mr-auto width-100">
                        <h3 class="m-subheader__title m-subheader__title--separator">Teams</h3>
                        <div class="ggn-r"><a href="{{ route('admin.content.addTeam',$id) }}" class="btn btn-primary text-right">Add Team Member</a></div>
                    </div>
                </div>
            </div>
            <div class="m-portlet">
                        <div class="m-portlet__body table-responsive">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="team_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th align="center">Pic</th>
                                        <th align="center">Name</th>
                                        <th>Position</th>
                                        <th style="width:120px;">Created Date</th>
                                        <th style="width:120px;">Last Updated</th>
                                        <th class="action-col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $index=>$team)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                        
                                            <td>
                                            @if($team->pic && file_exists(public_path('uploads/teams/'.$team->pic))) 
                                                {{ asset('uploads/teams/'.$team->pic) }}
                                            @else 
                                                {{ asset('images/gallery/thumbs/thumb/default.png') }}
                                            @endif
                                            </td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ $team->position }}</td>
                                        
                                            
                                            <td><span class="dateSort">{{strtotime($team->created_at) > 0 ?  $team->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($team->created_at) > 0 ?  $team->created_at->format(DATE_FORMAT) : '-'}}</td>
                                            <td><span class="dateSort">{{strtotime($team->updated_at) > 0 ?  $team->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($team->updated_at) > 0 ?  $team->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                            
                                            <td>
                                             @if($team->status == 1)
                                             <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('team','{{ $team->teamIdx }}');" title="Click to Unpublish">
                                                <i class="la la-thumbs-up"></i></a>
                                               
                                             @else
                                                 <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('team','{{ $team->teamIdx }}');" title="Click to Publish"><i class="la la-thumbs-down"></i></a>
                                             @endif
                                            <a href="{{ route('admin.content.addTeam',[$id,$team->teamIdx]) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                            <i class="la la-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('team','{{ $team->teamIdx }}');"><i class="la la-trash" title="Delete"></i>
                                            </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
            </div>

            </div>
        <?php }?>
        <!--end::Portlet-->
</div>

@endsection

@section('additional_javascript')
<script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script> 
<script src="{{ asset('adminpanel/js/content_add_new.js') }}"></script>   
    
@endsection

