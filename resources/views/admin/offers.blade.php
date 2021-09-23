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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Offers</b></h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head full_height">
                <div class="m-ty-caption">
                    <div class="m-v-tools">
                        <div class="m box-style row">
                        
                            <div class="m-portlet__nav-item col-sm-4 col-md-4">
                                <div class="tile1 card-dasboard">
                                    <div class="card-body">
                                            <div class="card-count d-inline float-left">{{$comunityCount}}
                                            <span>Communities</span>
                                            </div>
                                        
                                            <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__nav-item  col-sm-4 col-md-4">
                                <div class="tile1 card-dasboard">
                                    <div class="card-body">
                                            <div class="card-count d-inline float-left">{{$providerCount}}
                                            <span>Providers</span>
                                            </div>
                                        
                                            <div class="clearfix"></div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="m-portlet__nav-item  col-sm-4 col-md-4">
                            
                            <div class="tile1 card-dasboard">
                                    <div class="card-body">
                                            <div class="card-count d-inline float-left">{{$regionCount}}
                                            <span>Regions</span>
                                            </div>
                                        
                                            <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body exportable-list">
            <input type="hidden" value="{{APPLICATION_NAME.'_Offers_'.str_Replace(' ','_',date(SIMPLE_DATE)).'_'.time()}}" id="export-file-name"> 
                <div class="table-responsive">
                    <div id="filter_div" class="row">
                        <div class="col-sm-12 col-md-1"></div>
                        <div class="col-sm-12 col-md-5">
                            <select id="communityDropdown" class="form-control form-control-sm">
                                <option value="">-- Community --</option>
                                @foreach ($community as $key => $value)
                                    <option value="{{ $value->communityName }}">{{ $value->communityName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <select id="providerDropdown" class="form-control form-control-sm">
                                <option value="">-- Provider --</option>
                                @foreach ($provider as $key => $value)
                                    <option value="{{ $value->companyName }}">{{ $value->companyName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-1"></div>
                    </div>
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="admin_users">
                        <thead>
                            <tr>
                                <th style="width:5px;">ID</th>                           
                                <th>Title</th>
                                <th>Community</th>
                                <th>Provider</th>
                                <th style="width:120px;">Region</th>
                                <th>Themes</th>
                                <th style="width:140px;">Created Date</th>
                                <th style="width:140px;">Last Updated</th>
                                <th style="width:140px;">Status</th>
                                <th style="width:145px;" class="action-col offer-action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($images as $index=>$image)
                        
                                <?php
                                $offer_region = ""; ?>
                                <tr>
                                    <td class="details-control">{{$image->offerIdx}}</td>
                                    
                                    <td class="details-control">{{isset($image->offerTitle) ? $image->offerTitle : ""}}</td>
                                    <td class="details-control">{{isset($image->community->communityName) ? $image->community->communityName : ""}}</td>
                                    <td class="details-control">{{isset($image->provider->companyName) ? $image->provider->companyName : ""}}</td>
                                
                                    <td class="details-control"> 
                                    @if(count($image->region) > 0)
                                        <?php $regionName = []; ?>
                                        @foreach($image->region as $key=>$regionVal)
                                            
                                            <?php 
                                            $offer_region = $offer_region . str_replace(' ', '-', strtolower($regionVal->regionName));
                                            if($key+1 < count($image->region)) $offer_region = $offer_region . "-";
                                            $regionName[] = $regionVal->regionName ?>
                                        @endforeach
                                        {{implode(',',$regionName)}}
                                    @else
                                    -
                                    @endif
                                    
                                    </td>
                                    <td class="details-control">
                                    @if(count($image->theme) > 0)
                                        <?php $themes = []; ?>
                                        @foreach($image->theme as $theme)
                                            <?php $themes[] = $theme->themeName ?>
                                        @endforeach
                                        {{implode(',',$themes)}}
                                    @else
                                    -
                                    @endif
                                    
                                    </td>
                                    
                                    <td class="details-control"><span class="dateSort">{{strtotime($image->created_at) > 0 ?  $image->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($image->created_at) > 0 ?  $image->created_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td class="details-control"><span class="dateSort">{{strtotime($image->updated_at) > 0 ?  $image->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($image->updated_at) > 0 ?  $image->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                    <td class="details-control">
                                        @if($image->status == 1) 
                                            Published
                                        @else
                                            Unpublished
                                        @endif
                                    </td>
                                    <td class="details-control text-nowrap">
                                    @if($image->newInCommunity)
                                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="remove_from_new_in_community('{{$image->newInCommunity->id}}');" title="Click to remove from new into the community">
                                        <i class="la la-tags"></i>
                                    </a>                                    
                                    @else
                                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="promote_to_new_in_community('{{$image->offerIdx}}','{{$image->communityIdx}}')"  title="Click to add as new into the community">
                                        <i class="la la-tags"></i>
                                    </a>
                                    @endif
                                        @if($image->status == 1) 
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$image->offerIdx}}');" title="Click to Unpublish">
                                        <i class="la la-thumbs-up"></i></a>
                                        @else
                                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill inactiveCl" onclick="publish_record('{{$image->offerIdx}}');" title="Click to Publish">
                                            <i class="la la-thumbs-down"></i></a>
                                        @endif

                                        <a target="_blank" href="{{ route('admin_data_details',[str_replace(' ', '', strtolower($image->provider->companyName)),str_replace(' ', '-', strtolower($image->offerTitle)).'-'.$offer_region]) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                        <i class="la la-eye"></i>
                                        </a>
                                        <a href="offers/edit/{{$image->offerIdx}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                        <i class="la la-edit"></i>
                                        </a>
                                        <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$image->offerIdx}}');"><i class="la la-trash" title="Delete"></i>
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
    <script src="{{ asset('adminpanel/js/offers.js') }}"></script>            
@endsection

