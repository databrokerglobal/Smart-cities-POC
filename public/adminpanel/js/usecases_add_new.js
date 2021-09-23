$(function(){
	$('input[name="published"]').datepicker({format: "dd/mm/yyyy", autoclose: true});
	var communityIdx = $('#communityIdx_id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.validator.addMethod("validateTitle", function(value, element) {
        return this.optional(element) || /^[A-Za-z0-9\s]+$/.test(value);
    }, "Title must contain only letters or numbers.");

	$( "#board_form" ).validate({
	    // define validation rules
	    rules: {
	        categoryIdx: {
	            required: true,
	        },
            communityIdx : {
                required: true,
            },
	        articleTitle: {
	            required: true,
                validateTitle: true,
	        },
	        articleContent: {
	            required: true,
	            minlength: 20 
			},
			meta_title: {
				required: true,
			},
			meta_desc: {
				required: true,
			},
			published: {
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
            let redirectFrom= $('#redirectFrom').val();
            $.ajax(
                    {
                        url: WEBSITE_URL+"/admin/usecases/update", 
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (result) {   
                                    if(result == "success") {
                                        if(typeof redirectFrom != "undefined" && redirectFrom != ""){
                                            window.location.href = WEBSITE_URL+"/admin/home-top-use-cases";
                                        }else{
                                            window.location.href = WEBSITE_URL+"/admin/usecases/"+communityIdx;
                                        }
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

	var btnAttch = function (context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents:
            '<label class="custom-file-upload mb-0 lh-1"> <input type="file" class="input-file hidden" id="input-file" multiple/>' +
            '<i class="la la-paperclip"></i> </label>',
            container: false,
            tooltip: 'Attach file',
            click: function(){
                $('.summernote').summernote('editor.saveRange');
            }
         });
        return button.render();
    }

    var btnSlide = function (context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="material-icons fs-14">filter</i>',
            container: false,
            tooltip: 'Slide Embed',
            click: function(){
                $('.summernote').summernote('editor.saveRange');
                $("#custom-modal-slide").modal('show');
            }
         });
        return button.render();
    }

	

    var files;
    $("#input-file").change(function(e){
        var form_data = new FormData();

        // Read selected files
        var totalfiles = e.target.files.length;
        for (var index = 0; index < totalfiles; index++) {
            form_data.append("files[]", e.target.files[index]);
        }
        // AJAX request
        $.ajax({
            url: WEBSITE_URL+'/admin/usecases/summernote/upload_attach', 
            type: 'post',
            data: form_data,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.success){
                    var names = response.result;
                    var domain = window.location.protocol + window.location.host;
                    var node = document.createElement('span');
                    node.classList.add("attach-files");
                    node.innerHTML = "";
                    for(var i=0; i<names.length; i++)
                    {
                        node.innerHTML += "<a href='"+WEBSITE_URL+"/adminpanel/uploads/usecases/"+names[i]+"' target='_blank' download='"+names[i]+"'>"+
                                            "<i class='material-icons'>get_app</i>" + 
                                            "<span class='ml-10'>"+names[i]+"</span>"+
                                           "</a><br/>";
                    }
                    range = $(".summernote").summernote('restoreRange');
                    $('.summernote').summernote('editor.restoreRange');
                    $('.summernote').summernote('editor.focus');
                    $('.summernote').summernote('editor.insertNode', node);
                }
            }
        });
    });
    $(".note-slideshare-btn").click(function(){
        var embed_code = $('.note-embed-code').val();
        var node = document.createElement('span');
        node.classList.add("slideshare-embed-code");
        node.innerHTML = embed_code;
        $('.note-embed-code').val("");
        $("#custom-modal-slide").modal('hide');
        $('.summernote').summernote('editor.restoreRange');
        $('.summernote').summernote('editor.focus');
        $('.summernote').summernote('editor.insertNode', node);
    });

});