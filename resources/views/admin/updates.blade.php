@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Updates</b> Article</h3>
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
                                <a href="{{ route('admin.updates_add_new') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>New Article</span>
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
                            <th>Image</th>
                            <th style="width:200px;">Title</th>
                            <th>Category</th>                            
                            <th>Author</th>
                            <th style="width:70px;">Published on</th>
                            <th style="width:140px;">Created Date</th>
                            <th style="width:145px;">Last Updated</th>
                            <th class="hidden">Active</th>
                            <th style="width:120px;" class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($boards as $board)                      
                            <tr>
                                <td align="center">
                                    @if(!empty($board->articleIdx) &&  file_exists(public_path("uploads/usecases/thumb/".$board->articleIdx.".jpg"))) 
                                        {{ asset("uploads/usecases/thumb/".$board->articleIdx.".jpg") }}
                                    @else 
                                        {{ asset("uploads/default.png") }}
                                    @endif
                                </td>
                                <td>{{ $board->articleTitle }}</td>
                                <td>{{ $board->category }}</td>                               
                                <td>{{ $board->author }}</td>                               
                                <td><span class="dateSort">{{strtotime($board->published) > 0 ?  $board->published->format(SORTABLE_DATE) : '-'}}</span>{{strtotime($board->published) > 0 ?  $board->published->format(SIMPLE_DATE) : '-'}}</td>
                                <td><span class="dateSort">{{strtotime($board->created_at) > 0 ?  $board->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($board->created_at) > 0 ?  $board->created_at->format(DATE_FORMAT) : '-'}}</td>
                                <td><span class="dateSort">{{strtotime($board->updated_at) > 0 ?  $board->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($board->updated_at) > 0 ?  $board->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                <td class="hidden">{{ $board->active ? "Published" : "Unpublished"}}</td>
                                <td>{{ $board->articleIdx }}</td>
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
    <script src="{{ asset('adminpanel/js/updates.js') }}"></script>            
@endsection

