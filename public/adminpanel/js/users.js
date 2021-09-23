var admin_table;

(function($) {

    // Initialize datatable with ability to add rows dynamically
    var initTableWithDynamicRows = function() {
        var table = $('#admin_users');

        var settings = {
          "dom": 'B<"clear">lfrtip',
          buttons: [{
                extend: 'excelHtml5',
                text: 'Export Users',
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
                  columns: [2,3,4,5,6,7,8,9,10,11,12],
                            format: {
                                body: function(data, column, row) {
                                    if (row === 1){
                                      console.log(data);
                                        return data.replace(/(<([^>]+)>)/ig,"").slice(10);
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
            order: [[3, 'asc']],
            columnDefs: [
                { minWidth: 300, targets: 0 },
                {
                  targets: [0,1],
                  orderable: false
                },
                {
                  targets: [5,9,10],
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

        admin_table = table.DataTable(settings);
        var info = admin_table.page.info();
        $('.dataTables_length').append('<span class="toal-records">'+
          'Total Records:  '+(info.recordsTotal)+'</span>'
      );
    }

    initTableWithDynamicRows();

    $("#admin_users tbody").on("click", "td.details-control", function () {
        var tr = $(this).closest("tr");
        var row = admin_table.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass("shown");
            tr.find("td:eq(1)").html("<h4>+</h4>");
        } else {
          if(row.data()[0]!=0){
            row.child( getCompanyUsers(row.data()), 'table-child no-padding no-borders').show();
            tr.find("td:eq(1)").html("<h4>-</h4>");
            tr.addClass("shown");
          }
        }
    });
    function getCompanyUsers(adminInfo) {      
        var container = $('<div class="outlier-table-text-overlap"/>').addClass("loading").text("Loading...");
        var url = WEBSITE_URL+"/admin/company_users/" + adminInfo[2];
        $.ajax({
            url: url,
            dataType: "json",
            success: function (res) {
                var child_table = "";
                child_table = "<thead>" + 
                                "<tr>" +
                                  "<th style='min-width:50px;'>User ID</th>" +
                                  "<th style='min-width:75px;'>Registered On</th>" +                               
                                  "<th>Industry</th>" +
                                  "<th style='min-width:75px;'>Email</th>" +
                                  "<th style='min-width:75px;'>First Name</th>" +
                                  "<th style='min-width:75px;'>Last Name</th>" +  
                                  "<th style='min-width:52px;'>Job Title</th>" +
                                  "<th>Role</th>" +  
                                  "<th>Products</th>" +
                                  "<th style='min-width:40px;' class='action-col'>Actions</th>" +
                                "</tr>" + 
                              "</thead>";
                child_table += "<tbody>";
                for(var i=0; i<res.users.length; i++){
                  var user = res.users[i];
                  var tmp = "<tr>" + 
                                '<td class="text-nowrap">' + user.userIdx + "</td>" + 
                                '<td class="text-nowrap">' + moment(user.createdAt).format('DD/MM/YYYY') + "</td>" + 
                                '<td class="text-wrap">' + user.businessName + "</td>" + 
                                '<td class="text-wrap">' + user.email + "</td>" + 
                                '<td class="text-wrap">' + user.firstname + "</td>" + 
                                '<td class="text-wrap">' + user.lastname + "</td>" + 
                                '<td class="text-wrap">' + (user.jobTitle ? user.jobTitle : "N/A") + "</td>" + 
                                '<td class="text-wrap">' + user.role + "</td>" + 
                                '<td class="text-wrap">' + user.count_products + "</td>" + 
                                '<td class="text-wrap"><a href="'+WEBSITE_URL+'/admin/users/edit/'+user.userIdx+'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update"><i class="la la-edit"></i></a><a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete(\''+user.userIdx+'\');"><i class="la la-trash" title="Delete"></i></a></td>' + 
                              "</tr>";
                  child_table += tmp;
                }
                container.removeClass("loading");
                $('#admin_users .border-primary').removeClass('border-primary');
                container.html("<h4 class='table-child-title'>"+ adminInfo[4] +" invited users</h4><table class='dtRow datatable table table-bordered no-margins outlierSubTable'>" + child_table + "</table>").addClass('border-primary');
                try {
                    $(".dtRow").DataTable({
						destroy: true,
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
                            },
                        ],
                    });
                } catch (g) {
                    console.log(g);
                }
            },
            error: function(err) {
              if ( err.status === 403 ) {
                container.html('<div style="height: 50px; position: relative;"><h4 class="unauthorized" id="unauthorized" style="">You are unauthorized to view the Data Preview</h4></div>');
              }
            }
        });
        return container;
    }
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