@extends('layouts.data')

@section('title', 'Purchase detail | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="app-section app-reveal-section align-items-center">
            <a href="{{ route('account.sales') }}" class="back-icon text-grey">
            <i class="fa fa-arrow-left"></i><span>Back</span></a>
        	<div class="row blog-header">
                <div class="col-md-12">
        			<h1>{{$detail->productTitle}}</h1>
                	<p class="para text-bold">
                        @foreach($detail->region as $key=>$region)
                            {{$region->regionName}}
                            @if(count($detail->region)>$key+1)
                            <span>,</span>
                            @endif
                        @endforeach
                    </p>
                </div>
    		</div>
            <div class="app-monetize-section-item0 ml-0 mt-20"></div>
            <div class="blog-content">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.from') }}: </div></td>
                                            <td><div class="col info-text">{{$company}}</div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.format') }}: </div></td>
                                            <td><div class="col info-text">{{$detail->productType}}</div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.price') }}: </div></td>
                                            <td>
                                                <div class="col info-text">
                                                    @if($detail->productBidType=="free")
                                                    <span class="text-red">Free</span>
                                                    @else
                                                    <span class="text-red">€ {{$detail->bidPrice!=0 ? $detail->bidPrice : $detail->productPrice}}</span> (tax incl.)
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.access_to_this_data') }}: </div></td>
                                            <td>
                                                <div class="col">
                                                    <span class="info-text">1 {{$detail->productAccessDays}}</span>
                                                    <span class="fs-14"> ( From : {{date('d/m/Y', strtotime($detail->from))}} until {{date('d/m/Y', strtotime($detail->to))}} )</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-md-12">
                            @if($detail->productType=="Api flow")
                                <p class="fs-16">{{$detail->offerDescription}}</p>
                                <div class="mt-20">
                                    <span class="info-label">{{trans('data.api_key')}}:</span>
                                    <span class="info-text" id="uniqueId">{{$detail->apiKey}}</span>
                                    <span class="copy-id"><a class="link-market" id="copyToClipboard">Copy key</a></span>
                                </div>
                                <div class="mt-20">
                                    <span class="info-label fs-10">Transaction ID:</span>
                                    <span class="info-label fs-10">{{$detail->transactionId}}</span>
                                </div>
                            @elseif($detail->productType=="Stream")
                                <p class="fs-16">{{$detail->offerDescription}}</p>
                                @if(isset($stream))
                                <div class="mt-20">
                                    <span class="info-label">{{trans('data.stream_ip')}}:</span>
                                    <span class="info-text">{{$stream->IP}}</span>
                                    <span class="mlr-20"><b>:</b></span>
                                    <span class="info-label">{{trans('data.stream_port')}}:</span>
                                    <span class="info-text">{{$stream->port}}</span>
                                </div>
                                @endif
                                <div class="mt-20">
                                    <span class="info-label">{{trans('data.api_key')}}:</span>
                                    <span class="info-text" id="uniqueId">{{$detail->apiKey}}</span>
                                    <span class="copy-id"><a class="link-market" id="copyToClipboard">Copy key</a></span>
                                </div>
                                <div class="mt-20">
                                    <span class="info-label fs-10">Transaction ID:</span>
                                    <span class="info-label fs-10">{{$detail->transactionId}}</span>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection