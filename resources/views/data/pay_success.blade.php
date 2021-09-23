@extends('layouts.data')

@section('title', 'Payment was successful | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="app-section app-reveal-section align-items-center">
        	<div class="row blog-header">
                <div class="col-md-12">
        			<h1>{{trans('data.your_payment_success')}}</h1>
                	<p class="para text-bold">{{trans('data.ready_to_use')}}</p>
                </div>
    		</div>
            <div class="app-monetize-section-item0 ml-0 mt-20"></div>
            <div class="blog-content">
                <div class="row"> 
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                @if($product->productType=="Api flow")
                                    <p class="fs-16">
                                        Access the API now.<br/>
                                        We also sent you a confirmation via email including a link to the API access information.<br/>
                                        The link expires on {{$expire_on}} so make sure to access the information before this date.<br/>
                                        You can also access it via <a href="{{App\Helper\SiteHelper::forceHttps(route('account.purchases'))}}">Purchases</a> in your account.
                                    </p>
                                @elseif($product->productType=="Stream")
                                    <p class="fs-16">
                                        Access the data stream now.<br/>
                                        We also sent you a confirmation via email including a link to the data stream.<br/>
                                        The link expires on {{$expire_on}} so make sure to access the data stream before this date.<br/>
                                        You can also access it via <a href="{{App\Helper\SiteHelper::forceHttps(route('account.purchases'))}}">Purchases</a> in your account.
                                    </p>
                                @elseif($product->productType=="File")
                                    <p class="fs-16">
                                        Download the file now.<br/>
                                        We also sent you a confirmation via email including a link to download the data.<br/>
                                        The link expires at {{$expire_on}} so make sure you download the data before this date.<br/>
                                        You can also access it via <a href="{{App\Helper\SiteHelper::forceHttps(route('account.purchases'))}}">Purchases</a> in your account.
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-md-12">
                                <p class="fs-24 para text-bold mb-0">{{$product->productTitle}}</p>
                                <p class="para fs-16">
                                    @foreach($product->region as $key=>$region)
                                        <span>{{ $region->regionName }}</span>
                                        @if(count($product->region) > $key+1)
                                        <span>, </span>
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.from') }}: </div></td>
                                            <td><div class="col info-text">{{$product->companyName}}</div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.format') }}: </div></td>
                                            <td><div class="col info-text">{{$product->productType}}</div></td>
                                        </tr>
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.access_to_this_data') }}: </div></td>
                                            <td>
                                                <div class="col info-text">
                                                1 {{$product->productAccessDays}} ( From : {{$from}} until {{$to}} )
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-md-12">
                            @if($product->productType=="Api flow" && !empty($dataAccess))
                                <p class="fs-16">{{$product->offerDescription}}</p>
                                <div class="mt-20">
                                    <span class="info-label fs-10">Transaction ID:</span>
                                    <span class="info-label fs-10">{{$transactionId}}</span>
                                </div>
                                <div class="mt-20">
                                    <span class="info-label">API URL:</span>
                                    <span class="info-text">{{$dataAccess->url}}</span>
                                </div>
                                <div class="mt-20">
                                    <span class="info-label">API Product Key:</span>
                                    <span class="info-text" id="uniqueId" style="word-break: break-all;">{{$dataAccess->DXC_PRODUCT_KEY}}</span>
                                    <span class="copy-id"><a class="link-market" id="copyToClipboard">Copy key</a></span>
                                </div>
                                <div class="buttons flex-vcenter mt-20">
                                    <a href="{{App\Helper\SiteHelper::forceHttps(route('home'))}}"><button type="button" class="customize-btn btn-next">{{ trans('data.continue_to_databroker') }}</button></a>
                                </div>
                            @elseif($product->productType=="Stream")
                                <p class="fs-16">{{$product->offerDescription}}</p>
                                <div class="mt-20">
                                    <span class="info-label fs-10">Transaction ID:</span>
                                    <span class="info-label fs-10">{{$transactionId}}</span>
                                </div>
                                <div class="buttons flex-vcenter mt-20">
                                    <a href="{{App\Helper\SiteHelper::forceHttps(route('data.configure_stream', ['purIdx'=>$product->purchaseIdx]))}}">
                                        <button type="button" class="customize-btn btn-next">{{ trans('data.configure_now') }}</button>
                                    </a>
                                </div>
                            @elseif($product->productType=="File")
                                <div class="buttons flex-vcenter"  style="display: grid;">
                                    <a href="{{$dataAccess->url}}">
                                        <button type="button" class="customize-btn btn-next">{{ trans('data.download_file') }}</button>
                                    </a>
                                    <br>
                                    <p><b>Note : </b> If the downloaded file opens in the browser, please right click on download button and use <b>"Save link as or Download link as"</b> option.</p>
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