@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style type="text/css">
        #admin_users tr:hover{cursor: pointer;}
        #admin_users tr.shown{background-color: #f7f8fa;}
        #admin_users .table-child{background-color: #f7f8fa;}
        #admin_users .table-child td{padding: 10px 20px;}
        #admin_users .table-child-title{position: absolute;left: 200px;}
        #admin_users .hidden{display: none;}
    </style>
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto width-100">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">All Purchases</h3>
                <div class="ggn-r"><a href="{{ route('admin.purchases.export') }}" class="btn btn-primary text-right">Export Purchase List</a></div>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="admin_purchase_list">
                        <thead>
                            <tr>
                                <th class="hidden"></th>
                                <th >Purchase ID</th>
                                <th >Product Name</th>
                                <th >Buyer</th>
                                <th >Seller</th>
                                <th>Price</th>
                                <th >Valid From</th>
                                <th >Valid Till</th>                                                    
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $key=>$purchase)                                         
                                <tr>
                                    <td class="hidden"></td>
                                    <td >
                                        {{$purchase->purchaseIdx}}
                                    </td>
                                    <td class="details-control" align="center">{{$purchase->productTitle}}</td>
                                    <td>{{$purchase->buyyer_name}}</td>
                                    <td>{{$purchase->firstname." ".$purchase->lastname}}</td>    
                                    <td>
                                                @if($purchase->productBidType=="free")
                                                    <span class="text-red">Free</span>
                                                @else
                                                    <span class="text-red">€ {{$purchase->bidPrice!=0 ? $purchase->bidPrice : $purchase->amount}}</span> 
                                                @endif
                                    </td>                            
                                    <td class="details-control"><span class="dateSort">{{strtotime($purchase->from) > 0 ?  date(SORTABLE_DATE, strtotime($purchase->from)) : '-'}}</span>{{date('d/m/Y', strtotime($purchase->from))}}</td>
                                    <td class="details-control"><span class="dateSort">{{strtotime($purchase->to) > 0 ?  date(SORTABLE_DATE, strtotime($purchase->to)) : '-'}}</span>{{date('d/m/Y', strtotime($purchase->to))}}</td>                                
                                    
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
    <script src="{{ asset('adminpanel/js/purchases.js') }}"></script>            
@endsection

