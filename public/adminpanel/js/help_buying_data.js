$(function(){
	var faqIdx = $('#faqIdx').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$( "#board_form" ).validate({
	    // define validation rules
	    rules: {
	        title: {
	            required: true,
	        },
	        description: {
	            required: true,
	            minlength: 20 
			},
	    },
	    //display error alert on form submit  
	    invalidHandler: function(event, validator) {     
	        var alert = $('#m_form_1_msg');
	        alert.removeClass('m--hide').show();
	        mUtil.scrollTop();
	        setTimeout(function(){
	        	$('#m_form_1_msg').addClass('m--hide').hide();
	        }, 5000);
	    },
	    submitHandler: function (form) {
            $(':input[type="submit"]').prop('disabled', true);
	    	$.ajax(
                    {
                        url: WEBSITE_URL+"/admin/help/buying_data/update", 
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        data: $("#board_form").serialize(),
                        success: function (result) 
                                {   
                                    if(result == "success")
                                    {
                                        window.location.href = WEBSITE_URL+"/admin/help/buying_data";
                                    }
                                    
                                },
                        error: function (msg) 
                                {
                                    console.log('error', msg);
                                    $(':input[type="submit"]').prop('disabled', false);
									window.alert("Oops! An error occurred, please try again later.");
                                }
                    }
                );
	    }
	});  
	

	$(".summernote").summernote({
		height: 300,
        linkTargetBlank: true,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']],
          ['btnAttch', ['btnAttch']],
          ['btnSlide', ['btnSlide']]
        ],
        popover: {
            image: [
                ['custom', ['imageAttributes']],
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
        },
        lang: 'en-US', // Change to your chosen language
            imageAttributes:{
                icon:'<i class="note-icon-pencil"/>',
                removeEmpty:false, // true = remove attributes | false = leave empty if present
                disableUpload: true // true = don't display Upload Options | Display Upload Options
            }
	}); 
});