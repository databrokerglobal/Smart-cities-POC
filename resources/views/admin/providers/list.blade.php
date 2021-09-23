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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Providers</b></h3>
               
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-bordered table-stripped table-hover mt-2 dataTable no-footer" id="board_table">
                        <thead>
                            <tr>
                                <th style="width:10px;">#</th>
                                <th style="width:120px;">Image</th>
                                <th style="width:200px;">Company Name</th>
                                <th style="width:140px;">Created Date</th>
                                <th style="width:140px;">Last Updated</th>
                                <th style="width:120px;" class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1 @endphp
                            @foreach($providers as $index=>$provider)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    
                                    <td> 
                                        @if($provider->companyLogo && file_exists(public_path('uploads/company/thumb/'.$provider->companyLogo))) 
                                            {{ asset('uploads/company/thumb/'.$provider->companyLogo) }}
                                        @else 
                                            {{ asset('/uploads/default.png') }}
                                        @endif
                                    </td>
                                    <td>{{ $provider->companyName }}</td>
                                                                
                                    <td><span class="dateSort">{{strtotime($provider->created_at) > 0 ?  $provider->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($provider->created_at) > 0 ?  $provider->created_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td><span class="dateSort">{{strtotime($provider->updated_at) > 0 ?  $provider->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($provider->updated_at) > 0 ?  $provider->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td>
                                    @if($provider->status == 1)

                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$provider->providerIdx}}');" title="Click to Unpublish">
                                        <i class="la la-thumbs-up"></i></a>
                                        @else
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('{{$provider->providerIdx}}');" title="Click to publish">
                                        <i class="la la-thumbs-down"></i></a>
                                        @endif
                                        
                                        <a href="{{route('admin.providers.edit',$provider->providerIdx)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                        <i class="la la-edit"></i>
                                        </a>
                                        <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$provider->providerIdx}}');"><i class="la la-trash" title="Delete"></i>
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
    <script src="{{ asset('adminpanel/js/providers.js') }}"></script>            
@endsection

