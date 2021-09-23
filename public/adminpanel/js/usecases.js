var board_data_table;
var communityIdx= $("input[name='communityIdx']").val();
(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#board_table');

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
                    targets: 0,
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

                    // render: function(data, type, full, meta) {                    
                    
                    //   var publish_icon = `<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('`+data+`');" title="Click to Publish">
                    //   <i class="la la-thumbs-down"></i>
                    //   </a>`;
                    //   if(full[5] == "Published") {                        
                    //         publish_icon = `<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('`+data+`');" title="Click to Unpublish">
                    //         <i class="la la-thumbs-up"></i>
                    //         </a>`;
                    //   }
                    //   return publish_icon + `<a href="`+WEBSITE_URL+`/admin/usecases/edit/`+data+`" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                    //       <i class="la la-edit"></i>
                    //       </a>                          
                    //       <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('`+data+`');"><i class="la la-trash" title="Delete"></i>
                    //       </a>`;
                    // },
                },
            ],
        };

        board_data_table = table.DataTable(settings);
        var info = board_data_table.page.info();
          $('.dataTables_length').append('<span class="toal-records">'+
            'Total Records:  '+(info.recordsTotal)+'</span>'
        );
    }

    initTableWithDynamicRows();

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

function attach_record(record_idx) {
    attach_record_idx = record_idx;
    $("#upload_attach").click();
}

function publish_record(record_idx){
  $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: WEBSITE_URL+'/admin/usecases/publish',
    data: {articleIdx: record_idx},
    method: 'post',
    success: function(res){
      if(res=="success"){
        location.reload();
      }
    }
  });
}

function promote_record(record_idx,status){
  $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: WEBSITE_URL+'/admin/usecases/promote',
    data: {articleIdx: record_idx,status:status},
    method: 'post',
    success: function(res){
      if(res=="success"){
         location.reload();
      }
    }
  });
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
        url: WEBSITE_URL+'/admin/usecases/delete/'+record_idx,
        method: 'post',
        success: function(res){
          if(res=="success"){
            location.reload();
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
        url: WEBSITE_URL+"/admin/usecases/upload_attach/" + attach_record_idx,
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success:function(response) {
                if(response == "true")  {
                    transferComplete();
                } else {
                  window.alert("Oops! An error occurred, please try again later.");
                }
        }
   });
});
