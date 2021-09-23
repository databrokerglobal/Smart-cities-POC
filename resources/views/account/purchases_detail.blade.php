@extends('layouts.data')

@section('title', 'Purchase detail | Databroker ')

@section('content')
<div class="container-fluid app-wapper bg-pattern-side app-wapper-success">
	<div class="container">
        <div class="app-section app-reveal-section align-items-center">
            <a href="{{ App\Helper\SiteHelper::forceHttps(route('account.purchases')) }}" class="back-icon text-grey"><i class="material-icons">keyboard_backspace</i><span>Back</span></a>
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
                                                    <span class="text-red">€ {{$detail->bidPrice!=0 ? $detail->bidPrice : $detail->amount}}</span> (tax incl.)
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td><div class="info-label">{{ trans('data.access_to_this_data') }}: </div></td>
                                            <td>
                                                <div class="col">
                                                    <span class="info-text">1 {{$purchase_det->productAccessDays}}</span>
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
                            @if($detail->productType=="Api flow" && !empty($dataAccess))
                                <p class="fs-16">{{$detail->offerDescription}}</p>
                                <div class="mt-20">
                                    <span class="info-label fs-10">Transaction ID:</span>
                                    <span class="info-label fs-10">{{$detail->transactionId}}</span>
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
                                <div class="buttons flex-vcenter mt-20">
                                    <a href="{{route('data.configure_stream', ['purIdx'=>$detail->purchaseIdx])}}">
                                        <button type="button" class="customize-btn btn-next">{{ trans('data.configure_now') }}</button>
                                    </a>
                                </div>
                            @elseif($detail->productType=="File" && empty($dataAccess))
                                <!-- @php print_r($dataAccess); @endphp -->
                                <div class="buttons flex-vcenter" style="display: grid;">
                                    
                                    <a href="{{$detail->productUrl}}" download>
                                        <button type="button" class="customize-btn btn-next">{{ trans('data.download_file') }}</button>                                       
                                    </a>
                                    <br>
                                    <p><b>Note : </b> If the downloaded file opens in the browser, please right click on download button and use <b>"Save link as or Download link as"</b> option.</p>
                                    
                                </div>
                            @elseif($detail->productType=="File" && !empty($dataAccess))  
                                <div class="buttons flex-vcenter" style="display: grid;">                        
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

<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="post" post>
            @csrf
            <input type="hidden" name="list_userIdx" value="">
            <input type="hidden" name="user_type" value="">
            <p class="para text-center">
            Please click on save button to download
            </p>                
        </form>        
      </div>            
      <div class="modal-footer text-left" style="margin:auto">     
          <input type="hidden" id="file_name_download" />   
        <button type="button" class="button primary-btn confirm" onclick="downloadFile()">Save</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('additional_javascript')    
    <script>
 function openModel(self){
    var name = $(self).data('name');
   // $('.para').html(" Are you sure you want to Download "+name);
    $('#file_name_download').val(name);
    $('#downloadModal').modal('show');
 }
 
 
 function downloadFile(){
    
    var name = $('#file_name_download').val();
    
    var extension = name.substr( (name.lastIndexOf('.') +1) );
    var extensionArr = ['pdf','txt'];
    
    if(jQuery.inArray(extension, extensionArr) == -1) {
		
        window.location.href = name;
    }else{

        if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = name;
        save.target = '_blank';
        var filename = name;
        save.download = filename;
	       if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
				document.location = save.href; 
        // window event not working here
                    }else{
                        var evt = new MouseEvent('click', {
                            'view': window,
                            'bubbles': true,
                            'cancelable': false
                        });
                        save.dispatchEvent(evt);
                        (window.URL || window.webkitURL).revokeObjectURL(save.href);
                    }	
            }

            // for IE < 11
            else if ( !! window.ActiveXObject && document.execCommand)     {
                var _window = window.open(fileURL, '_blank');
                _window.document.close();
                _window.document.execCommand('SaveAs', true, fileName || fileURL)
                _window.close();
            }
    }
    $('#file_name_download').val("");
    $('#downloadModal').modal('hide');
}

</script>
@endsection