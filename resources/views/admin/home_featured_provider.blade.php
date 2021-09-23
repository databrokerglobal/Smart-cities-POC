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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Home</b> Featured Data Providers</h3>
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
                                <a href="{{ route('admin.home_featured_provider_add_new') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>New Provider</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route('admin.preview_home', [ 'url' => 'admin.home_featured_provider', 'model' => 'HomeFeaturedProvider' ]) }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
            <div class="m-portlet__body table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table">
                    <thead>
                        <tr>
                            <th align="center">Logo</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Company Name</th>
                            <th>Company URL</th>
                            <th>Company VAT</th>
                            <th align="center">Order</th>
                            <th  align="center" class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($boards as $board)  
                        
                        @php
						    $companyName = str_replace(' ', '-', strtolower($board->companyName));
                        @endphp
                    
                            <tr>
                                <td align="center">
                                    <a  target ="_blank" href="{{ route('data.company_offers', $companyName) }}">
                                    @if(file_exists(public_path("uploads/company/thumb/".$board->companyLogo))) 
                                        <img src='{{ asset("uploads/company/thumb/".$board->companyLogo) }}' style="height: 40px;">
                                    @elseif(file_exists(public_path("uploads/company/".$board->companyLogo)))
                                        <img src='{{ asset("uploads/company/".$board->companyLogo) }}' style="height: 40px;">
                                    @else 
                                        <img src='{{ asset("uploads/company/default.png") }}' style="height: 40px;">
                                    @endif
                                    </a>
                                </td>
                                <td>{{ $board->firstname }}</td>
                                <td>{{ $board->lastname }}</td>
                                <td><a target ="_blank" href="{{ route('data.company_offers', $companyName) }}">{{$board->companyName}}</a></td>
                                <td>
                                    @if(preg_match("@^https?://@", $board->companyURL)) <a href="{{ $board->companyURL }}">{{$board->companyURL}}</a>
                                    @else <a href="https://{{ $board->companyURL }}">{{$board->companyURL}}</a>
                                    @endif
                                </td>
                                <td>{{ $board->companyVAT }}</td>
                                <td  align="center">{{ $board->order }}</td>
                                
                                <td>
                                    @if($board->active == 1) 
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$board->id}}');" title="Click to Unpublish">
                                        <i class="la la-thumbs-up"></i></a>
                                        @else
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('{{$board->id}}');" title="Click to Publish">
                                            <i class="la la-thumbs-down"></i></a>
                                        @endif 
                                        <a href="{{route('admin.home_featured_provider_edit',$board->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                    <i class="la la-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="return wantDelete('{{$board->id}}');"><i class="la la-trash" title="Delete"></i>
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
    <script src="{{ asset('adminpanel/js/home_featured_provider.js') }}"></script>            
@endsection

