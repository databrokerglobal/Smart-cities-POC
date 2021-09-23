@extends('layouts.app')

@section('title', 'Account and profile info | Databroker')
@section('description', '')

@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="container-fluid app-wapper profile">
    <div class="bg-pattern1-left"></div>
	<div class="app-section app-reveal-section align-items-center">	    
		<div class="container">
            
  <p>
    Click on below button to download different type of files.
  </p>
            <div class="app-section profileinfo">
               <button onclick="openModel(this)"  class="btn btn-primary"  data-name="demo.csv">Csv</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.pdf">pdf</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.txt">txt</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.xls">xls</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.xlsx">xlsx</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.doc">doc</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.sql">sql</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.exe">exe</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.rar">rar</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.zip">zip</button>
               <button onclick="openModel(this)" class="btn btn-primary"  data-name="demo.pptx">pptx</button>

			</div><!--app-section profileinfo-->

			<div class="divider-green mgt30"></div>

		
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
        window.location.href = '{{url("/")}}/uploads/sample_download/'+name;
    }else{

        if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = '{{url("/")}}/uploads/sample_download/'+name;
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