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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Products</b></h3>
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
                                <th>Title</th>
                                <th style="width:120px;">Region</th>
                                <th>Seller</th>
                                <th style="width:140px;">Created Date</th>
                                <th style="width:140px;">Last Updated</th>
                                <th style="width:145px;" class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($OfferProducts as $index=>$product)
                                <?php
                                $offer_region = ""; ?>
                                <tr>
                                    <td class="details-control">{{$index+1}}</td>
                                    
                                    <td class="details-control">{{isset($product->productTitle) ? $product->productTitle : ""}}</td>
                                
                                    <td class="details-control"> 
                                    @if(count($product->region) > 0)
                                        <?php $regionName = []; ?>
                                        @foreach($product->region as $key=>$regionVal)
                                            
                                            <?php 
                                            $offer_region = $offer_region . str_replace(' ', '-', strtolower($regionVal->regionName));
                                            if($key+1 < count($product->region)) $offer_region = $offer_region . "-";
                                            $regionName[] = $regionVal->regionName ?>
                                        @endforeach
                                        {{implode(',',$regionName)}}
                                    @else
                                    -
                                    @endif
                                    
                                    </td>
                                    <td class="details-control">
                                    {{$product->firstname}} {{$product->lastname}}
                                    
                                    </td>
                                    
                                    <td class="details-control"><span class="dateSort">{{strtotime($product->offercreated) > 0 ?  date(SORTABLE_DATE_TIME, strtotime($product->offercreated)) : '-'}}</span>{{strtotime($product->offercreated) > 0 ? date(DATE_FORMAT, strtotime($product->offercreated)) : '-'}}</td>
                                    <td class="details-control"><span class="dateSort">{{strtotime($product->offercupdated) > 0 ?  date(SORTABLE_DATE_TIME, strtotime($product->offercupdated)) : '-'}}</span>{{strtotime($product->offercupdated) > 0 ?  date(DATE_FORMAT, strtotime($product->offercupdated)) : '-'}}</td>
                                    <td class="details-control">
                                    

                                        <a target="_blank" href="{{route('admin.products.view',[$product->productIdx])}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                        <i class="la la-eye"></i>
                                        </a>
                                        <a href="products/edit/{{$product->productIdx}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                        <i class="la la-edit"></i>
                                        </a>
                                        <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" 
                                            onclick="wantDelete('{{$product->productIdx}}');"><i class="la la-trash" title="Delete"></i>
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
    <script src="{{ asset('adminpanel/js/product.js') }}"></script>            
@endsection

