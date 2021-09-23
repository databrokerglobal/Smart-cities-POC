$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$( "#board_form" ).validate({
	    // define validation rules
	    rules: {
	        featured_data_title: {
	            required: true,
	        },
	        featured_data_content: {
	            required: true,
	            minlength: 20 
			},
            providerIdx: {
                required: true,
            },
            read_more_url: {
                required: true,
            }
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
            let formData = new FormData($('#board_form')[0]);
	    	$.ajax(
                    {
                        url: WEBSITE_URL+"/admin/home_featured_data/update", 
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (result) 
                                {   
                                    if(result == "success")
                                    {
                                        window.location.href = WEBSITE_URL+"/admin/home_featured_data";
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
       
	
    
}); 