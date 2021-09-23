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
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Help </b> Complaints</h3>
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
                                <a href="{{ route('admin.help.add_complaint') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>New topic</span>
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
                            <th style="width:30px;">#</th>
                            <th>Title</th>
                            <th style="width:140px;">Created Date</th>
                            <th style="width:140px;">Last Updated</th>
                            <th style="width:130px;" class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topics as $index=>$topic)                      
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{ $topic->title }}
                                <td><span class="dateSort">{{strtotime($topic->created_at) > 0 ?  $topic->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($topic->created_at) > 0 ?  $topic->created_at->format(DATE_FORMAT) : '-'}}</td>
                                <td><span class="dateSort">{{strtotime($topic->updated_at) > 0 ?  $topic->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($topic->updated_at) > 0 ?  $topic->updated_at->format(DATE_FORMAT) : '-'}}</td>  
                                <td>{{ $topic->helpTopicIdx }}</td>
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
    <script src="{{ asset('adminpanel/js/help_complaints.js') }}"></script>            
@endsection

