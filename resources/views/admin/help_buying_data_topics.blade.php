@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
    <link src="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style type="text/css">
        #board_table .hidden{display: none;}
    </style>
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Help - Question </b> About Buying Data</h3>
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
                                <a href="{{ route('admin.help.add_buying_data_topic') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
                <table class="table table-bordered table-stripped table-hover mt-2 dataTable no-footer" id="board_table">
                    <thead>
                        <tr>
                            <th style="width:50px;">Topic ID</th>
                            <th>Title</th>                           
                            <th style="width:140px;">Created Date</th>
                            <th style="width:140px;">Last Updated</th>
                            <th style="width:100px;">Status</th>
                            <th style="width:130px;" class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topics as $index=>$topic)                      
                            <tr>
                                <td>{{ $topic->helpTopicIdx }}</td>
                                <td>{{ $topic->title }}</td>
                                <td><span class="dateSort">{{strtotime($topic->created_at) > 0 ?  $topic->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($topic->created_at) > 0 ?  $topic->created_at->format(DATE_FORMAT) : '-'}}</td>
                                <td><span class="dateSort">{{strtotime($topic->updated_at) > 0 ?  $topic->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($topic->updated_at) > 0 ?  $topic->updated_at->format(DATE_FORMAT) : '-'}}</td>                           
                                <td>{{ $topic->active ? "Published" : "Unpublished" }}</td>
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
    <script src="{{ asset('adminpanel/js/help_buying_data_topics.js') }}"></script>            
@endsection

