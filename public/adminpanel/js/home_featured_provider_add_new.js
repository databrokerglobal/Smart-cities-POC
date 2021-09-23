$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$( "#board_form" ).validate({
	    // define validation rules
	    rules: {
			order: {
				required: true,
                digits: true,
                maxlength : 3,
				min: 1
            },
            providerIdx: {
                required: true,
            },
            active: {
                required: true,
            }
	    },
        messages: {
            order : {
                maxlength: "Please enter not more than 3 characters.",
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "providerIdx" ) {
                $(".error").html(error);
            } else {
                error.insertAfter(element);
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
                        url:  WEBSITE_URL+"/admin/home_featured_provider/update", 
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (result) {   
                                    if(result == "success") {
                                        window.location.href =  WEBSITE_URL+"/admin/home_featured_provider";
                                    }
                                    
                                },
                        error: function (msg) {
                                    console.log('error', msg);
                                    $(':input[type="submit"]').prop('disabled', false);
                                    window.alert("Oops! An error occurred, please try again later.");
                                }
                    }
                );
	    }
	});  
});