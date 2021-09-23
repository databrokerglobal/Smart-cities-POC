@extends('layouts.admin')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
@endsection

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto width-100">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Discover Communities Data</b></h3>
                <div class="ggn-r">
                    <a href="{{ route('admin.community.data.discover.add') }}" class="btn btn-primary text-right">Add New Data To Discover Community</a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">                
                <div class="table-responsive">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table">
                        <thead>
                            <tr>
                                <th style="width:10px;">#</th>
                                <th>Image</th>
                                <th>Community</th>
                                <th>Offer</th>
                                <th>Order</th>
                                <th style="width:145px;">Created Date</th>
                                <th style="width:145px;">Last Updated</th>
                                <th style="width:150px;" class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($communitiesData as $index=>$communityData)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                    @if(!empty($communityData->image) &&  file_exists(public_path("uploads/communities/discover/thumb/".$communityData->image))) 
                                        {{ asset("uploads/communities/discover/thumb/".$communityData->image) }}
                                    @else 
                                        {{ asset("uploads/default.png") }}
                                    @endif
                                    </td>
                                    <td>{{ $communityData->community->communityName }}</td>
                                    <td>{{ $communityData->offer->offerTitle }}</td>
                                    <td>{{ $communityData->order }}</td>                         
                                    <td><span class="dateSort">{{strtotime($communityData->created_at) > 0 ?  $communityData->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($communityData->created_at) > 0 ?  $communityData->created_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td><span class="dateSort">{{strtotime($communityData->updated_at) > 0 ?  $communityData->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($communityData->updated_at) > 0 ?  $communityData->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                    @if(count($communityData->offer->region) > 0)
                                        <?php $offer_region = ''; ?>
                                        @foreach($communityData->offer->region as $key=>$regionVal)
                                            
                                            <?php 
                                            $offer_region = $offer_region . str_replace(' ', '-', strtolower($regionVal->regionName));
                                            if($key+1 < count($communityData->offer->region)) $offer_region = $offer_region . "-";
                                            ?>
                                        @endforeach
                                    @endif
                                    <td>
                                    <a target="_blank" href="{{ route('admin_data_details',[str_replace(' ', '', strtolower($communityData->offer->provider->companyName)),str_replace(' ', '-', strtolower($communityData->offer->offerTitle)).'-'.$offer_region]) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View offer details">
                                        <i class="la la-eye"></i>
                                        </a>
                                        <a href="{{route('admin.community.data.discover.edit', $communityData->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                        <i class="la la-edit"></i>
                                        </a>
                                        <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$communityData->id}}');"><i class="la la-trash" title="Delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>       
    </div>
</div>

@endsection

@section('additional_javascript')
<script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/discover-community-data.js') }}"></script>
@endsection

