@extends('layouts.app')

@section('title', 'My purchases | Databroker ')

@section('content')
<div class="container-fluid app-wapper app-purchase-wapper">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section app-reveal-section align-items-center data-detail">
            <div class="blog-header">
                <h1>My purchases</h1>
                <p class="para">Here you can find an overview of all the data products you have purchased, including any products that were shared with you at no cost. 
                    <br>
                    Purchases are shown in chronological order, with the most recent activity at the top.
                </p>
                <div class="purchase-items">
                    @if(count($purchases))
                        @foreach($purchases as $key=>$purchase)
                    <div class="purchase-item">
                        <div class="row">
                            <div class="col-xl-1 col-lg-2 col-md-3 col-sm-3">
                                <div class="date-label">
                                    {{date('d/m/Y', strtotime($purchase->from))}}
                                </div>
                            </div>
                            <div class="col-xl-11 col-lg-10 col-md-9 col-sm-9">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12">
                                        <div class="mb-20">
                                            <h4 class="text-bold">
                                                {{$purchase->productTitle}}
                                            </h4>
                                            <div class="item-location">
                                                @foreach($purchase->region as $region)
                                                    {{$region->regionName}}
                                                @endforeach
                                            </div>
                                            <br>
                                            <div class="field-table">
                                                <div class="row field-row">
                                                    <div class="col-4 field-label">
                                                        Format:
                                                    </div>
                                                    <div class="col-8 field-value">
                                                        {{$purchase->productType}}
                                                    </div>
                                                </div>
                                                <div class="row field-row">
                                                    <div class="col-4 field-label">
                                                        Price:
                                                    </div>
                                                    <div class="col-8 field-value">
                                                        @if($purchase->productBidType=="free")
                                                        <span>Free</span>
                                                        @else
                                                        <span>€ {{$purchase->bidPrice!=0 ? $purchase->bidPrice : $purchase->amount}} (tax incl.)</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row field-row">
                                                    <div class="col-4 field-label">
                                                        Access to this data:
                                                    </div>
                                                    <div class="col-8 field-value">
                                                        1 {{$purchase->accessDays}}
                                                        @if($purchase->accessDays == 'hour')
                                                            <span class="text-normal">
                                                                (From {{date('d/m/Y H:i:s', strtotime($purchase->from))}} to {{date('d/m/Y H:i:s', strtotime($purchase->to))}})
                                                            </span>
                                                        @else
                                                            <span class="text-normal">
                                                                (From {{date('d/m/Y', strtotime($purchase->from))}} to {{date('d/m/Y', strtotime($purchase->to))}})
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 seller">
                                                <div class="mb-20">
                                                    <h4 class="company">
                                                        {{$purchase->companyName}}
                                                    </h4>
                                                    @if($purchase->productBidType=="free")
                                                    <div class="price">Free</div>
                                                    @else
                                                    <div class="price">
                                                        € {{$purchase->bidPrice!=0 ? $purchase->bidPrice : $purchase->amount}} <span class="color-black">(tax incl.)</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 warranty">
                                                <div class="mb-20">
                                                    <h4>
                                                        Warranty expires on
                                                    </h4>
                                                    <div class="date">
                                                        {{date('d/m/Y', strtotime('+30 days', strtotime($purchase->from)))}}
                                                    </div>
                                                    @if($purchase->productMoreInfo)
                                                    <li class="more_dropdown">
                                                        <a href="javascript:;" class="more_info">More Info <i class="material-icons">arrow_drop_down</i>
                                                            <i class="material-icons open">arrow_drop_up</i>
                                                        </a>
                                                        <div>
                                                            {{$purchase->productMoreInfo}}
                                                        </div>
                                                    </li>
                                                    @endif
                                                    <div class="mt-20">Problems with the data?</div>
                                                    <a href="{{route('help.send_file_complaint').'?pid='.$purchase->productIDX}}">File a complaint</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($purchase->is_accessble_now == true)
                                <div class="row">
                                    <!-- <div class="col-xl-12"> -->
                                        @if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($purchase->to)))
                                            <div class="text-grey col-md-3">The link to the data product expired on {{date('d/m/Y', strtotime('+1 day', strtotime($purchase->to)))}}</div>
                                        @else
                                        <div class='col-md-6 col-sm-6 col-lg-4 col-12'>
                                            <a href="{{App\Helper\SiteHelper::forceHttp(route('account.purchases_detail', ['pid'=>$purchase->purchaseIdx]),true)}}">
                                                <button class="btn readmore-inourblog-btn pure-material-button-outlined btn-transparent mt-0">
                                                    View data product
                                                </button>
                                            </a>
                                            <div class="text-grey">Link expires on {{date('d/m/Y', strtotime('+1 day', strtotime($purchase->to)))}}</div>
                                        </div>
                                        @endif
                                        @php $extend_date = "";@endphp
                                        @if(date('Y-m-d') < date('Y-m-d', strtotime($purchase->to)))
                                                @php $extend_date = date('Y-m-d', strtotime($purchase->to)); @endphp                                                
                                        @endif
                                       
                                        @if($purchase->productBidType!="free" && $purchase->isExtended == 0)                                           
                                            <div class='col-md-6 col-sm-6 col-lg-4 col-12'>
                                                <a href="{{route('data.buy_data', ['id'=>$purchase->offerIdx, 'pid'=>$purchase->productIDX,'expiredate' => $extend_date])}}">
                                                    <button class="button customize-btn" style='margin: 0 !important;'>
                                                        Extend
                                                    </button>
                                                </a>
                                            </div>
                                        @elseif($purchase->isExtended == 0)
                                            <div class='col-md-3'>
                                                 <a href="{{route('data.get_data', ['id'=>$purchase->offerIdx, 'pid'=>$purchase->productIDX,'expiredate' => $extend_date])}}">
                                                    <button class="button customize-btn" style='margin: 0 !important;'>
                                                        Extend
                                                    </button>
                                                </a>
                                            </div>
                                        @endif                                    
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
</div>