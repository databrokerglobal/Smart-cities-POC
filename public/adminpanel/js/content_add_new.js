var storiestable;
var teamtable;
(function($) {
	var initStoriesTableWithDynamicRows = function() {
        var table = $('#stories_table');

        var settings = {
			lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            order: [
                [ 3, "desc" ]
            ],

            columnDefs: [
              
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                   
                },
            ],
        };

		
		storiestable = table.DataTable(settings);
        var info = storiestable.page.info();
          $('#stories_table_wrapper .dataTables_length').append('<span class="toal-records">'+
            'Total Records:  '+(info.recordsTotal)+'</span>'
        );
		
	}

	var initTeamsTableWithDynamicRows = function() {
        var table = $('#team_table');

        var settings = {
			lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            order: [
                [ 4, "desc" ]
            ],

            columnDefs: [
				{
                    targets: 1,
                    orderable: false,
                    render: function(data, type, full, meta) {
                      var randN = Math.floor(Math.random() * 999); 
					  	return '<img src="'+data+'?randN='+randN+'" style="height: 40px;">';
                    },
                },
              
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                   
                },
            ],
        };

		teamtable = table.DataTable(settings);
        var info = teamtable.page.info();
          $('#team_table_wrapper .dataTables_length').append('<span class="toal-records">'+
            'Total Records:  '+(info.recordsTotal)+'</span>'
        );
		
	}
	
	
  if($('#stories_table').length > 0){

	  initStoriesTableWithDynamicRows();
	  initTeamsTableWithDynamicRows();
  }

})(window.jQuery);


function wantDelete(type,record_idx){
	swal({
	  title: "Are you sure?",
	  text: "This action can not be undone.",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: "Yes, Delete it",
	  cancelButtonText: "No",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm) {
	  if (isConfirm) {
		$.ajax({
		  headers: {
		  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  },
		  url: WEBSITE_URL+'/admin/content/delete/'+type+'/'+record_idx,
		  method: 'post',
		  success: function(res){
			if(res=="success"){
			  //window.location.href= WEBSITE_URL+"/admin/offers";
			  location.reload();
			}
		  }
		});
	  }else 
		swal("Cancelled", "Action has been cancelled", "error");
	});
  }

  function publish_record(type,record_idx){
	$.ajax({
	  headers: {
	  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  },
	  url: WEBSITE_URL+'/admin/content/publish',
	  data: {record_idx: record_idx,type:type},
	  method: 'post',
	  success: function(res){
		if(res=="success"){
		  location.reload();
		}
	  }
	});
  }

  
$(function(){
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
	        communityIdx: {
	        	required: true
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
                        url: WEBSITE_URL+"/admin/content/update", 
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
                                       location.reload();
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
	$( "#stories_form" ).validate({
	    // define validation rules
	    rules: {
	        title: {
	        	required: true,
	        },
	        year: {
	        	required: true
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
			let formData = new FormData($('#stories_form')[0]);
			
			$.ajax(
                    {
                        url: WEBSITE_URL+"/admin/stories/store", 
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
						data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (result) 
                                {   
                                	
                                    if(result.status == "success")
                                    {
                                       window.location.href = WEBSITE_URL+'/admin/content/'+result.content_id
                                    }else{
										$(':input[type="submit"]').prop('disabled', false);
                                    	window.alert(result.message);
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
	$( "#team_form" ).validate({
	    // define validation rules
	    rules: {
	        name: {
	        	required: true,
	        },
	        position: {
	        	required: true
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
			let formData = new FormData($('#team_form')[0]);
			
			$.ajax(
                    {
                        url: WEBSITE_URL+"/admin/teams/store", 
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
						data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (result) 
                                {   
                                	
                                    if(result.status == "success")
                                    {
                                       window.location.href = WEBSITE_URL+'/admin/content/'+result.content_id
                                    }else{
										$(':input[type="submit"]').prop('disabled', false);
                                    	window.alert(result.message);
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