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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Themes</b></h3>
                <div class="ggn-r"><a href="{{ route('admin.themes.add') }}" class="btn btn-primary text-right">Add Theme</a></div>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table">
                        <thead>
                            <tr>
                                <th style="width:10px;">#</th>                          
                                <th>Title</th>
                                <th>Community</th>
                                <th style="width:145px;">Created Date</th>
                                <th style="width:145px;">Last Updated</th>
                                <th style="width:70px;" class="hidden">Status</th>
                                <th style="width:150px;" class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($themes as $index=>$theme)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{ $theme->themeName }}</td>
                                    <td>{{ ($theme->communities) ? $theme->communities->communityName : '-' }}</td>
                                                                
                                    <td><span class="dateSort">{{strtotime($theme->created_at) > 0 ?  $theme->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($theme->created_at) > 0 ?  $theme->created_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td><span class="dateSort">{{strtotime($theme->updated_at) > 0 ?  $theme->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($theme->updated_at) > 0 ?  $theme->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td class="hidden">{{STATUS[$theme->status]}}</td>
                                    <td>{{$theme->themeIdx}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>       
    </div>
</div>

@endsection

@section('additional_javascript')
<script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/themes.js') }}"></script>            
@endsection

