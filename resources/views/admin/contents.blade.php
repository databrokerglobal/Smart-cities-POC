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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Contents</b></h3>
                @if(count($Contents) < 8)
                    <div class="ggn-r"><a href="{{ route('admin.add.contents') }}" class="btn btn-primary text-right">Add New</a></div>
                @endif
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="admin_users">
                        <thead>
                            <tr>
                                <th style="width:5px;">#</th>                           
                                <th style="width:100px;">Image</th>      
                                <th style="width:100px;">Title</th>
                                <th style="width:120px;">Meta Title </th>
                                <th style="width:150px;">Meta Data</th>
                                <th style="width:100px;">Sort Order</th>
                                <th style="width:100px;">Status</th>
                                <th style="width:145px;" class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Contents as $index=>$content)                       
                                <?php
                                $offer_region = ""; ?>
                                <tr>
                                    <td class="details-control">{{$index+1}}</td>                                
                                    <td class="details-control">
                                        @if(!empty($content->content_image_path) && file_exists(public_path($content->content_image_path)))
                                            <img height="40px" src="<?=asset($content->content_image_path)?>"/>
                                        @else
                                            <img height="40px" src='{{ asset("uploads/default.png") }}'/>
                                        @endif
                                    </td>  
                                    <td class="details-control">{{isset($content->content_title) ? $content->content_title : ""}}</td>
                                    <td class="details-control">{{isset($content->meta_title) ? $content->meta_title : ""}}</td>
                                    <td class="details-control">{{isset($content->meta_data) ? $content->meta_data : ""}}</td>  
                                    <td class="details-control">{{isset($content->sortOrder) ? $content->sortOrder : ""}}</td>  
                                    <td class="details-control">{{$content->isActive == 1 ? "Active" : "Inactive"}}</td>
                                    <td class="details-control">
                                    
                                    <a href="contents/edit/{{$content->id}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                    <i class="la la-edit"></i>
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
    <script src="{{ asset('adminpanel/js/content.js') }}"></script>            
@endsection

