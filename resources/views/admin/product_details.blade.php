@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
               View Product Details</h3>
               
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <!--begin::Portlet-->
        <div class="m-portlet">
                <div class="m-portlet__body">                    
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-control-label"><strong>Product Title </strong></label>
                                </div>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <div class="name-ty">{{$product[0]['productTitle']}}</div>
                                </div>
                           </div>
                        </div>
                        <div class='col-md-12 col-12'>
                            <div class="row"> 
                                <div class="col-md-2">
                                    <label class="form-control-label"><strong>Region</strong></label>
                                </div>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <div class="name-ty">	
                                        @foreach($product[0]['region'] as $region)
                                            <span>{{ $region->regionName }}</span>
                                        @endforeach
                                    </div>  
                                </div>   
                            </div>                                                                             
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="row"> 
                                <div class="col-md-2">
                                        <label class="form-control-label"><strong>Product Format</strong></label>
                                </div>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                        <div class="name-ty">{{ $product[0]->productType}}</div> 
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="row"> 
                                <div class="col-md-2">
                                        <label class="form-control-label"><strong>Product Type</strong></label>
                                </div>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                        <div class="name-ty">{{ $product[0]->offerType}}</div> 
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="row"> 
                                <div class="col-md-2">
                                        <label class="form-control-label"><strong>Product Status</strong></label>
                                </div>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                        <div class="name-ty">	
                                            @if ( $product[0]->productStatus == 1 )
												{{ trans('pages.published') }}
											@else
												{{ trans('pages.unpublished') }}
											@endif
                                        </div> 
                                </div>
                            </div>    
                        </div>
                        <div class='col-md-12 col-12'>
                            <div class="row"> 
                                <div class="col-md-2">
                                        <label class="form-control-label"><strong>{{ trans('pages.price') }}</strong></label>
                                </div>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                        <div class="name-ty">
                                            @if($product[0]->productBidType =="bidding_only")
                                                N/A
                                                @elseif($product[0]->productBidType=="free")
                                                <span class="value text-warning">FREE</span>
                                                @else						
                                                <div class="form-group">					                                                    
                                                    @foreach($product['productpricemappings'] as $key => $mapping)
                                                        <p><span>Per {{$mapping->productAccessDays}} :</span>  
                                                        <span> {{$mapping->productPrice}} € (tax incl.) </span></p>
                                                    @endforeach                                                    										
                                                </div>
                                            @endif
                                        </div> 
                                </div>
                            </div>                       
                    </div>                                       
                </div>
                </div>    
            </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                               
                                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>           
        </div>
        <!--end::Portlet-->
    </div>
</div>
@endsection

@section('additional_javascript')
    <script src="{{ asset('adminpanel/js/configuration_add_new.js') }}"></script>   
    
@endsection

