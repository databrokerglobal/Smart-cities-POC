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
                {
                    targets: -1,
                    title: 'Action',
                    orderable: false,
                    // render: function(data, type, full, meta) {
                    //     return `
                    //         <a href="`+ WEBSITE_URL+`/admin/home_marketplace/edit/`+data+`" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                    //         <i class="la la-edit"></i>
                    //         </a>
                    //        `;
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
var attach_logo_idx;

function attach_record(record_idx) {
    attach_record_idx = record_idx;
    $("#upload_attach").click();
}

function publish_record(record_idx){
    $.ajax({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: WEBSITE_URL+'/admin/home_marketplace/publish',
      data: {id: record_idx},
      method: 'post',
      success: function(res){
       window.location.href= WEBSITE_URL+"/admin/home_marketplace";
      }
    });
  }

function attach_logo(record_idx) {
    attach_logo_idx = record_idx;
    $("#upload_logo").click();
}

transferComplete = function(e) {
    window.location.reload(true);
}

$("#upload_logo").change(function(event){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    var file = event.target.files[0];       
    var data = new FormData();
    data.append("uploadedFileLogo", file);

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: WEBSITE_URL+"/admin/home_marketplace/upload_logo/" + attach_logo_idx,
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

$("#upload_attach").change(function(event){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    var file = event.target.files[0];       
    var data = new FormData();
    data.append("uploadedFileImage", file);

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: WEBSITE_URL+"/admin/home_marketplace/upload_attach/" + attach_record_idx,
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
