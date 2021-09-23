@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto width-100">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Site Configurations </b></h3>                
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route('admin.settings.configuration.add') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>Add Configuration</span>
                                    </span>
                                </a>
                                &nbsp;&nbsp;
                                &nbsp;&nbsp;
                                <a href="{{ route('admin.settings.configuration.reset') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-refresh"></i>
                                        <span>Reset to Default Configuration</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class=" m-portlet__body table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table">
                    <thead>
                        <tr>
                            <th style="width:4px;">#</th>
                            <th>Site Title</th>
                            <th>Favicon</th>
                            <th>Logo</th>
                            <th>Footer logo</th>
                            <th style="width:160px;">Created Date</th>
                            <th style="width:160px;">Last Updated</th>
                            <th>Status</th>
                            <th style="width:120px;" class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $index=>$partner)
                            <tr>
                                <td>{{$index+1}}</td>
                                
                                <td> 
                                    {{$partner->site_title}}
                                </td>
                                <td> 
                                    @if($partner->id == 1)
                                    <image width="30"  src="{{ asset('images/logos/favicon.ico') }}" />
                                    @else
                                    <image width="30" src="{{asset('uploads/logo/'.$partner->favi_icon)}}" />
                                    @endif
                                </td>
                                <td> 
                                    @if($partner->id == 1)
                                    <image width="100" src="{{asset('images/logos/site_logo.png')}}" />
                                    @else
                                    <image width="100" src="{{asset('uploads/logo/'.$partner->logo)}}" />
                                    @endif
                                
                                </td>
                                <td> 
                                    @if($partner->id == 1)
                                    <image width="100" src="{{asset('images/logos/site_footer_logo.png')}}" />
                                    @else
                                    <image width="100" src="{{asset('uploads/logo/'.$partner->footer_logo)}}" />
                                    @endif
                                   
                                </td>
                                                            
                                <td><span class="dateSort">{{strtotime($partner->created_at) > 0 ?  $partner->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($partner->created_at) > 0 ?  $partner->created_at->format(DATE_FORMAT) : '-'}}</td>
                                <td><span class="dateSort">{{strtotime($partner->updated_at) > 0 ?  $partner->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($partner->updated_at) > 0 ?  $partner->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                <td>
                                    @if($partner->status == 1)
                                        <image width="25"  src="{{asset('images/applied_icon.png')}}" title="Applied" />
                                    @else
                                    <image width="25"  src="{{asset('images/not_applied_icon.png')}}" title="Not Applied" />

                                    @endif
                                </td>
                                <td>
                                  
                                    @if($partner->status == 0)

                                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$partner->id}}');" title="Click to Apply">
                                        <i class="la la-tags"></i></a>
                                    @endif
                                  @if($partner->id != 1)
                                    <a href="{{route('admin.settings.configuration.edit',$partner->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                    <i class="la la-edit"></i>
                                    </a>
                                    <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$partner->id}}');"><i class="la la-trash" title="Delete"></i>
                                    </a>
                                    @else
                                    <span>Default</span>
                                    <a href="{{route('admin.settings.configuration.view',$partner->id)}}" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" ><i class="la la-eye" title="View Default Site configuration"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>       
    </div>
</div>

@endsection

@section('additional_javascript')
<script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/configurations.js') }}"></script>            
@endsection

