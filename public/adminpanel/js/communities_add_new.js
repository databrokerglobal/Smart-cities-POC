$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$( "#board_form" ).validate({
	    // define validation rules
	    rules: {
	       
	        communityName: {
	        	required: true
	        },
            meta_title : {
                required: true
            },
            meta_desc : {
                required: true
            },
            sort : {
                required: true,
                digits: true,
                maxlength : 3
            }
	    },
        messages: {
            sort : {
                maxlength: "Please enter not more than 3 characters.",
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
                        url: WEBSITE_URL+"/admin/communities/update", 
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
                                        window.location.href = WEBSITE_URL+"/admin/communities";
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

	$( "#add_new_data_to_community_form" ).validate({
	    // define validation rules
	    rules: {
	       
	        communityIdx: {
	        	required: true
	        },
            offerIdx : {
                required: true
            },
            order : {
                required: true,
                digits: true,
                maxlength : 3,
				min : 1
            }
	    },
        messages: {
            sort : {
                maxlength: "Please enter not more than 3 characters.",
            }
        },
		errorPlacement: function(error, element) {
            if (element.attr("name") == "offerIdx" ) {
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
			let formData = new FormData($('#add_new_data_to_community_form')[0]);
	    	$.ajax(
                    {
                        url: WEBSITE_URL+"/admin/community/data/new/update", 
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
                                        window.location.href = WEBSITE_URL+"/admin/community/data/new";
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

	$( "#add_discove_data_to_community_form" ).validate({
	    // define validation rules
	    rules: {
	       
	        communityIdx: {
	        	required: true
	        },
            offerIdx : {
                required: true
            },
			discription : {
                required: true
            },
            order : {
                required: true,
                digits: true,
                maxlength : 3,
				min : 1
            }
	    },
        messages: {
            sort : {
                maxlength: "Please enter not more than 3 characters.",
            }
        },
		errorPlacement: function(error, element) {
            if (element.attr("name") == "offerIdx" ) {
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
			let formData = new FormData($('#add_discove_data_to_community_form')[0]);
	    	$.ajax(
                    {
                        url: WEBSITE_URL+"/admin/community/data/discover/update", 
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
                                        window.location.href = WEBSITE_URL+"/admin/community/data/discover";
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
	
	/**
	 * Get community offers
	 */
	$('#communityIdx').change(function() {
        var community = $(this).val();
        var offerEl = $('#offerIdx');
        $.ajax({
            url: WEBSITE_URL+"/admin/community/offers/"+community, 
            type: "GET",
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data) {
                    var offers = '<option value="">Select</option>';
                    $.each(data, function(i, obj) {
                        offers += "<option value=" + obj.offerIdx + ">" + obj.offerTitle + "</option>";

                    });
                    offerEl.html(offers);
                }
            }
        });
    });
	 
});