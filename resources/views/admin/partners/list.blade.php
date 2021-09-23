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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Partners</b></h3>
                
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
                                <a href="{{ route('admin.partners.add') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>Add Partner</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table">
                        <thead>
                            <tr>
                                <th style="width:10px;">#</th>
                                <th>Logo</th>
                                <th style="width:150px;">Title</th>
                                <th style="width:140px;">Created Date</th>
                                <th style="width:140px;">Last Updated</th>
                                
                                <th style="width:150px;" class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partners as $index=>$partner)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    
                                    <td> 
                                        @if($partner->logo && file_exists(public_path('uploads/partners/thumb/'.$partner->logo))) 
                                            {{ asset('uploads/partners/'.$partner->logo) }}
                                        @else 
                                            {{ asset('images/gallery/thumbs/thumb/default.png') }}
                                        @endif
                                    </td>
                                    <td>{{ $partner->title }}</td>
                                                                
                                    <td><span class="dateSort">{{strtotime($partner->created_at) > 0 ?  $partner->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($partner->created_at) > 0 ?  $partner->created_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td><span class="dateSort">{{strtotime($partner->updated_at) > 0 ?  $partner->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($partner->updated_at) > 0 ?  $partner->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                
                                    <td>
                                        @if($partner->proud_partner == 1)

                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="make_proud_record('{{$partner->id}}');" title="Click to remove from proud partner">
                                            <i class="la la-tag"></i></a>
                                        @else
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="make_proud_record('{{$partner->id}}');" title="Click to make proud partner">
                                            <i class="la la-tags"></i></a>
                                        @endif
                                        @if($partner->status == 1)

                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$partner->id}}');" title="Click to Unpublish">
                                            <i class="la la-thumbs-up"></i></a>
                                        @else
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('{{$partner->id}}');" title="Click to Publish">
                                            <i class="la la-thumbs-down"></i></a>
                                        @endif
                                                <a href="{{route('admin.partners.edit',$partner->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                        <i class="la la-edit"></i>
                                        </a>
                                        <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$partner->id}}');"><i class="la la-trash" title="Delete"></i>
                                        </a>
                                    </td>
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
    <script src="{{ asset('adminpanel/js/partners.js') }}"></script>            
@endsection

