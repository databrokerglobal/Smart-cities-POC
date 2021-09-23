<?php
use App\Models\Partner;
$partners = Partner::where('status', 1)->where('proud_partner',1)->orderby('created_at', 'desc')->limit(6)->get();
if($partners && count($partners) > 0){
?>
<div class="app-section app-monetize-section align-items-center">
			        <div class="app-monetize-section-item0"></div>
    <div class="app-monetize-section-item1">
        <h3 class="fs-30">We’re proud to partner with</h3>
    </div>
</div>
<div class="app-partner-items row">
        @foreach($partners as $partner)
				 <div class="col-md-4 col-lg-2">
				  <div class="app-partner-item">
					
                    
                      @if($partner->logo && file_exists(public_path('uploads/partners/thumb/'.$partner->logo)))
                          @if($partner->url!="")        
                            <a href="{{$partner->url}}" target="_blank" >
                            <div class="img">
                             <img alt="{{$partner->title}}" title="{{$partner->title}}" src=" {{ asset('uploads/partners/'.$partner->logo) }}" style="height:45px;" />
                            </div>
                            </a>
                            @else
                            <div class="img">
                            <img alt="{{$partner->title}}" title="{{$partner->title}}" src=" {{ asset('uploads/partners/'.$partner->logo) }}" style="height:45px;" />
                            </div>
                            @endif
                        @else 
                                      
                            <img alt="{{$partner->title}}" title="{{$partner->title}}" src="{{ asset('images/gallery/thumbs/thumb/default.png') }}" style="height:45px;">
                        @endif
					       
				  </div>
				</div>
        @endforeach
</div> 
<div class="row">	
            <a class="m0-auto" href="{{ route('about.partners') }}">
              <button class="button secondary-btn mgh40">{{ trans('home.viewall_partners') }}</button>  
            </a>     
          </div>
<?php } ?>          