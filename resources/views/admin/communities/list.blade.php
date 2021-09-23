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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Communities</b></h3>
                <div class="ggn-r">
                    <a href="{{ route('admin.community.data.new') }}" class="btn btn-primary text-right">New Data In Communities</a>
                    <a href="{{ route('admin.community.data.discover') }}" class="btn btn-primary text-right">Discover Community Data</a>
                    <a href="{{ route('admin.communities.add') }}" class="btn btn-primary text-right">Add Community</a>
                </div>
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
                                <th style="width:120px;">Image</th>
                                <th>Title</th>
                                <th>Order</th>
                                <th style="width:145px;">Created Date</th>
                                <th style="width:145px;">Last Updated</th>
                                <th style="width:70px;" class="hidden">Status</th>
                                <th style="width:150px;" class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($communities as $index=>$community)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    
                                    <td> 
                                        @if($community->image && file_exists(public_path('uploads/communities/thumb/'.$community->image))) 
                                            {{ asset('uploads/communities/thumb/'.$community->image) }}
                                        @else 
                                            {{ asset('images/gallery/thumbs/thumb/default.png') }}
                                        @endif
                                    </td>
                                    <td>{{ $community->communityName }}</td>
                                    <td>{{ $community->sort }}</td>
                                                                
                                    <td><span class="dateSort">{{strtotime($community->created_at) > 0 ?  $community->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($community->created_at) > 0 ?  $community->created_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td><span class="dateSort">{{strtotime($community->updated_at) > 0 ?  $community->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($community->updated_at) > 0 ?  $community->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td class="hidden">{{STATUS[$community->status]}}</td>
                                    <td>{{$community->communityIdx}}</td>
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
    <script src="{{ asset('adminpanel/js/communities.js') }}"></script>
@endsection

