var board_data_table;
//var hidden_communityIdx = $('#hidden_communityIdx').val();

(function($) {	
	
    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#admin_users');

        var settings = {
			"dom": 'B<"clear">lfrtip',
			buttons: [{
                extend: 'excelHtml5',
                text: 'Export Offers',
                defaultContent: '',
                title: "",
                filename : $('#export-file-name').val(),
                download: 'open',
                orientation:'landscape',
                autoFilter: true,
				className: 'btn-sm',
                customize: function ( xlsx ) {
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];
                  $('row:first c', sheet).attr( 's', '42' ); 
                },
                exportOptions: {
                  columns: [0,1,2,3,4,5,6,7,8],
                            format: {
                                body: function(data, column, row) {
                                    if (row === 6 || row === 7){
                                        return data.replace(/(<([^>]+)>)/ig,"").slice(14);
                                    }
                                    return data;
                                }
                            }
                        }
            }],

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            order: [
                [ 7, "desc" ]
            ],

            columnDefs: [
                {
                  targets: [8],
                  orderable: false,
                  "visible": false
                },
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                },
            ],
        };

        board_data_table = table.DataTable(settings);
		$('#communityDropdown').on('change', function () {
            board_data_table.columns(2).search( this.value ).draw();
        } );
        $('#providerDropdown').on('change', function () {
            board_data_table.columns(3).search( this.value ).draw();
        } );
        var info = board_data_table.page.info();
        $('.dataTables_length').append('<span class="toal-records">'+
          'Total Records:  '+(info.recordsTotal)+'</span>'
      );
    }

    initTableWithDynamicRows();
	
	$( "#filter_div").insertAfter( "#admin_users_filter" );

})(window.jQuery);

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

var attach_record_idx;

function publish_record(record_idx){
  $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: WEBSITE_URL+'/admin/offers/publish',
    data: {offerIdx: record_idx},
    method: 'post',
    success: function(res){
      if(res=="success"){
        window.location.href= WEBSITE_URL+"/admin/offers";
      }
    }
  });
}

function attach_record(record_idx) {
    attach_record_idx = record_idx;
    $("#upload_attach").click();
}

function wantDelete(record_idx){
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
        url: WEBSITE_URL+'/admin/offers/delete/'+record_idx,
        /* url: '/admin/offers/delete/'+record_idx, */
        method: 'post',
        success: function(res){
          if(res=="success"){
            window.location.reload();
            //window.location.href= WEBSITE_URL+"/admin/offers";
          }
        }
      });
    }else 
      swal("Cancelled", "Action has been cancelled", "error");
  });
}

transferComplete = function(e) {
    window.location.reload(true);
}

$("#upload_attach").change(function(event){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    var file = event.target.files[0];       
    var data = new FormData();
    data.append("uploadedFile", file);

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: WEBSITE_URL+"/admin/media/upload_attach/" + attach_record_idx,
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success:function(response) {
                if(response == "true")
                {
                    transferComplete();
                }
                else
                {
                  window.alert("Oops! An error occurred, please try again later.");
                }
        }
   });
});

function promote_to_new_in_community(offerIdx, communityIdx){
	$.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
	  var data = new FormData();
	  data.append("offerIdx", offerIdx);
	  data.append("communityIdx", communityIdx);
	  data.append("order", 1);
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: WEBSITE_URL+"/admin/community/data/new/update",
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success:function(response) {
                if(response == "success")
                {
                    transferComplete();
                }
                else
                {
                  window.alert("Oops! An error occurred, please try again later.");
                }
        }
   });
}

function remove_from_new_in_community(Idx){
	$.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
       
    var data = new FormData();
    data.append("id", Idx);

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: WEBSITE_URL+"/admin/community/data/new/delete/" + Idx,
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success:function(response) {
                if(response == "true")
                {
                    transferComplete();
                }
                else
                {
                  window.alert("Oops! An error occurred, please try again later.");
                }
        }
   });
}
