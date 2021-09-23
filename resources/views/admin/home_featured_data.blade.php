@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
@endsection

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Home</b> Featured Data</h3>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-tools">
                            <!-- <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('admin.home_featured_data_edit') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus-circle"></i>
                                            <span>Edit Featured Data</span>
                                        </span>
                                    </a>
                                </li>
                            </ul> -->
                            <!-- <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('admin.preview_home', [ 'url' => 'admin.home_featured_data', 'model' => 'HomeFeaturedData' ]) }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-cart-plus"></i>
                                            <span>Preview</span>
                                        </span>
                                    </a>
                                </li>
                            </ul> -->
                        </div>
                    </div>
                </div>
                <div class=" m-portlet__body table-responsive">
                    <table class="table table-bordered table-stripped table-hover mt-2 dataTable no-footer" id="board_table">
                        <thead>
                            <tr>
                                <th align="center">Image</th>
                                <th align="center">Logo</th>                            
                                <th>Title</th>
                                <th>Provider</th>
                                <th style="width:140px;">Created Date</th>
                                <th style="width:140px;">Last Updated</th>
                                <th class="action-col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($boards as $board)                     
                                <tr>
                                    <td align="center">
                                        @if(!empty($board->image) && file_exists(public_path("uploads/home/featured_data/thumb/".$board->image)))                                                 
                                                {{ asset('uploads/home/featured_data/thumb/'.$board->image) }}
                                        @elseif(!empty($board->image) && file_exists(public_path("uploads/home/featured_data/".$board->image)))
                                                {{ asset('uploads/home/featured_data/'.$board->image) }}
                                        @else
                                                {{ asset('uploads/default.png') }}
                                        @endif
                                    </td>
                                
                                    <td>
                                        @if(!empty($board->logo) && file_exists(public_path("uploads/home/featured_data/logo/thumb/".$board->logo)))
                                            {{ asset('uploads/home/featured_data/logo/thumb/'.$board->logo) }}
                                        @else
                                            {{ asset('uploads/company/thumb/default.png') }}
                                        @endif
                                    </td>
                                    <td>{{ $board->featured_data_title }}</td>
                                    <td>{{ $board->companyName }}</td>
                                    <td>{{strtotime($board->created_at) > 0 ?  $board->created_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td>{{strtotime($board->updated_at) > 0 ?  $board->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td>
                                    @if($board->active == 1) 
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$board->id}}');" title="Click to Unpublish">
                                        <i class="la la-thumbs-up"></i></a>
                                        @else
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('{{$board->id}}');" title="Click to Publish">
                                            <i class="la la-thumbs-down"></i></a>
                                        @endif    
                                    <a href="{{ route('admin.home_featured_data_edit') }}"> <i class="la la-edit"></i></a>
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
    <script src="{{ asset('adminpanel/js/home_featured_data.js') }}"></script>            
@endsection