$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$( "#board_form" ).validate({
	    // define validation rules
	    rules: {
	        subcontent: {
	        	required: true,
	        },
	        content: {
	        	required: true
	        }
	    },
		errorPlacement: function(error, element) {
            if (element.attr("name") == "subcontent" ) {
                $(".subcontent-error").html(error);
			} else if (element.attr("name") == "content" ) {
				$(".content-error").html(error);
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
			var mode = $('#mode').val();
			$.ajax(
                    {
                        url: WEBSITE_URL+"/admin/media/update", 
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
						data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (result) 
                                {   
                                	console.log(result);
                                    if(result == "success")
                                    {
                                        window.location.href = WEBSITE_URL+"/admin/media_library/"+mode;
                                    }else{
										$(':input[type="submit"]').prop('disabled', false);
                                    	window.alert(result);
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