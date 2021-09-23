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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Media </b>
                @if($mode == "community-covers")
                    Community Cover Image
                @else
                    Data Offer Image
                @endif
                </h3>
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
                                <a href="{{ route('admin.add_media',[$mode]) }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>New image</span>
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
                            <th  style="width:10px;">#</th>
                            <th align="center;" style="width:80px;">Image</th>
                            <th>Community</th>
                            <th style="max-width:50px;">Hero</th>
                            <th>Title</th>
                            <th>Tooltip</th>
                            <th style="width:140px;">Created Date</th>
                            <th style="width:140px;">Last Updated</th>
                            <th style="width:75px;" class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($images as $index=>$image)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>
                                    @if($image->thumb && file_exists(public_path('images/gallery/thumbs/thumb/'.$image->thumb))) 
                                        
                                        {{ asset('images/gallery/thumbs/thumb/'.$image->thumb) }}
                                    @else 
                                        
                                        {{ asset('images/gallery/thumbs/thumb/default.png') }}

                                    @endif
                                </td>
                                <td>{{ $image->communityName }}</td>
                                <td>{{ $image->subcontent === 0 ? "Yes" : "No" }}</td>
                                <td>{{$image->img_title != '' ?  $image->img_title : ''}}</td>
                                <td>{{$image->img_tooltip !='' ?  $image->img_tooltip : ''}}</td>
                                <td><span class="dateSort">{{strtotime($image->created_at) > 0 ?  $image->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($image->created_at) > 0 ?  $image->created_at->format(DATE_FORMAT) : '-'}}</td>
                                <td><span class="dateSort">{{strtotime($image->updated_at) > 0 ?  $image->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($image->updated_at) > 0 ?  $image->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                <td>
                                    <a href="{{ route('admin.edit_media',[$image->id,$mode]) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                    <i class="la la-edit"></i>
                                    </a>
                                    <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$image->id}}');"><i class="la la-trash" title="Delete"></i>
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

@endsection

@section('additional_javascript')
    <script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/media_library.js') }}"></script>            
@endsection

