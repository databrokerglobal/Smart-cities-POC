@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style type="text/css">
        #admin_users tr:hover{cursor: pointer;}
        #admin_users tr.shown{background-color: #f7f8fa;}
        #admin_users .table-child{background-color: #f7f8fa;}
        #admin_users .table-child td{padding: 10px 10px;}
        #admin_users .table-child-title{position: absolute;left: 30%; right: 30%;}
        #admin_users .hidden{display: none;}
    </style>
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto width-100">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Company</b> Admin Users</h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <input type="hidden" value="{{APPLICATION_NAME.'_Users_'.str_Replace(' ','_',date(SIMPLE_DATE)).'_'.time()}}" id="export-file-name"> 
            <div class="m-portlet__body exportable-list table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="admin_users">
                    <thead>
                        <tr>
                            <th class="hidden"></th>
                            <th></th>
                            <th style="min-width:40px;">User ID</th>
                            <th style="min-width:75px;">Registered On</th>
                            <th style="min-width:100px;">Company</th>
                            <th style="min-width:100px;">Industry</th>
                            <th style="min-width:100px;">Email</th>
                            <th style="min-width:75px;">Firstname</th>
                            <th style="min-width:75px;">Lastname</th>
                            <th style="min-width:75px;">Role</th>
                            <th style="min-width:75px;">Users</th>
                            <th style="min-width:75px;">Products</th>
                            <th style="min-width:75px;">Status</th>                           
                            <th style="min-width:120px;" class="action-col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="hidden">{{$user->count_all}}</td>
                                <td class="details-control">
                                @if($user->count_all != 0)
                                    <h4>+</h4>
                                @endif
                                </td>
                                <td class="details-control " align="center">{{$user->userIdx}}</td>
                                <td class="details-control"><?php echo strtotime($user->created_at) > 0 ? '<span class="hidden">'.strtotime($user->created_at).'</span>'.$user->created_at->format(SIMPLE_DATE):'-' ?></td>
                                <td class="details-control">{{ $user->companyName}}</td>
                                <td class="details-control">{{ $user->businessName}}</td>
                                <td class="details-control" style="min-width:100px;">{{ $user->email}}</td>
                                <td class="details-control">{{ $user->firstname}}</td>
                                <td class="details-control">{{ $user->lastname }}</td>  
                                <td class="details-control">{{ $user->role }}</td>  
                                <td class="details-control">{{$user->count_all}} invited/{{$user->count_pending}} pending</td>  
                                <td class="details-control">{{$user->count_products}}</td>  
                                <td class="details-control">
                                    @if($user->userStatus && $user->email_verified_at != null)
                                        Active
                                    @elseif(!$user->userStatus && $user->email_verified_at == null)
                                        Inactive
                                    @elseif($user->userStatus && $user->email_verified_at == null)
                                        Verifying
                                    @else
                                        Inactive
                                    @endif
                                </td>                               
                                <td class="details-control">
                                   @if($user->userStatus == 1)
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$user->userIdx}}');" title="Click to Make Inactive">
                                        <i class="la la-eye"></i></a>
                                   @else
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('{{$user->userIdx}}');" title="Click to Make Active">
                                         <i class="la la-eye-slash"></i></a>
                                   @endif
                                <a href="users/edit/{{$user->userIdx}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                <i class="la la-edit"></i></a><a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$user->userIdx}}');"><i class="la la-trash" title="Delete"></i>
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
    <script src="{{ asset('adminpanel/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/users.js') }}"></script>            
@endsection

