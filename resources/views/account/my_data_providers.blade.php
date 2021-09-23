@extends('layouts.app')

@section('title', 'My Data Users | Databroker')
@section('description', '')

@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">    
@endsection

@include('modals/private_share')
@section('content')
<div class="container-fl.uid app-wapper myaccount">
    <div class="bg-pattern1-left"></div>
	<div class="app-section app-reveal-section align-items-center">	    
		<div class="container blog-header">
            <h2><b>{{ trans('pages.MY_DATA_PROVIDERS_TITLE')}}</b></h2>
            <p>{{ trans('pages.MY_DATA_PROVIDERS_PAGE_CONTENT')}}</p>
            
            <div class="my-4">
                    
                <div class="table-responsive">
                    <table class="table collapsetable ">
                    <thead>
                        <tr>
                            <th scope="col"><b>Organization</b></th>
                            <th scope="col"><b>Valid Until</b></th>                            
                            <th scope="col"><b>Action</b></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($providers as $key => $provider)


                            <tr >
                                <td  class="accordion-toggle collapsed colspan3" 
                                    id="accordion<?=$key?>" data-toggle="collapse" data-parent="#accordion<?=$key?>" 
                                        href="#collapse<?=$key?>" >
                                        <span class='expand-button'></span>{{$provider->companyName}} (<a href="javascript:void(0)">{{count($provider->shared_products)}}</a>)</td>
                                <td class='colspan3' ></td>
                               
                                <td class='colspan3'>
                                        
                                </td>

                            </tr>
                             <tr class="hide-table-padding">
                                    <!-- <td></td> -->
                                    <td colspan="4 ">
                                    <div id="collapse<?=$key?>" class="collapse in p-3">
                                    @foreach ($provider->shared_products as $product)
                                        @php                                        
                                            $companyName = $product->company_slug;
                                            $title = str_replace(' ', '-', strtolower($product->offerTitle) );
                                            $offer_region = "";
                                            foreach($product->regions as $key=>$r){                                                
                                                $offer_region = $offer_region . $r->slug;
                                                if($key+1 < count($offer['region'])) $offer_region = $offer_region . "-";
                                            }
                                        @endphp
                                        
                                        <div class="row">
                                            <div class="col-4">
                                            <a href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $offer_region])}}">{{$product->productTitle}}</a></div>
                                            @if($product->validTill == '' && $product->isExpired == false)   
                                                <div class="col-4">-</div>   
                                                <div class="col-4">
                                                    @if($product->productBidType == 'free')                                           
                                                        <a  href="{{route('data.get_data', ['id'=>$product->offerIdx, 'pid'=>$product->productIdx])}}"  class="btn btn-sm btn-danger action-botton">
                                                            Order
                                                        </a>
                                                    @elseif(!$product->dxc || !$product->did)
                                                        <a  href="{{route('data.send_message', ['id'=>$product->offerIdx])}}"  class="btn btn-sm btn-danger action-botton">
                                                                CONTACT SELLER
                                                        </a>
                                                    @elseif($product->productBidType == 'no_bidding')
                                                        <a  href="{{route('data.buy_data', ['id'=>$product->offerIdx, 'pid'=>$product->productIdx])}}"  class="btn btn-sm btn-danger action-botton">
                                                            Order
                                                        </a>
                                                    @elseif($product->productBidType == 'bidding_possible')
                                                        <a  href="{{route('data.buy_data', ['id'=>$product->offerIdx, 'pid'=>$product->productIdx])}}"  class="btn btn-sm btn-danger action-botton">
                                                            Order
                                                        </a>
                                                    @elseif($product->productBidType == 'bidding_only')
                                                        <a  href="{{route('data.bid', ['id'=>$product->offerIdx, 'pid'=>$product->productIdx,'ppmid'=>$product->productpricemapping->ppmIdx])}}"  class="btn btn-sm btn-danger action-botton">
                                                            SEND BID
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                            @if($product->validTill != '' && $product->isExpired == false) 
                                                <div class="col-4">{{$product->validTill}}</div>   
                                                <div class="col-4">                                           
                                                    <a  href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region])}}" class="btn btn-sm btn-danger action-botton" >
                                                            View Data Product
                                                    </a>
                                                </div>
                                            @endif
                                                                                      
                                            @if($product->validTill == '' && $product->isExpired == true)
                                                <div class="col-4">Expired</div>   
                                                <div class="col-4">                                           
                                                    <a  href="{{route('data_details', ['companyName'=>$companyName, 'param'=>$title . '-' . $region])}}" class="btn btn-sm btn-danger action-botton" >
                                                        Extend
                                                    </a>  
                                                </div>  
                                            @endif
                                            
                                        </div>
                                    @endforeach
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
