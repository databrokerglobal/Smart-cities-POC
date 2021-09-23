@php
    $allActiveCommunities = App\Models\Community::where('status', 1)->get();
@endphp

@extends('layouts.admin')

@section('additional_css')
    
@endsection

@section('content')

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
   
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #9102f7;">How to use</b></h3>                
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
                             <h3><span>Quick Access</span>  </h3>                                 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
<div class="form-group m-form__group row">
    <div class="col-md-6 m-form__group-sub">
            <span class="m-menu__link menu-home"><i class="fa fa-home" aria-hidden="true"></i><span> Home</span>
            <ul>
            <li class="list-style"><a href="{{ route('admin.home_featured_data') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Featured Data</a>- <small class="label_help_text">Manage home's page featured data content</small> </li>
            <li class="list-style"><a href="{{ route('admin.home_trending') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Trending</a>- <small class="label_help_text">Manage home's page trending content</small> </li>
            <li class="list-style"><a href="{{ route('admin.home_marketplace') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;New on the Marketplace</a>- <small class="label_help_text">Manage home's page New on the Marketplace</small> </li>
            <li class="list-style"><a href="{{ route('admin.home_teampicks') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;<?php echo APPLICATION_NAME; ?> Team Picks</a>- <small class="label_help_text">Manage team picks</small> </li>
            <li class="list-style"><a href="{{ route('admin.home_featured_provider') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Featured Data Providers</a>- <small class="label_help_text">Manage home's page featured data providers</small> </li>
            <li class="list-style"><a href="{{ route('admin.top_use_cases') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Top Use Cases</a>- <small class="label_help_text">Manage home's page top use cases</small> </li>   
            </ul>
    </div>

    <div class="col-md-6 m-form__group-sub">
            <span class="m-menu__link menu-home"><i class="fa fa-briefcase" aria-hidden="true"></i><span > Use Cases</span>
            <ul>
            @foreach ($allActiveCommunities as $key=>$comm) 
            @php
                $comm_slug = $comm->slug;
                $communityIdx = $comm->communityIdx;
                $croute =  route("admin.usecases", [ 'id' => $communityIdx ]);
            @endphp
            <li class="list-style"><a href="{{ $croute}}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;{{$comm->communityName}}</a>- <small class="label_help_text">Add or Update use cases of {{$comm->communityName}} data</small> </li>
            @endforeach 
            </ul>
    </div>
    </div>
    <hr/>
    <div class="form-group m-form__group row">
        <div class="col-md-6 m-form__group-sub">
        <span class="m-menu__link menu-help"> <i class="fa fa-deaf" aria-hidden="true"></i><span > Help</span>  


        <ul >
                                    <li class="list-style">
                                        <span class="m-menu__link menu-sub-buying menu-buying" >
                                            <i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Buying Data
                                        </span>
                                        <ul>
                                            <li class="list-style"><a href="{{ route('admin.help.buying_data') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Title and Intro</a>- <small class="label_help_text">Manage Title and Intro of buying data</small> </li>
                                            <li class="list-style"><a href="{{ route('admin.help.buying_data_topics') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Content</a>- <small class="label_help_text">Manage buying data content</small> </li>
                                            <li class="list-style"><a href="{{ route('admin.help.buying_data_faqs') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;FAQs</a>- <small class="label_help_text">Manage FAQs content of buying data</small> </li>
                                        </ul>
                                    </li>
                                    <li class="list-style">
                                        <span class="m-menu__link menu-sub-selling menu-selling" >
                                            <i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Selling Data
                                        </span>
                                        <ul >
                                            <li class="list-style"><a href="{{ route('admin.help.selling_data') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Title and Intro</a>- <small class="label_help_text">Manage Title and Intro of selling data</small> </li>
                                            <li class="list-style"><a href="{{ route('admin.help.selling_data_topics') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Content</a>- <small class="label_help_text">Manage selling data content</small> </li>
                                            <li class="list-style"><a href="{{ route('admin.help.selling_data_faqs') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;FAQs</a>- <small class="label_help_text">Manage FAQs content of selling data</small> </li>
                                        </ul>
                                    </li>
                                    <li class="list-style"><a href="{{ route('admin.help.guarantee') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Guarantee</a>- <small class="label_help_text">Manage guarantee content</small> </li>                                    
                                    <li class="list-style"><a href="{{ route('admin.help.complaint') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Complaints</a>- <small class="label_help_text">Manage complaints content</small> </li>
                                    <li class="list-style" ><a href="{{ route('admin.help.feedback') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Feedbacks</a>- <small class="label_help_text">Manage feedbacks content</small> </li>
                                </ul>
            
 
        </div>

        <div class="col-md-6 m-form__group-sub">
        <span class="m-menu__link menu-home"><i class="fa fa-newspaper-o" aria-hidden="true"></i><span > Updates</span>
            <ul>
            <li class="list-style"><a href="{{ route('admin.updates') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Updates</a>- <small class="label_help_text">Add or Update Article data</small> </li>           
            </ul>

        <span class="m-menu__link menu-home"><i class="fa fa-picture-o" aria-hidden="true"></i><span > Media</span>
            <ul>
            <li class="list-style"><a href="{{ route('admin.media_library',['community-covers']) }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Community Cover Images</a>- <small class="label_help_text">Manage Community cover images</small> </li>           
            <li class="list-style"><a href="{{ route('admin.media_library',['offer-covers']) }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Data Offer Images</a>- <small class="label_help_text">Manage data offer images</small> </li>           
            </ul>

        <span class="m-menu__link menu-home"><i class="fa fa-group" aria-hidden="true"></i><span > Partners</span>
            <ul>
            <li class="list-style"><a href="{{ route('admin.partners') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Partners</a>- <small class="label_help_text">Manage partners and promote as a Proud partner</small> </li>           
            </ul>

        <span class="m-menu__link menu-home"> <i class="fa fa-gear" aria-hidden="true"></i><span > Settings</span>
            <ul>
            <li class="list-style"><a href="{{ route('admin.settings.configuration_list') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Site Configurations</a>- <small class="label_help_text">Configure Site Title/Favicon/Header & Footer logo</small> </li>           
            <li class="list-style"><a href="{{ route('admin.settings.theming') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Themes</a>- <small class="label_help_text">Manage Site Header/Footer/Button color and Font</small> </li>           
            </ul>
        </div>
    </div>
    <hr/>
    <div class="form-group m-form__group row">
        <div class="col-md-6 m-form__group-sub">

        <span class="m-menu__link menu-home"><i class="fa fa-list" aria-hidden="true"></i><span>  Manage Contents</span>
            <ul>
            <li class="list-style"><a href="{{ route('admin.communities') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Communities</a>- <small class="label_help_text">Manage communities</small> </li>
            <li class="list-style"><a href="{{ route('admin.providers') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Providers</a>- <small class="label_help_text">Manage providers</small> </li>
            <li class="list-style"><a href="{{ route('admin.themes') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Themes</a>- <small class="label_help_text">Manage themes against the community</small> </li>
            <li class="list-style"><a href="{{ route('admin.offers') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Offers</a>- <small class="label_help_text">View/Edit/Export offers data</small> </li>
            <li class="list-style"><a href="{{ route('admin.purchases') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Purchases</a>- <small class="label_help_text">View/Export  of purchased product</small> </li>
            <li class="list-style"><a href="{{ route('admin.user_activity') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;User Activity Log</a>- <small class="label_help_text">View user activity log against different actions</small> </li>   
            </ul>
        </div>

        <div class="col-md-6 m-form__group-sub">
        <span class="m-menu__link menu-home"><i class="fa fa-user-o" aria-hidden="true"></i><span > Users</span>
            <ul>
            <li class="list-style"><a href="{{ route('admin.users') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Users</a>- <small class="label_help_text">Manage users and export the user data</small> </li>           
            </ul>

        <span class="m-menu__link menu-home"><i class="fa fa-picture-o" aria-hidden="true"></i><span > About {{APPLICATION_NAME}}</span>
            <ul>
            <li class="list-style"><a href="{{ route('admin.content.edit',1) }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;About {{APPLICATION_NAME}}</a>- <small class="label_help_text">Manage About page content data</small> </li>            
            </ul>
        </div>
    </div>





            </div>
        </div>
    </div>
</div>
@endsection