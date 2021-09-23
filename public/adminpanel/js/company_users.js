var board_data_table;
var companyIdx = $('#companyIdx').val();

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#board_table');

        var settings = {
            responsive: true,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
                            <a href="/admin/users/edit/`+data+`" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                            <i class="la la-edit"></i>
                            </a>
                            <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('`+data+`');"><i class="la la-trash" title="Delete"></i>
                            </a>`;
                    },
                },
            ],
        };

        board_data_table = table.DataTable(settings);
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

function wantDelete(record_idx){
  swal({
    title: "Are you sure?",
    text: "You will not be able to recover this!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it",
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
        url: '/admin/users/delete/'+record_idx,
        method: 'post',
        success: function(res){
          if(res=="success"){
            window.location.href="/admin/company_users/"+companyIdx;
          }
        }
      });
    }else 
      swal("Cancelled", "Action has cancelled", "error");
  });
}

transferComplete = function(e) {
    window.location.reload(true);
}