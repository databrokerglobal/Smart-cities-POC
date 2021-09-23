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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">User Activity Logs</b></h3>
                
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>                          
                                <th>Action On</th>                           
                                <th>Detail</th>
                                <th>Action By</th>
                                <th>On Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $index=>$log)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{ $log->action_type }}</td>                               
                                    <td>{{ $log->action_detail }}</td>
                                    <td>
                                    @if($log->action_by == 'admin') 
                                    {{ 'Admin' }}
                                    @elseif($log->action_by > 0 &&  !empty($log->user->firstname)) 
                                        {{ $log->user->firstname }} {{ $log->user->lastname }}
                                    @else
                                        {{ '---' }}
                                    @endif  

                                </td>                            
                                    <td class="text-nowrap"><span class="dateSort">{{strtotime($log->created_at) > 0 ?  $log->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($log->created_at) > 0 ?  $log->created_at->format(DATE_FORMAT) : '-'}}</td>
                                
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
    <script src="{{ asset('adminpanel/js/logs.js') }}"></script>            
@endsection

