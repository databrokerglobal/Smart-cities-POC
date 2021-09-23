var board_data_table;
var hidden_id = $('#hidden_id').val();

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#board_table');

        var settings = {
            info : true,
            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            order: [
                [ 0, "asc" ]
            ],

            columnDefs: [
              {
                targets: [1, 2, 3, 4, 5, 10],
                orderable: false,
               
            },
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    
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

function publish_record(record_idx){
  $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: WEBSITE_URL+'/admin/settings/theming/publish',
    data: {id: record_idx},
    method: 'post',
    success: function(res){
     window.location.href= WEBSITE_URL+"/admin/settings/themes";
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
        url: WEBSITE_URL+'/admin/settings/theming/delete/'+record_idx,
        method: 'post',
        success: function(res){
            window.location.href= WEBSITE_URL+"/admin/settings/themes";
        
        }
      });
    }else 
      swal("Cancelled", "Action has been cancelled", "error");
  });
}


