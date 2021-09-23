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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Help - Selling Data </b>FAQs</h3>
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
                                <a href="{{ route('admin.help.add_selling_faq') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>New FAQ</span>
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
                            <th style="width:30px;">#</th>
                            <th>FAQ</th>
                            <th style="width:140px;">Created Date</th>
                            <th style="width:140px;">Last Updated</th>
                            <th  style="width:100px;" class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $index=>$faq)                      
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{ $faq->faq }}</td>
                                <td><span class="dateSort">{{strtotime($faq->created_at) > 0 ?  $faq->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($faq->created_at) > 0 ?  $faq->created_at->format(DATE_FORMAT) : '-'}}</td>
                                <td><span class="dateSort">{{strtotime($faq->updated_at) > 0 ?  $faq->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($faq->updated_at) > 0 ?  $faq->updated_at->format(DATE_FORMAT) : '-'}}</td>  
                                <td>{{ $faq->faqIdx }}</td>
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
    <script src="{{ asset('adminpanel/js/help_selling_faqs.js') }}"></script>            
@endsection

