<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ config('global.site_name') }} | Admin</title>
    <link rel="apple-touch-icon" sizes="57x57"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180"
          href="{{ asset('') }}admin-assets/assets/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
          href="{{ asset('') }}admin-assets/assets/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="{{ asset('') }}admin-assets/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96"
          href="{{ asset('') }}admin-assets/assets/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="{{ asset('') }}admin-assets/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('') }}admin-assets/assets/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('') }}admin-assets/assets/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'> -->
    <link href="{{ asset('') }}admin-assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="{{ asset('') }}admin-assets/assets/css/boxicons.min.css" rel='stylesheet'>
    <link href="{{ asset('') }}admin-assets/assets/css/sidebar.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
          integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/solid.min.css"
          integrity="sha512-EvFBzDO3WBynQTyPJI+wLCiV0DFXzOazn6aoy/bGjuIhGCZFh8ObhV/nVgDgL0HZYC34D89REh6DOfeJEWMwgg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css"
          integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" ref="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
          integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="{{ asset('') }}admin-assets/assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('') }}admin-assets/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('') }}admin-assets/assets/css/parsley.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('') }}admin-assets/assets/css/newsidebar.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('') }}admin-assets/assets/css/datatable-custom.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @yield('header')
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <style>
        .dataTables_paginate {
            float: right !important;
        }
        .dataTables_paginate .paginate_button {
            padding: 0px 10px !important;
        }
        .error{
            color: red;
        }
    </style>
</head>

<!-- <body class="default-sidebar"> -->

<body>
<!-- New Sidebar Starts Here -->
<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="#!">
            <img src="{{ asset('') }}admin-assets/assets/img/logo.svg" style="width: 100%; height: 85px;" class="img-fluid" alt="logo"/>
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
        @if(get_user_permission('dashboard','r'))
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["admin.dashboard"])) active @endif">
                <a href="{{ url('admin/dashboard') }}" class="">
                            <span class="icon">
                                <i class="bx bx-grid-alt"></i>
                            </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
        @endif

            @php
                $isAdministration = false;
                    if( in_array(\Route::currentRouteName(),
                        [
                            "customer_types.list","customer_types.create","customer_types.edit",
                            "countries.list","countries.create","countries.edit",
                            "languages.list","languages.create","languages.edit",
                            "category.list","category.create","category.edit",
                        ])){
                        $isAdministration = true;
                    }
            @endphp
            
            
            <!-- <li class="nav-item @if( in_array(\Route::currentRouteName(),["users.list","users.create","users.edit"])) active @endif">
                <a href="{{route('users.list')}}">
                            <span class="icon">
                                <i class="bx bxs-user"></i>
                            </span>
                    <span class="text"> Users </span>
                </a>
            </li> -->

            @php
                $isadminusers = false;
                    if( in_array(\Route::currentRouteName(),
                        [
                            "user_roles.list","user_roles.create","user_roles.edit","users.list",
                            "users.create",
                            "users.edit",
                        ])){
                        $isadminusers = true;
                    }
            @endphp
            @if(get_user_permission('admin_users','r'))
            <li class="nav-item nav-item-has-children @if($isadminusers) active @endif">
                <a href="#0" class="@if(!$isadminusers) collapsed @endif" data-toggle="collapse"
                   data-auto-close="outside" data-target="#ddmenu_1"
                   aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon">
                                <i class="bx bx-file"></i>
                            </span>
                    <span class="text"> Admin Users </span>
                </a>
                <ul id="ddmenu_1" class="collapse dropdown-nav @if($isadminusers) show @endif">
                    <li>
                        <a href="{{route('users.list')}}"
                           class="@if(in_array(\Route::currentRouteName(),['users.list','users.create','users.edit'])) active @endif">
                            <span class="text"> Admin Users</span>
                        </a>
                    </li>
                    @if(get_user_permission('user_roles','r'))
                    <li>
                        <a href="{{ route('user_roles.list') }}"
                           class="@if(in_array(\Route::currentRouteName(),['user_roles.list','user_roles.create','user_roles.edit'])) active @endif">
                            <span class="text"> User Roles</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </li>
            @endif   




           
            
            @if(get_user_permission('company','r'))
                <li class="nav-item @if( in_array(\Route::currentRouteName(),["company.list","company.create","company.edit","company.view"])) active @endif">
                    <a href="{{ route('company.list') }}">
                        <span class="icon">
                            <i class="bx bxs-user"></i>
                        </span>
                        <span class="text"> Companies</span>
                    </a>
                </li>
            @endif
            
            @if(get_user_permission('drivers','r'))
                <li class="nav-item @if( in_array(\Route::currentRouteName(),["drivers.list","drivers.create","drivers.edit","drivers.view"])) active @endif">
                    <a href="{{route('drivers.list')}}">
                                <span class="icon">
                                    <i class="bx bxs-user"></i>
                                </span>
                        <span class="text"> Truck Drivers </span>
                    </a>
                </li> 
            @endif

            @if(get_user_permission('customers','r'))      
                <li class="nav-item @if( in_array(\Route::currentRouteName(),["customers.list.all","customers.create","customers.edit"])) active @endif">
                    <a href="{{route('customers.list.all')}}">

                                <span class="icon">
                                    <i class="bx bxs-user"></i>
                                </span>
                        <span class="text"> Customers </span>
                    </a>
                </li>
            @endif
            
            @if(get_user_permission('bookings','r'))
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["bookings.list","bookings.create","bookings.edit","bookings.view"])) active @endif">
                <a href="{{route('bookings.list')}}">
                            <span class="icon">
                                <i class="bx bxs-truck"></i>
                            </span>
                    <span class="text"> Bookings </span>
                </a>
            </li>
            @endif        

            @if(get_user_permission('earnings','r'))
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["earnings.list"])) active @endif">
                <a href="{{route('earnings.list')}}">
                            <span class="icon">
                            <i class="fa-solid fa-sack-dollar"></i>
                            </span>
                    <span class="text"> Earnings </span>
                </a>
            </li>
            @endif

            {{--
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["events","events.create","events.edit"])) active @endif">
                <a href="{{route('events')}}">
                            <span class="icon">
                                <i class="bx bx-calendar"></i>
                            </span>
                    <span class="text"> Events </span>
                </a>
            </li>
            --}}    


         
            @if(get_user_permission('reviews','r'))    
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["reviews.list","reviews.create","reviews.edit"])) active @endif">
                <a href="{{route('reviews.list')}}">
                            <span class="icon">
                                <i class="bx bxs-user"></i>
                            </span>
                    <span class="text"> Reviews </span>
                </a>
            </li>
            @endif

            
            @if(get_user_permission('notifications','r'))
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["notification.list"])) active @endif">
                <a href="{{route('notification.list')}}">
                            <span class="icon">
                                <i class="bx bxs-bell"></i>
                            </span>
                    <span class="text"> Notifications </span>
                </a>
            </li>
            @endif

            @php
                $isAdministration = false;
                    if( in_array(\Route::currentRouteName(),
                        [
                            "reports.jobs_in_transit",
                            "reports.customers",
                            "reports.drivers",
                            "reports.companies",
                        ])){
                        $isAdministration = true;
                    }
            @endphp

            @if(get_user_permission('reports','r'))
            <li class="nav-item nav-item-has-children @if($isAdministration) active @endif">
                <a href="#0" class="@if(!$isAdministration) collapsed @endif" data-toggle="collapse"
                   data-auto-close="outside" data-target="#ddmenu_1"
                   aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon">
                                <i class="bx bx-file"></i>
                            </span>
                    <span class="text"> Reports </span>
                </a>
                <ul id="ddmenu_1" class="collapse dropdown-nav @if($isAdministration) show @endif">
                    <li>
                        <a href="{{ route('reports.jobs_in_transit') }}"
                           class="@if(in_array(\Route::currentRouteName(),['reports.jobs_in_transit'])) active @endif">
                            <span class="text"> Booking Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.customers') }}"
                           class="@if(in_array(\Route::currentRouteName(),['reports.customers'])) active @endif">
                            <span class="text"> Customers</span>
                        </a>
                    </li>

                    <!-- <li>
                        <a href="{{ route('reports.drivers') }}"
                           class="@if(in_array(\Route::currentRouteName(),['reports.drivers'])) active @endif">
                            <span class="text"> Drivers</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('reports.companies') }}"
                           class="@if(in_array(\Route::currentRouteName(),['reports.companies'])) active @endif">
                            <span class="text"> Companies</span>
                        </a>
                    </li> -->
                </ul>
            </li>
            @endif    
            
            @if(get_user_permission('blacklists','r'))
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["blacklists.list","blacklists.create","blacklists.devices","blacklists.edit","blacklists.view"])) active @endif">
                <a href="{{route('blacklists.list')}}">
                            <span class="icon">
                            <i class="fa-solid fa-user-lock"></i>
                            </span>
                    <span class="text"> Blacklist </span>
                </a>
            </li>
            @endif

            @php
                $isCMS = false;
                    if( in_array(\Route::currentRouteName(),
                        [
                            "cms.pages.list","cms.pages.create","cms.pages.edit","settings", "cms.faq.list","cms.faq.create","cms.faq.edit"
                        ])){
                        $isCMS = true;
                    }
            @endphp

            <li class="nav-item nav-item-has-children @if($isCMS) active @endif">
                <a href="#0" class="@if(!$isCMS) collapsed @endif" data-toggle="collapse"
                   data-auto-close="outside" data-target="#ddmenu_3"
                   aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon">
                                <i class="bx bx-book-content"></i>
                            </span>
                    <span class="text"> CMS </span>
                </a>
                <ul id="ddmenu_3" class="collapse dropdown-nav @if($isCMS) show @endif">
                    @if(get_user_permission('pages','u'))
                        <li>
                            <a href="{{ route('cms.pages.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),["cms.pages.list","cms.pages.create","cms.pages.edit"])) active @endif">
                                <span class="text"> Pages</span>
                            </a>
                        </li>
                         <li>
                            <a href="{{ route('cms.faq.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),["cms.faq.list","cms.faq.create","cms.faq.edit"])) active @endif">
                                <span class="text"> Faq</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings') }}"
                               class="@if(in_array(\Route::currentRouteName(),["settings"])) active @endif">
                                <span class="text"> Settings</span>
                            </a>
                        </li>
                    @endif
                    
                </ul>
            </li>
            <li class="nav-item nav-item-has-children @if($isAdministration) active @endif">
                <a href="#0" class="@if(!$isAdministration) collapsed @endif" data-toggle="collapse"
                   data-auto-close="outside" data-target="#ddmenu_2"
                   aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon">
                                <i class="bx bx-key"></i>
                            </span>
                    <span class="text"> Masters </span>
                </a>
                <ul id="ddmenu_2" class="collapse dropdown-nav @if($isAdministration) show @endif">
                    
                    @if(get_user_permission('deligates','r'))
                        <li>
                            <a href="{{ route('deligates.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),['deligates.list','deligates.create','deligates.edit'])) active @endif">
                                <span class="text"> Deligates</span>
                            </a>
                        </li>
                    @endif

                    {{--
                    @if(get_user_permission('customer_types','r'))
                        <li>
                            <a href="{{ route('customer_types.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),['customer_types.list','customer_types.create','customer_types.edit'])) active @endif">
                                <span class="text"> Customer Types</span>
                            </a>
                        </li>
                    @endif
                    --}}

                    @if(get_user_permission('truck_types','r'))
                        <li>
                            <a href="{{ route('truck_type.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),['truck_type.list','truck_type.create','truck_type.edit'])) active @endif">
                                <span class="text"> Truck Types</span>
                            </a>
                        </li>
                    @endif

                    @if(get_user_permission('storage_types','r'))
                        <li>
                            <a href="{{ route('storage_types.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),['storage_types.list','storage_types.create','storage_types.edit'])) active @endif">
                                <span class="text"> Storage Types</span>
                            </a>
                        </li>
                    @endif
                    
                    @if(get_user_permission('containers','r'))
                        <li>
                            <a href="{{ route('containers.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),['containers.list','containers.create','containers.edit'])) active @endif">
                                <span class="text"> Containers</span>
                            </a>
                        </li>
                    @endif

                    @if(get_user_permission('shipping_methods','r'))
                        <li>
                            <a href="{{ route('shipping_methods.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),['shipping_methods.list','shipping_methods.create','shipping_methods.edit'])) active @endif">
                                <span class="text"> Shipping Methods</span>
                            </a>
                        </li>
                    @endif
                    
                    @if(get_user_permission('countries','r'))
                        <li>
                            <a href="{{ route('countries.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),['countries.list','countries.create','countries.edit'])) active @endif">
                                <span class="text"> Countries</span>
                            </a>
                        </li>
                    @endif

                    @if(get_user_permission('cities','r'))
                        <li>
                            <a href="{{ route('cities.list') }}"
                               class="@if(in_array(\Route::currentRouteName(),['cities.list','cities.create','cities.edit'])) active @endif">
                                <span class="text"> Cities</span>
                            </a>
                        </li>
                    @endif
                   
                    {{--    
                    @if(get_user_permission('languages','u'))
                        <li>
                            <a class="@if(in_array(\Route::currentRouteName(),['languages.list','languages.create','languages.edit'])) active @endif"
                               href="{{ route('languages.list') }}"><span class="text">Languages</span></a>
                        </li>
                    @endif
                    

                    @if(get_user_permission('category','r'))
                        <li>
                            <a class="@if(in_array(\Route::currentRouteName(),['category.list','category.create','category.edit'])) active @endif"
                               href="{{ route('category.list') }}"><span
                                    class="text">Intrested Categories</span></a>
                        </li>
                    @endif
                    --}}
                </ul>
            </li>
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["help_request"])) active @endif">
                <a href="{{route('help_request')}}">
                            <span class="icon">
                            <i class="fa-solid fa-user-lock"></i>
                            </span>
                    <span class="text"> Help Request </span>
                </a>
            </li>

{{--
            <li class="nav-item @if( in_array(\Route::currentRouteName(),["wallet.list","wallet.create","wallet.edit"])) active @endif">
                <a href="{{route('wallet.list')}}">
                            <span class="icon">
                                <i class="bx bxs-user"></i>
                            </span>
                    <span class="text"> Wallet </span>
                </a>
            </li>
--}}
        </ul>

    </nav>
</aside>
<div class="overlay"></div>
<!-- ======== sidebar-nav end =========== -->

<!-- New Sidebar Ends Here -->


<main class="main-wrapper">

    <div class="container-fluid d-none">
        <div class="page-header">
            <div class="page-title">
                <h3>{{ $page_heading ?? '' }}</h3>
                <div class="crumbs">
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard') }}"><i class="flaticon-home-fill"></i></a>
                        </li>
                        <li><a href="#">{{ $page_heading ?? '' }}</a>
                        </li>
{{--                        <?php if(isset($mode)) { ?>--}}
{{--                        <li class="active"><a href="#">{{ $mode ?? '' }}</a></li>--}}
{{--                        <?php } ?>--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- ======== Header start =========== -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-6">
                    <div class="header-left d-flex align-items-center">
                        <div class="menu-toggle-btn mr-20">
                            <button id="menu-toggle" class="main-btn primary-btn btn-hover"><i
                                    class="bx bx-chevron-left"></i> Menu
                            </button>
                        </div>

                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-6">
                    <div class="header-right">
                        <!-- profile start -->
                        <div class="profile-box ml-15">
                            <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                                    data-toggle="dropdown" aria-expanded="false">
                                <div class="profile-info">
                                    <div class="info">
                                        <h6 class="text-black mb-0">Hi, Admin</h6>
                                        <div class="image">
                                            <img src="{{ asset('') }}admin-assets/assets/img/profileicon.svg" alt=""/>
                                            <span class="status"></span>
                                        </div>
                                    </div>
                                </div>
                                <i class="bx bx-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                <li>
                                    <a href="{{ url('admin/dashboard') }}"> <i class="bx bx-grid-alt"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings.change-password') }}"> <i class="bx bxs-key"></i> Change
                                        Password </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/logout') }}"> <i class="bx bx-log-out-circle"></i> Sign Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- profile end -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ========== Header end ========== -->


    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30 pb-10">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>{{ $page_heading ?? '' }}</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper mb-30">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <!-- <li class="breadcrumb-item">
                                        <a href="#0">Dashboard</a>
                                    </li> -->
                                    <!-- <li class="breadcrumb-item active" aria-current="page">
                                        Analytics
                                    </li> -->
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('admin/dashboard') }}">
                                            <i class='bx bx-home-alt'></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a href="#">{{ $page_heading ?? '' }}</a>
                                    </li>
{{--                                    <?php if(isset($mode)) { ?>--}}
{{--                                    <li class="breadcrumb-item active">--}}
{{--                                        <a href="#">{{ $mode ?? '' }}</a>--}}
{{--                                    </li>--}}
{{--                                    <?php } ?>--}}
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>


            @yield('content')
        </div>
    </section>


    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 order-last order-md-first">
                    <div class="copyright text-center text-md-start">
                        <p class="text-sm mb-0 text-black">
                            &#xA9; {{ date('Y') }}
                            <a href="#!" class="text-black" rel="nofollow" target="_blank">
                                {{ config('global.site_name') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </footer>

    <!-- </section> -->

    @yield('footer')
</main>


<div class="sidebar close d-none">
    <div class="logo-details mt-2">
        <a href="#">
            <i class='bx bx-menu'></i>
        </a>
        <!-- <i class='bx bxl-c-plus-plus'></i> -->
        <!-- <img src="{{ asset('') }}admin-assets/assets/img/moda-icon.png" class="img-fluid" alt="">
            <span class="logo_name">MODA</span> -->
    </div>
    <ul class="nav-links">
        <li>
            <a href="{{ url('admin/dashboard') }}">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="{{ url('admin/dashboard') }}">Dashboard</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#">
                <i class='bx bxs-key'></i>
                <span class="link_name">Administration</span>
            </a>
            <ul class="sub-menu blank">
                @if(get_user_permission('user_roles','r'))
                    <li>
                        <a class="link_name" href="{{ route('user_roles.list') }}">User Roles</a>
                    </li>
                @endif
                @if(get_user_permission('countries','r'))
                    <li>
                        <a class="link_name" href="{{ route('countries.list') }}">Countries</a>
                    </li>
                @endif
                @if(get_user_permission('languages','r'))
                    <li>
                        <a class="link_name" href="{{ route('languages.list') }}">Languages</a>
                    </li>
                @endif
                @if(get_user_permission('category','r'))
                    <li>
                        <a class="link_name" href="{{ route('category.list') }}">Intrested Categories</a>
                    </li>
                @endif
            </ul>
        </li>
        @if(get_user_permission('users','r'))
            <li>
                <a href="{{ route('users.list') }}">
                    <i class='bx bxs-user-circle'></i>
                    <span class="link_name">Users</span>
                </a>
                <ul class="sub-menu blank">
                    <li>
                        <a class="link_name" href="{{ route('users.list') }}">Users</a>
                    </li>
                </ul>
            </li>
        @endif
        <li>
            <a href="#">
                <i class='bx bxs-building'></i>
                <span class="link_name">Malls & Stores</span>
            </a>
            <ul class="sub-menu blank">
                @if(get_user_permission('malls','r'))
                    <li>
                        <a class="link_name" href="{{ route('malls.list') }}">Malls & Stores</a>
                    </li>
                @endif
            </ul>
        </li>
        <li>
            <a href="{{ route('events') }}">
                <i class='bx bx-menu'></i>
                <span class="link_name">Events</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="{{ route('events') }}">Events</a>
                </li>
            </ul>
        </li>
    </ul>
</div>


<section class="home-section d-none">
    <div class="p-3 mb-2 container custom-header mt-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="{{ url('admin/dashboard') }}"
                   class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <img src="{{ asset('') }}admin-assets/assets/img/logo.svg" class="img-fluid brand-logo"
                         alt="">
                </a>
            </div>

            <div class="text-end d-flex align-items-center header-end">

                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="profile-name">Hi, Admin</span>
                        <img src="{{ asset('') }}admin-assets/assets/img/profile-icon.svg" alt="mdo"
                             width="32" height="32" class="rounded-circle">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ url('admin/dashboard') }}"><i
                                class='bx bx-grid-alt'></i> Dashboard</a>
                        <a class="dropdown-item" href="{{ url('admin/change_password') }}"><i
                                class='bx bxs-key'></i> Change Password</a>
                        <a class="dropdown-item" href="{{ url('admin/logout') }}"><i class='bx bx-log-out'></i>
                            Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="container">
        <div class="page-header">
            <div class="page-title">
                <h3>{{ $page_heading ?? '' }}</h3>
                <div class="crumbs">
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li><a href="{{ url('admin/dashboard') }}"><i class="flaticon-home-fill"></i></a>
                        </li>
                        <li><a onclick="window.history.back()" href="#">{{ $page_heading ?? '' }}</a>
                        </li>
                        <?php if(isset($mode)) { ?>
                        <li class="active"><a href="#">{{ $mode ?? '' }}</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>

    <footer class="container-fluid text-center">
        <!-- Copyright -->
        <div class="text-center p-3">
            <p class="bottom-footer mb-0 text-white">&#xA9; {{ date('Y') }} <a target="_blank"
                                                                               class="text-white"
                                                                               href="#">{{ config('global.site_name') }}</a>
            </p>
        </div>

        <!-- Copyright -->
    </footer>

    @yield('footer')
</section>


<div class="modal_loader">
    <!-- Place at bottom of page -->
</div>
<!-- Modal -->
<div class="modal fade" id="changepassword" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form method="post" id="admin-form" action="{{ url('admin/change_user_password') }}"
                      enctype="multipart/form-data" data-parsley-validate="true">
                    @csrf()
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="hidden" name="id" value="" id="userid">
                                <input type="password" name="password" id="password"
                                       class="form-control jqv-input" data-jqv-required="true" required
                                       data-parsley-required-message="Enter Password" data-parsley-minlength="8"
                                       autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Re-enter Password</label>
                                <input type="password" name="new_pswd" class="form-control jqv-input"
                                       data-parsley-minlength="8" data-parsley-equalto="#password"
                                       autocomplete="off" required
                                       data-parsley-required-message="Please re-enter password."
                                       data-parsley-trigger="keyup"
                                       data-parsley-equalto-message="Both passwords should be the same">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">Change</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

        </div>

    </div>
</div>
<style>
    .modal_loader {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, .8) url('https://i.stack.imgur.com/FhHRx.gif') 50% 50% no-repeat;
    }

    /* When the body has the loading class, we turn
the scrollbar off with overflow:hidden */
    body.my-loading .modal_loader {
        overflow: hidden;
    }

    /* Anytime the body has the loading class, our
modal element will be visible */
    body.my-loading .modal_loader {
        display: block;
    }

    .custom-file-label {
        overflow: hidden;
        white-space: nowrap;
        padding-right: 6em;
        text-overflow: ellipsis;
    }

    #image_crop_section {
        max-width: 100% !important;
    }
</style>
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('') }}admin-assets/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="{{ asset('') }}admin-assets/bootstrap/js/popper.min.js"></script>
<script src="{{ asset('') }}admin-assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('') }}admin-assets/plugins/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
<script src="{{ asset('admin-assets/assets/js/app.js') }}"></script>
<script src="{{ asset('admin-assets/assets/js/boxicons.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js"
        integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/solid.min.js"
        integrity="sha512-LKdDHe5ZhpmiH6Kd6crBCESKkS6ryNpGRoBjGeh5mM/BW3NRN4WH8pyd7lHgQTTHQm5nhu0M+UQclYQalQzJnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"
        integrity="sha512-K/oyQtMXpxI4+K0W7H25UopjM8pzq0yrVdFdG21Fh5dBe91I40pDd9A4lzNlHPHBIP2cwZuoxaUSX0GJSObvGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script type="text/javascript">
    today = "<?php echo date('Y-m-d'); ?>";
    jQuery(function () {
        App2.init();
        App.init({
            site_url: '{{ url('/') }}',
            base_url: '{{ url('/') }}',
            site_name: '{{ config('global.site_name') }}',
        });
        App.toast([]);

        @if(Session::has('success'))    
            App.toast("{{ Session::get('success') }}", 'Success!');
        @elseif(Session::has('error'))
            App.toast("{{ Session::get('error') }}", 'Error!');
        @endif

    });
    $('.date').datepicker({
        orientation: "bottom auto",
        todayHighlight: true,
        format: "yyyy-mm-dd",
        autoclose: true,
    });

    window.Parsley.addValidator('fileextension', {
        validateString: function (value, requirement) {
            var fileExtension = value.split('.').pop();
            extns = requirement.split(',');
            if (extns.indexOf(fileExtension.toLowerCase()) == -1) {
                return fileExtension === requirement;
            }
        },
    });
    window.Parsley.addValidator('maxFileSize', {
        validateString: function (_value, maxSize, parsleyInstance) {
            var files = parsleyInstance.$element[0].files;
            return files.length != 1 || files[0].size <= maxSize * 1024;
        },
        requirementType: 'integer',
    });

    window.Parsley.addValidator('lt', {
        validateString: function (value, requirement) {
            return parseFloat(value) < parseRequirement(requirement);
        },
        priority: 32
    });
    var parseRequirement = function (requirement) {
        if (isNaN(+requirement))
            return parseFloat(jQuery(requirement).val());
        else
            return +requirement;
    };

    window.Parsley.addValidator('lte', {
        validateString: function (value, requirement) {
            return parseFloat(value) <= parseRequirement(requirement);
        },
        priority: 32
    });
    window.Parsley.addValidator('imagedimensions', {
        requirementType: 'string',
        validateString: function (value, requirement, parsleyInstance) {
            let file = parsleyInstance.$element[0].files[0];
            let [width, height] = requirement.split('x');
            let image = new Image();
            let deferred = $.Deferred();

            image.src = window.URL.createObjectURL(file);
            image.onload = function () {
                if (image.width == width && image.height == height) {
                    deferred.resolve();
                } else {
                    deferred.reject();
                }
            };

            return deferred.promise();
        },
        messages: {
            en: 'Image dimensions should be  %spx'
        }
    });

    window.Parsley.addValidator('dategttoday', {
        validateString: function (value) {
            if (value !== '') {
                return Date.parse(value) >= Date.parse(today);
            }
            return true;
        },
        messages: {
            en: 'Date should be equal or greater than today'
        }
    });


    $('body').off('click', '[data-role="approve"]');
    $('body').on('click', '[data-role="approve"]', function (e) {
        e.preventDefault();
        var msg = $(this).data('message') || 'Are you sure that you want to approve this record?';
        var href = $(this).attr('href');
        var title = $(this).data('title') || 'Confirm Approve';

        App.confirm(title, msg, function () {
            var ajxReq = $.ajax({
                url: href,
                type: 'GET',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (res) {
                    if (res['status'] == 1) {
                        App.alert(res['message'] || 'Approved successfully', 'Success!');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);

                    } else {
                        App.alert(res['message'] || 'Unable to approve the record.',
                            'Failed!');
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {

                }
            });
        });

    });
    $('body').off('click', '[data-role="reject"]');
    $('body').on('click', '[data-role="reject"]', function (e) {
        e.preventDefault();
        var msg = $(this).data('message') || 'Are you sure that you want to reject this record?';
        var href = $(this).attr('href');
        var title = $(this).data('title') || 'Confirm Reject';

        App.confirm(title, msg, function () {
            var ajxReq = $.ajax({
                url: href,
                type: 'GET',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (res) {
                    if (res['status'] == 1) {
                        App.alert(res['message'] || 'Rejected successfully', 'Success!');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);

                    } else {
                        App.alert(res['message'] || 'Unable to reject the record.',
                            'Failed!');
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {

                }
            });
        });

    });

    $(document).on('change', '.custom-file-input', function () {
        var file = $(this)[0].files[0].name;
        $(this).next('.custom-file-label').html(file);
    });

    $('body').off('click', '[data-role="verify"]');
    $('body').on('click', '[data-role="verify"]', function (e) {
        e.preventDefault();
        var href = $(this).attr('url');

        $.ajax({
            url: href,
            type: 'POST',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function (res) {
                if (res['status'] == 1) {
                    App.alert(res['message'] || 'Verified successfully', 'Success!');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500);

                } else {
                    App.alert(res['message'] || 'Unable to verify the record.', 'Failed!');
                }
            },
            error: function (jqXhr, textStatus, errorMessage) {

            }
        });

    });
    $(".change_status").change(function () {
        status = 0;
        if (this.checked) {
            status = 1;
        }

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: $(this).data('url'),
            data: {
                "id": $(this).data('id'),
                'status': status,
                "_token": "{{ csrf_token() }}"
            },
            timeout: 600000,
            dataType: 'json',
            success: function (res) {
                App.loading(false);

                if (res['status'] == 0) {
                    var m = res['message']
                    App.alert(m, 'Oops!');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500);
                } else {
                    App.alert(res['message']);
                }
            },
            error: function (e) {
                App.alert(e.responseText, 'Oops!');
            }
        });
    });
    $(document).on('keyup', 'input[type="text"],textarea', function () {
        _name = $(this).attr("name");
        _type = $(this).attr("type");
        if (_name == "email" || _name == "r_email" || _name == "password" || _type == "email" || _type ==
            "password" || $(this).hasClass("no-caps")) {
            return false;
        }
        txt = $(this).val();
        //$(this).val(txt.substr(0,1).toUpperCase()+txt.substr(1));
    });
    // Load Provinces on Country Change
    $('body').off('change', '[data-role="country-change"]');
    $('body').on('change', '[data-role="country-change"]', function () {
        var $t = $(this);
        var $dialcode = $('#' + $t.data('input-dial-code'));
        var $state = $('#' + $t.data('input-state'));

        if ($dialcode.length > 0) {
            var code = $t.find('option:selected').data('phone-code');
            console.log(code)
            if (code == '') {
                $dialcode.val('');
            } else {
                $dialcode.val(code);
            }
        }

        if ($state.length > 0) {

            var id = $t.val();
            var html = '<option value="">Select</option>';
            $state.html(html);
            $state.trigger('change');

            if (id != '') {
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "{{ url('admin/states/get_by_country') }}",
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}"
                    },
                    timeout: 600000,
                    dataType: 'json',
                    success: function (res) {
                        for (var i = 0; i < res['states'].length; i++) {
                            html += '<option value="' + res['states'][i]['id'] + '">' + res[
                                'states'][i]['name'] + '</option>';
                            if (i == res['states'].length - 1) {
                                $state.html(html);
                                // $('.selectpicker').selectpicker('refresh')
                            }
                        }
                    }
                });
            }
        }
    });
    $('body').off('change', '[data-role="state-change"]');
    $('body').on('change', '[data-role="state-change"]', function () {
        var $t = $(this);
        var $city = $('#' + $t.data('input-city'));

        if ($city.length > 0) {
            var id = $t.val();
            var html = '<option value="">Select</option>';

            $city.html(html);
            if (id != '') {
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "{{ url('admin/cities/get_by_state') }}",
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}"
                    },
                    timeout: 600000,
                    dataType: 'json',
                    success: function (res) {
                        for (var i = 0; i < res['cities'].length; i++) {
                            html += '<option value="' + res['cities'][i]['id'] + '">' + res[
                                'cities'][i]['name'] + '</option>';
                            if (i == res['cities'].length - 1) {
                                $city.html(html);
                                // $('.selectpicker').selectpicker('refresh')
                            }
                        }
                    }
                });
            }

        }
    });
    $('body').off('change', '[data-role="vendor-change"]');
    $('body').on('change', '[data-role="vendor-change"]', function () {
        var $t = $(this);
        var $city = $('#' + $t.data('input-store'));

        if ($city.length > 0) {
            var id = $t.val();
            var html = '<option value="">Select</option>';

            $city.html(html);
            if (id != '') {
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "{{ url('admin/store/get_by_vendor') }}",
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}"
                    },
                    timeout: 600000,
                    dataType: 'json',
                    success: function (res) {
                        for (var i = 0; i < res['stores'].length; i++) {
                            html += '<option value="' + res['stores'][i]['id'] + '">' + res[
                                'stores'][i]['store_name'] + '</option>';
                            if (i == res['stores'].length - 1) {
                                $city.html(html);
                                // $('.selectpicker').selectpicker('refresh')
                            }
                        }
                    }
                });
            }

        }
    });
    $('body').off('click', '[data-role="change_password"]');
    $('body').on('click', '[data-role="change_password"]', function (e) {
        var userid = $(this).attr('userid');
        $('#userid').val(userid);
        $('#changepassword').modal('show');
    });


    $(".flatpickr-input").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d"
    });

    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }

    /* ========= sidebar toggle ======== */
    const sidebarNavWrapper = document.querySelector(".sidebar-nav-wrapper");
    const mainWrapper = document.querySelector(".main-wrapper");
    const menuToggleButton = document.querySelector("#menu-toggle");
    const menuToggleButtonIcon = document.querySelector("#menu-toggle i");
    const overlay = document.querySelector(".overlay");

    menuToggleButton.addEventListener("click", () => {
        sidebarNavWrapper.classList.toggle("active");
        overlay.classList.add("active");
        mainWrapper.classList.toggle("active");

        if (document.body.clientWidth > 1200) {
            if (menuToggleButtonIcon.classList.contains("bx-chevron-left")) {
                menuToggleButtonIcon.classList.remove("bx-chevron-left");
                menuToggleButtonIcon.classList.add("bx-menu");
            } else {
                menuToggleButtonIcon.classList.remove("bx-menu");
                menuToggleButtonIcon.classList.add("bx-chevron-left");
            }
        } else {
            if (menuToggleButtonIcon.classList.contains("bx-chevron-left")) {
                menuToggleButtonIcon.classList.remove("bx-chevron-left");
                menuToggleButtonIcon.classList.add("bx-menu");
            }
        }
    });
    overlay.addEventListener("click", () => {
        sidebarNavWrapper.classList.remove("active");
        overlay.classList.remove("active");
        mainWrapper.classList.remove("active");
    });

</script>

<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@yield('script')
@stack('js')
@stack('component-js')
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>

</html>
