var admin_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#admin_purchase_list');

        var settings = {

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },
            order: [[1, 'asc']],
            columnDefs: [
                { minWidth: 300, targets: 0 },
                {
                  targets: 0,
                  orderable: true
                },
                {
                  targets: 1,
                  orderable: true
                },
                {
                  orderable: true,targets:[2,6]
                },
                {
                    targets: -1,
                    title: 'Valid Till',
                    orderable: true,
                 
                },
            ],
        };

        admin_table = table.DataTable(settings);
        var info = admin_table.page.info();
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


function publish_record(record_idx){
  $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: WEBSITE_URL+'/admin/users/publish',
    data: {userIdx: record_idx},
    method: 'post',
    success: function(res){
      if(res=="success"){
        window.location.href= WEBSITE_URL+"/admin/users";
      }
    }
  });
}

function wantDelete(record_idx){
  swal({
    title: "Are you sure?",
    text: "This action cannot be undone.",
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
        url: WEBSITE_URL+'/admin/users/delete/'+record_idx,
        method: 'get',
        success: function(res){
          if(res=="success"){
            window.location.href= WEBSITE_URL+"/admin/users";
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