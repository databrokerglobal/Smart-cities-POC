@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style type="text/css">
        #searched_keys tr:hover{cursor: pointer;}
        #searched_keys tr.shown{background-color: #f7f8fa;}
        #searched_keys .table-child{background-color: #f7f8fa;}
        #searched_keys .table-child td{padding: 10px 20px;}
        #searched_keys .table-child-title{position: absolute;left: 200px;}
        #searched_keys .hidden{display: none;}
    </style>
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto width-100">
                <h3 class="m-subheader__title m-subheader__title--separator"> Searched Keywords</h3>
                <!--div class="ggn-r"><a href="{{ route('admin.searchedkeys.export') }}" class="btn btn-primary text-right export_search_keywords">Export Keywords</a></div-->
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body exportable-list table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="searched_keys">
                    <thead>
                        <tr>                            
                            <th style="min-width:60px;">Searched Keyword</th>
                            
                            <th style="min-width:100px;">Searched By</th>
                            <th style="width:145px;">Searched On</th>                          
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($all_keys))
                  
                        @foreach($all_keys as $key)                                         
                            <tr>                                
                                <td class="details-control" align="left">{{$key->search_key}}</td>                                
                               
                                <td class="details-control">{{ $key->searched_by != null? $key->firstname.' '.$key->lastname : 'Unknown'}}</td>
                                <td class="details-control"><span class="dateSort">{{date(SORTABLE_DATE_TIME ,strtotime($key->created_at))}}</span><?=date(HOUR24_DATETIME ,strtotime($key->created_at)) ?></td>
                                
                            </tr>
                        @endforeach
                        @else 
                        <tr>                                
                                <td colspan="3" class="small alert alert-warning mb-0 text-center">No Record Found</td>                                
                               
                                
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('additional_javascript')
    <script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('adminpanel/js/dataTables.buttons.min.js') }}"></script>

    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
        var tableData   =   $('#searched_keys').DataTable({
			"dom": 'B<"clear">lfrtip',
			buttons: [{
                extend: 'excelHtml5',
                text: 'Export Keywords',
                defaultContent: '',
				className: 'btn-sm',
				title: "",
                filename : "{{APPLICATION_NAME.'_SearchedKeywords_'.str_Replace(' ','_',date(SIMPLE_DATE)).'_'.time()}}",
				download: 'open',
				orientation:'landscape',
				exportOptions: {
				    columns: ':visible',
                    format: {
                        body: function(data, column, row) {
                            if (row === 2){
                                return data.replace(/(<([^>]+)>)/ig,"").slice(14);
                            }
                            return data;
                        }
                    }
                }
            }],
            "order": [[ 2, "desc" ]],
            'columnDefs': [{
                   
             }]
          });
        });
    </script>          
@endsection

