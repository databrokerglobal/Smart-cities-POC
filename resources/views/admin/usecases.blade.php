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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">{{ $communityName }}</b> Use Cases</h3>
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
                                <a href="{{ route('admin.usecases.add_new', [ 'id' => $communityIdx ]) }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-bordered table-stripped table-hover mt-2 dataTable no-footer" id="board_table">
                    
                        <thead>
                            <tr>
                                <th align="center">Image</th>
                                <th style="width:350px;">Title</th>
                                <th style="width:80px;">Published On</th>
                                <th style="width:140px;">Created Date</th>
                                <th style="width:140px;">Last Updated</th>
                                <th align="center" class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($boards as $board)                      
                                <tr>
                                    <td align="center">
                                        @if(!empty($board->articleIdx) && file_exists(public_path("uploads/usecases/thumb/".$board->articleIdx.".jpg")))                                         
                                            {{ asset("uploads/usecases/thumb/".$board->articleIdx.".jpg") }}
                                        @else                                        
                                            {{ asset("uploads/default.png") }}
                                        @endif
                                    </td>
                                    <td>{{ $board->articleTitle }}</td> 
                                    <td> <span class="dateSort">{{strtotime($board->published) > 0 ? $board->published->format(SORTABLE_DATE) : '-'}}</span> {{strtotime($board->published) > 0 ? $board->published->format(SIMPLE_DATE) : '-'}}</td>
                                    <td><span class="dateSort">{{strtotime($board->created_at) > 0 ?  $board->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($board->created_at) > 0 ?  $board->created_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td><span class="dateSort">{{strtotime($board->updated_at) > 0 ?  $board->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($board->updated_at) > 0 ?  $board->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td>
                                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl"           onclick="promote_record('{{$board->articleIdx }}',1);" title="Click to promote in top use cases">
                                            <i class="la la-trophy"></i>
                                        </a>
                                    @if($board->active == 1)
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$board->articleIdx }}');" title="Click to Unpublish">
                                            <i class="la la-thumbs-up"></i>
                                        </a>
                                    @else
                                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('{{$board->articleIdx }}');" title="Click to Publish">
                                            <i class="la la-thumbs-down"></i>
                                    </a>
                                    @endif

                                    <a href="{{ route('admin.usecases_edit',[$board->articleIdx]) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                    <i class="la la-edit"></i>
                                    </a>                          
                                    <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$board->articleIdx }}');"><i class="la la-trash" title="Delete"></i>
                                    </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>       
        <input type="hidden" name="communityIdx" value="{{$communityIdx}}">
    </div>
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/usecases.js') }}"></script>            
@endsection

