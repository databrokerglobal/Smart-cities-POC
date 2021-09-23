@php
    $menu_item_parent = request()->session()->get('menu_item_parent');
    $menu_item_child = request()->session()->get('menu_item_child');
    $menu_item_child_child = request()->session()->get('menu_item_child_child');
    $allActiveCommunities = App\Models\Community::where('status', 1)->get();
@endphp
<!DOCTYPE html>
<html>
    <head>
    <?php $site_configurations = \DB::table('site_configurations')->where('status',1)->first();?>
        <title>
        @if($site_configurations && $site_configurations->site_title != "")
          {{$site_configurations->site_title}} | @yield('title')
        @else
          @yield('title')
        @endif
        </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="@yield('title')">
        <meta name="description" content="@yield('description')">

        <meta property="og:title" content="@yield('title')">
        <meta property="og:site_name" content="{{ config('app.name') }} ">
        <meta property="og:url" content="{{ config('app.url') }} ">
        <meta property="og:description" content="@yield('description')">
        <meta property="og:type" content="website">
        <meta property="og:image" content="{{ config('app.url') }}/images/Databroker_social-share.jpg">

        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        @if(isset($site_configurations) && $site_configurations->favi_icon != "" && file_exists(public_path("uploads/logo/".$site_configurations->favi_icon)))
        <link rel="icon" type="image/png" href="{{ asset('uploads/logo/'.$site_configurations->favi_icon) }}" />
        <link rel="shortcut icon" href="{{ asset('uploads/logo/'.$site_configurations->favi_icon) }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('uploads/logo/'.$site_configurations->favi_icon) }}">
        @else
        <link rel="icon" type="image/png" href="{{ asset('images/logos/logo.png') }}" />
        <link rel="shortcut icon" href="{{ asset('images/logos/logo.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/logos/favicon.ico') }}">
        <link rel="shortcut icon" href="{{ asset('images/logos/favicon.ico') }}" type="image/x-icon">
        @endif

         <!--begin::Web font -->            
            <script src="{{ asset('adminpanel/js/webfont.js') }}" type="text/javascript"></script>
            <script>
            // set website url for ajax call
            var WEBSITE_URL = "{{ config('app.url') }}";
            WebFont.load({
                google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
                },
                active: function() {
                sessionStorage.fonts = true;
                }
            });
            </script>
        <!--end::Web font -->

        <link href="{{ asset('adminpanel/assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('adminpanel/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('adminpanel/css/admin.css') }}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{{ asset('adminpanel/assets/demo/default/media/img/logo/logo.png') }}" />
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
        @yield('additional_css')   
        <link media="all" rel="stylesheet" type="text/css" href="{{ asset('css/site_theme.css') }}"> 
        <style>
            #expand_logo img{
                position: relative;
                top: 20px;
            }          
        </style>
    </head>
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
        <!-- begin:: Page -->
        
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <header id="m_header" class="m-grid__item  m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
                <div class="m-container m-container--fluid m-container--full-height">
                <div class="m-stack m-stack--ver m-stack--desktop">
                    <!-- BEGIN: Brand -->
                    <div class="m-stack__item m-brand  m-brand--skin-dark ">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo" id='expand_logo' style='display:block' >
                        <a href="{{ route('admin.dashboard') }}" class="m-brand__logo-wrapper" >
                        @if(isset($site_configurations) && $site_configurations->logo != "" && file_exists(public_path("uploads/logo/".$site_configurations->logo)))
                          <img src="{{ asset('uploads/logo/'.$site_configurations->logo) }}" id="admin_logo"/>
                        @else
                            <img alt="" src="{{ asset('/images/logos/site_logo.png') }}" id="admin_logo"/>
                        @endif
                        </a>                       
                        </div>
                        <div class="m-stack__item m-stack__item--middle" id='collapse_logo' style='display:none'>
                        <a href="{{ route('admin.dashboard') }}" class="m-brand__logo-wrapper" >
                            <img alt="" style="width:50px" src="{{ asset('/adminpanel/assets/demo/default/media/img/logo/logo.png') }}" id="admin_logo"/>
                        </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        </div>
                    </div>
                    </div>
                    <!-- END: Brand -->
                    <div class="txtlogout m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav-A">
                    <div class="logout_label"><i class="fa fa-user"></i> {{ Session::get('admin_user.firstname') }} {{ Session::get('admin_user.lastname') }} |   <a href="javascript:void(0);" class="logout">Logout</a></div>
                    </div>
                    
                </div>
                
                </div>
            </header>
            <!-- END: Header -->
            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
                <i class="la la-close"></i>
                </button>
                <div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
                    
                    <!-- BEGIN: Aside Menu -->
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
                        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                            <div class="sidebar_header">
                                <i class="fa fa-newspaper-o" style="font-size: 24px;"></i>
                                <!-- <img src="https://image.flaticon.com/icons/svg/1063/1063385.svg" width="24" height="24" alt="Cms free icon" title="Cms free icon"> -->
                                <span class="hideable-menu">
                                     Admin Panel
                                </span>

                            </div>

                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a href="{{ route('admin.dashboard') }}" class="m-menu__link {{$menu_item_parent == 'dashboard'?'active':''}}" id="usecase-sidebar">
                                    
                                    <i class="fa fa-dashboard" aria-hidden="true"></i>
                                    <span class="hideable-menu">
                                        Dashboard
                                    </span>                                
                                </a>
                            </li>

                            <li class="m-menu__item  m-menu__item--submenu"  aria-haspopup="true" m-menu-submenu-toggle="hover">
                                <span class="m-menu__link menu-home m-menu__toggle {{$menu_item_parent=='home'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span class="hideable-menu">   
                                    Home
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    </span>
                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav sub-menu-expanded">
                                
                                    <li class="m-menu__sidebar {{$menu_item_child=='home_featured_data'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.home_featured_data') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Featured Data</a></li>
                                    <li class="m-menu__sidebar {{$menu_item_child=='home_trending'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.home_trending') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Trending</a></li>
                                    <li class="m-menu__sidebar {{$menu_item_child=='home_marketplace'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.home_marketplace') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;New on the Marketplace</a></li>
                                    <li class="m-menu__sidebar {{$menu_item_child=='home_teampicks'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.home_teampicks') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;<?php echo APPLICATION_NAME; ?> Team Picks</a></li>
                                    <li class="m-menu__sidebar {{$menu_item_child=='home_featured_provider'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.home_featured_provider') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Featured Data Providers</a></li>
                                    <li class="m-menu__sidebar {{$menu_item_child=='top_use_cases'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.top_use_cases') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Top Use Cases</a></li>
                                    <!-- <li class="m-menu__sidebar {{$menu_item_child=='home_top_usecases'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.usecases', [ 'id' => 6 ]) }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Top use cases</a></li> -->
                                </ul>
                                </div>
                            </li>
                            <!-- <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a class="m-menu__link" id="usecase-sidebar">
                                    <i class="fa fa-archive" aria-hidden="true"></i>
                                            About
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                            </li> -->
                             <!--<li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a class="m-menu__link" id="usecase-sidebar">
                                    <i class="fa fa-id-card" aria-hidden="true"></i>
                                            DataMatch
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                            </li> -->
                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true" m-menu-submenu-toggle="hover">
                                <span class="m-menu__link menu-usecases m-menu__toggle {{$menu_item_parent=='usecases'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                                    <span class="hideable-menu">  Use Cases </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </span>
                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav sub-menu-expanded">
                                            @foreach ($allActiveCommunities as $key=>$comm) 
                                            @php
                                            $comm_slug = $comm->slug;
                                            $communityIdx = $comm->communityIdx;
                                            $route =  route("admin.usecases", [ 'id' => $communityIdx ]);
                                            @endphp

                                        <li class="m-menu__sidebar {{$menu_item_child==$communityIdx?'active':''}}"  aria-haspopup="true"><a href="{{ $route}}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;{{$comm->communityName}}</a></li>

                                    @endforeach 
                                    </ul>
                                </div>
                            </li>
                            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" m-menu-submenu-toggle="hover">
                                <span class="m-menu__link menu-help m-menu__toggle {{$menu_item_parent=='help'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-deaf" aria-hidden="true"></i>
                                    <span class="hideable-menu">  Help </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </span>
                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav sub-menu-expanded">
                                    <li class="m-menu__sidebar m-menu__item m_menu-item--parent"  aria-haspopup="true">
                                        <span class="m-menu__link menu-sub-buying menu-buying" >
                                            <i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Buying Data
                                        </span>
                                        <ul class=" sub-menu-expanded subsider_sub_ul menu-sub-buying {{$menu_item_child=='buying_data'?'':'hide'}}">
                                            <li class="m-menu__sidebar {{$menu_item_child_child=='buying_title_intro'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.buying_data') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Title and Intro</a></li>
                                            <li class="m-menu__sidebar {{$menu_item_child_child=='buying_topics'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.buying_data_topics') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Content</a></li>
                                            <li class="m-menu__sidebar {{$menu_item_child_child=='buying_faqs'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.buying_data_faqs') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;FAQs</a></li>
                                        </ul>
                                    </li>
                                    <li class="m-menu__sidebar m-menu__item m_menu-item--parent"  aria-haspopup="true">
                                        <span class="m-menu__link menu-sub-selling menu-selling" >
                                            <i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Selling Data
                                        </span>
                                        <ul class="sub-menu-expanded subsider_sub_ul menu-sub-selling {{$menu_item_child=='selling_data'?'':'hide'}}">
                                            <li class="m-menu__sidebar {{$menu_item_child_child=='selling_title_intro'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.selling_data') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Title and Intro</a></li>
                                            <li class="m-menu__sidebar {{$menu_item_child_child=='selling_topics'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.selling_data_topics') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Content</a></li>
                                            <li class="m-menu__sidebar {{$menu_item_child_child=='selling_faqs'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.selling_data_faqs') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;FAQs</a></li>
                                        </ul>
                                    </li>
                                    <li class="m-menu__sidebar {{$menu_item_child=='guarantee'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.guarantee') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Guarantee</a></li>                                    
                                    <li class="m-menu__sidebar {{$menu_item_child=='complaint'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.complaint') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Complaints</a></li>
                                    <li class="m-menu__sidebar {{$menu_item_child=='feedback'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.help.feedback') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Feedbacks</a></li>
                                </ul>
                                </div>
                            </li>
                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a href="{{ route('admin.updates') }}" class="m-menu__link {{$menu_item_parent=='updates'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                    <span class="hideable-menu">      Updates </span>
                                </a>
                            </li>
        
                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true" m-menu-submenu-toggle="hover">
                                <span class="m-menu__link media-content  m-menu__toggle {{$menu_item_parent=='media'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                                    <span class="hideable-menu">  Media </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </span>
                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav sub-menu-expanded">
                                
                                    <li class="m-menu__sidebar {{$menu_item_child=='community-covers'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.media_library',['community-covers']) }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Community Cover Images</a></li>
                                    <li class="m-menu__sidebar {{$menu_item_child=='offer-covers'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.media_library',['offer-covers']) }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Data Offer Images</a></li>
                                    
                                </ul>
                            </div>
                            </li>
                             <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a class="m-menu__link {{$menu_item_parent=='partners'?'active':''}}"  id="usecase-sidebar" href="{{ route('admin.partners') }}">
                                    <i class="fa fa-group" aria-hidden="true"></i>
                                    <span class="hideable-menu">  Partners </span>                                    
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true" m-menu-submenu-toggle="hover">
                                <span class="m-menu__link settings-content m-menu__toggle {{$menu_item_parent=='settings'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-gear" aria-hidden="true"></i>
                                    <span class="hideable-menu">  Settings </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </span>
                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								    <ul class="m-menu__subnav sub-menu-expanded">
                                        <li class="m-menu__sidebar {{$menu_item_child=='configuration'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.settings.configuration_list') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Site Configurations</a></li>
                                        <li class="m-menu__sidebar {{$menu_item_child=='theming'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.settings.theming') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Themes</a></li>                                        
                                    </ul>
                                </div>
                            </li>
                            <!-- <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a class="m-menu__link" id="usecase-sidebar">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            Contact us
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                            </li> -->
                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a href="{{ route('admin.users') }}" class="m-menu__link {{$menu_item_parent=='users'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-user-o" aria-hidden="true"></i>
                                    <span class="hideable-menu">  Users </span>
                                    
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item--parent"   aria-haspopup="true" m-menu-submenu-toggle="hover">
                                <span class="m-menu__link menu-content m-menu__toggle {{$menu_item_parent=='content'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-list" aria-hidden="true"></i>
                                    <span class="hideable-menu">  Manage Contents </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </span>

                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								    <ul class="m-menu__subnav sub-menu-expanded">
                                        <li class="m-menu__sidebar {{$menu_item_child=='communities'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.communities') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Communities</a></li>
                                        <li class="m-menu__sidebar {{$menu_item_child=='providers'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.providers') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Providers</a></li>
                                        <li class="m-menu__sidebar {{$menu_item_child=='themes'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.themes') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Themes</a></li>
                                        <li class="m-menu__sidebar {{$menu_item_child=='offers'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.offers') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Offers</a></li>

                                        <li class="m-menu__sidebar {{$menu_item_child=='products'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.products') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Products</a></li>
                                        <li class="m-menu__sidebar {{$menu_item_child=='contents'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.contents') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Contents</a></li>
                                        <li class="m-menu__sidebar {{$menu_item_child=='purchases'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.purchases') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;Purchases</a></li>
                                         <li class="m-menu__sidebar {{$menu_item_child=='user_activity'?'active':''}}"  aria-haspopup="true"><a href="{{ route('admin.user_activity') }}" class="m-menu__link"><i class="la la-angle-double-right submenu_arrow"></i>&nbsp;User Activity Log</a></li>
                                    </ul>
                                </div>

                            </li>
                           
                           
                           
                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a href="{{ route('admin.content.edit', 1) }}" class="m-menu__link {{$menu_item_parent=='editcontent'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span class="hideable-menu">  About {{APPLICATION_NAME}} </span>
                                    
                                </a>
                            </li>
                           

                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a href="{{ route('admin.searched_keys') }}" class="m-menu__link {{$menu_item_parent=='searchkeys'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span class="hideable-menu"> Searched Keywords </span>
                                </a>
                            </li>


                            <li class="m-menu__item  m-menu__item--parent"  aria-haspopup="true">
                                <a href="{{ route('admin.content.edit', 2) }}" class="m-menu__link {{$menu_item_parent=='editDxcDoc'?'active':''}}" id="usecase-sidebar">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span class="hideable-menu">  DXC Documentation</span>
                                    
                                </a>
                            </li>

                            <!-- <a href="{{ route('admin.users') }}" class="m-menu__link {{$menu_item_parent=='users'?'active':''}}">
                                <div class="sidebar_header">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    Users
                                </div>
                            </a> -->
                            <!-- <div class="sidebar_header">
                                <a href="{{route('admin.logout')}}">
                                    <i class="fa fa-sign-out" style="font-size:30px" aria-hidden="true"></i>
                                    Logout
                                </a>
                            </div> -->
                        </ul>
                    </div>
                    <!-- END: Aside Menu -->
                </div>
                <!-- END: Left Aside -->    
                <div id="admin_container">
                    @include('layouts.flash') 
                    @yield('content')
                </div>

            </div>
            <!-- end:: Body -->
        </div>
        <!-- end:: Page -->
        <script src="{{ asset('adminpanel/assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('adminpanel/assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/plugins/ckeditor_full/ckeditor.js') }}"></script>
        <script src="{{ asset('adminpanel/js/custom.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/plugins/summernote-image-attributes.js') }}"></script>
        <script>
        //    CKEDITOR.plugins.addExternal( 'font', "{{ 'plugins/font/'}}", 'plugin.js' );
          //  CKEDITOR.plugins.addExternal( 'justify', "{{ 'plugins/justify/'}}", 'plugin.js' );
            //CKEDITOR.plugins.addExternal( 'colorbutton', "{{ 'plugins/colorbutton/'}}", 'plugin.js' );
            
                         CKEDITOR.replace(document.querySelector( '#editor' ),{
                           // extraPlugins: ['font','justify','colorbutton'],
                           
                                filebrowserUploadUrl: "{{route('admin.imageUpload', ['_token' => csrf_token() ])}}",
                                filebrowserBrowseUrl: "{{route('admin.browseImages')}}",
                             filebrowserUploadMethod: 'form'
                         });
                         for (var i in CKEDITOR.instances) {
                
                                CKEDITOR.instances[i].on('change', function() { CKEDITOR.instances[i].updateElement() });
                                
                        }
                </script>
        <script>
        window.addEventListener('storage', function(event){
            if (event.key == 'logout-event') { 
                window.location.href = "";
            }
        });
        $(document).ready(function(){
            var perfEntries = performance.getEntriesByType("navigation");
            for (var i = 0; i < perfEntries.length; i++) {
                if(perfEntries[i].type === "back_forward"){ // if user has reach the page via the back button..
                    document.querySelector(".flash-alert-msg").innerHTML = ""; //...delete the contents of the flash container
                }
            }
            $('.logout').click(function(){
                $.ajax({
                    method:'GET',
                    url: "{{ route('admin.logout') }}",
                    success:function(response){
                        if(response == 'success'){
                            localStorage.setItem('logout-event', 'logout' + Math.random());
                            window.location.href = "";
                        } else {
                            alert('Sorry! Something is going wrong.');
                        }
                    }
                });
    	        return false;
            });

            if($('.m-menu__link.menu-usecases').hasClass('active')){
                    $('.m-menu__link.menu-usecases').next('div').show();
            }
            if($('.m-menu__link.menu-content').hasClass('active')){
                    $('.m-menu__link.menu-content').next('div').show();
            }
            if($('.m-menu__link.media-content').hasClass('active')){
                    $('.m-menu__link.media-content').next('div').show();
            }
            if($('.m-menu__link.settings-content').hasClass('active')){
                    $('.m-menu__link.settings-content').next('div').show();
            }
            if($('.m-menu__link.menu-home').hasClass('active')){
                    $('.m-menu__link.menu-home').next('div').show();
            }
            if($('.m-menu__link.menu-help').hasClass('active')){
                    $('.m-menu__link.menu-help').next('div').show();
            }
        });
            $('.m-menu__link.menu-usecases').click(function(){
                    $('.m-menu__item.m-menu__item--parent .m-menu__link.active').removeClass('active');
                    $('.m-menu__link.menu-usecases').addClass('active');
                if($('.subsider_ul.menu-usecases').hasClass('hide')){
                    $('.subsider_ul.menu-usecases').removeClass('hide');
                }
                else
                    $('.subsider_ul.menu-usecases').addClass("hide");
            });
            $('.m-menu__link.menu-content').click(function(){
                    $('.m-menu__item.m-menu__item--parent .m-menu__link.active').removeClass('active');
                    $('.m-menu__link.menu-content').addClass('active');
                if($('.subsider_ul.menu-content').hasClass('hide')){
                    $('.subsider_ul.menu-content').removeClass('hide');
                }
                else
                    $('.subsider_ul.menu-content').addClass("hide");
            });
            $('.m-menu__link.media-content').click(function(){
                    $('.m-menu__item.m-menu__item--parent .m-menu__link.active').removeClass('active');
                    $('.m-menu__link.media-content').addClass('active');
                if($('.subsider_ul.media-content').hasClass('hide')){
                    $('.subsider_ul.media-content').removeClass('hide');
                }
                else
                    $('.subsider_ul.media-content').addClass("hide");
            });
            $('.m-menu__link.settings-content').click(function(){
                    $('.m-menu__item.m-menu__item--parent .m-menu__link.active').removeClass('active');
                    $('.m-menu__link.settings-content').addClass('active');
                if($('.subsider_ul.settings-content').hasClass('hide')){
                    $('.subsider_ul.settings-content').removeClass('hide');
                }
                else
                    $('.subsider_ul.settings-content').addClass("hide");
            });
            $('.m-menu__link.menu-home').click(function(){
                
                $('.m-menu__item.m-menu__item--parent .m-menu__link.active').removeClass('active');
                $('.m-menu__link.menu-home').addClass('active');
                if($('.subsider_ul.menu-home').hasClass('hide')){
                    alert();
                    $('.subsider_ul.menu-home').removeClass('hide');
                }
                else
                    $('.subsider_ul.menu-home').addClass('hide');
            });
            $('.m-menu__link.menu-help').click(function(){
                $('.m-menu__item.m-menu__item--parent .m-menu__link.active').removeClass('active');
                $('.m-menu__link.menu-help').addClass('active');
                if($('.subsider_ul.menu-help').hasClass('hide'))
                    $('.subsider_ul.menu-help').removeClass('hide');
                else
                    $('.subsider_ul.menu-help').addClass('hide');
            });
            $('.m-menu__link.menu-sub-buying').click(function(){
                $('.m-menu__item.m-menu__item--parent .m-menu__link.active').removeClass('active');
                if($('.subsider_sub_ul.menu-sub-buying').hasClass('hide'))
                    $('.subsider_sub_ul.menu-sub-buying').removeClass('hide');
                else
                    $('.subsider_sub_ul.menu-sub-buying').addClass('hide');
            });
            $('.m-menu__link.menu-sub-selling').click(function(){
                $('.m-menu__item.m-menu__item--parent .m-menu__link.active').removeClass('active');
                if($('.subsider_sub_ul.menu-sub-selling').hasClass('hide'))
                    $('.subsider_sub_ul.menu-sub-selling').removeClass('hide');
                else
                    $('.subsider_sub_ul.menu-sub-selling').addClass('hide');
            });
        </script>
        @yield('additional_javascript')
    </body>
</html>