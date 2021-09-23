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
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">Themes</b></h3>                
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route('admin.settings.theming.add') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>Add Theme</span>
                                    </span>
                                </a>
                                &nbsp;&nbsp;
                                &nbsp;&nbsp;
                                <a href="{{ route('admin.settings.theming.reset') }}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-refresh"></i>
                                        <span>Reset to Default Theme</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class=" m-portlet__body table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="board_table">
                    <thead>
                        <tr>
                            <th style="width:4px;">#</th>
                            <th>Header</th>
                            <th>Footer</th>
                            <th>Primary Button</th>
                            <th>Secondary Button</th>
                            <th>Search Button</th>
                            <th>Text Size</th>
                            <th>Font Family</th>
                            <th style="width:160px;">Created Date</th>
                            <th style="width:160px;">Last Updated</th>
                            <th>Status</th>
                            <th style="width:120px;" class="action-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $index=>$partner)
                            <tr>
                                <td>{{$index+1}}</td>
                                
                                <td> 
                                    <div class="colortile" style="background:<?php echo $partner->header_color;  ?>">&nbsp;</div>
                                </td>
                                <td> 
                                    <div class="colortile" style="background:<?php echo $partner->footer_color;  ?>">&nbsp;</div>
                                </td>
                                <td> 
                                    <div class="colortile" style="background:<?php echo $partner->primary_button_color;  ?>">&nbsp;</div>
                                </td>
                                <td> 
                                    <div class="colortile" style="background:<?php echo $partner->secondary_button_color;  ?>">&nbsp;</div>
                                </td>
                                <td> 
                                    <div class="colortile" style="background:<?php echo $partner->search_button_color;  ?>">&nbsp;</div>
                                </td>
                                
                                <td> 
                                    {{$partner->body_text_size}} px
                                </td>
                                <td> 
                                    {{FONT_FAMILY[$partner->body_font_family]}}
                                </td>
                                
                                                             
                                <td><span class="dateSort">{{strtotime($partner->created_at) > 0 ?  $partner->created_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($partner->created_at) > 0 ?  $partner->created_at->format(DATE_FORMAT) : '-'}}</td>
                                <td><span class="dateSort">{{strtotime($partner->updated_at) > 0 ?  $partner->updated_at->format(SORTABLE_DATE_TIME) : '-'}}</span>{{strtotime($partner->updated_at) > 0 ?  $partner->updated_at->format(DATE_FORMAT) : '-'}}</td>
                                <td>
                                    
                                @if($partner->status == 1)
                                        <image width="25"  src="{{asset('images/applied_icon.png')}}" title="Applied" />
                                    @else
                                        <image width="25"  src="{{asset('images/not_applied_icon.png')}}" title="Not Applied" />

                                    @endif
                                </td>
                                <td>
                                  
                                    @if($partner->status == 0)

                                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill activeCl" onclick="publish_record('{{$partner->id}}');" title="Click to Apply">
                                        <i class="la la-tags"></i></a>
                                    @endif
                                  @if($partner->id != 1)
                                    <a href="{{route('admin.settings.theming.edit',$partner->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Update">
                                    <i class="la la-edit"></i>
                                    </a>
                                    <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="wantDelete('{{$partner->id}}');"><i class="la la-trash" title="Delete"></i>
                                    </a>
                                    @else
                                    <span>Default</span>
                                    <a href="{{route('admin.settings.theming.view',$partner->id)}}" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" ><i class="la la-eye" title="View Default Theme"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>       
    </div>
</div>

@endsection

@section('additional_javascript')
<script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/settings.js') }}"></script>            
@endsection

