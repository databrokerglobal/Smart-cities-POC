var board_data_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#board_table');

        var settings = {
            searching: true,
            paging: true,

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
                    targets: 1,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var randN = Math.floor(Math.random() * 999); 
                        return '<img src="' + data + '?randN='+randN+'" style="height: 40px;width: 44px;">';
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
var attach_logo_idx;

function attach_record(record_idx) {
    attach_record_idx = record_idx;
    $("#upload_attach").click();
}

transferComplete = function(e) {
    window.location.reload(true);
}

function publish_record(record_idx){
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: WEBSITE_URL+'/admin/home_featured_data/publish',
      data: {id: record_idx},
      method: 'post',
      success: function(res){
       window.location.href= WEBSITE_URL+"/admin/home_featured_data";
      }
    });
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
        url: WEBSITE_URL+"/admin/home_featured_data/upload_attach/" + attach_record_idx,
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success:function(response) {
                if(response == "true") {
                    transferComplete();
                } else  {
                    window.alert("Oops! An error occurred, please try again later.");
                }
        }
   });
});

