var board_data_table;

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
              [ 0, "desc" ]
            ],

            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '<a href="'+ WEBSITE_URL+'/admin/help/buying_data/topic/edit/' + data + '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">'
                                      +'<i class="la la-edit"></i></a>'
                                      +'<a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete(&quote;'+data+'&quot;);"><i class="la la-trash" title="Delete"></i>'
                                      +'</a>';                        
                    },
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

function wantDelete(record_idx){
  swal({
    title: "Are you sure?",
    text: "This action can not be undone",
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
        url: WEBSITE_URL+'/admin/help/buying_data/topic/delete/'+record_idx,
        method: 'get',
        success: function(res){
          if(res=="success"){
            window.location.href= WEBSITE_URL+"/admin/help/buying_data/topics";
          }
        }
      });
    }else 
      swal("Cancelled", "Action has been cancelled", "error");
  });
}