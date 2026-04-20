<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('assets/') }}/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}- {{ $title ?? '' }}</title>
    <meta name="keywords" content="GREWRS">
    <meta name="author" content="GREWRS">
    <base href="{{ asset('assets/') }}/">
    <meta name="description" content="Grewrs APP" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">


    <!-- Icons -->
    <link rel="stylesheet" href="vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="css/demo.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="vendor/libs/typeahead-js/typeahead.css" />



    @stack('vendor-style')
    @stack('stylesheets')
    @stack('scripts-top')

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="vendor/js/helpers.js"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="js/config.js"></script>
    <style>
        .sidebar-logo {
            filter: brightness(0) invert(1);
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme sidebar-image">
                <div class="app-brand demo d-flex justify-content-center align-items-center text-center">
                    <a href="{{ route('dashboard') }}" class="app-brand-link d-flex align-items-center">
                        <img title="Flood Report System" class="sidebar-logo"
                            src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid"
                            style="height: 80px !important;" />
                    </a>
                </div>

                <div class="menu-divider mt-0"></div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    @include('layouts.partials.menu-generator')
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="container-fluid">
                        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                <i class="bx bx-menu bx-sm"></i>
                            </a>
                        </div>

                        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                            <!-- Search -->
                            <div class="navbar-nav flex-row align-items-center h-100">
                                <div class="nav-item mb-0">
                                    <h3 class="navbar-top-title mb-0">
                                        @isset($title)
                                            {{ $title }}
                                        @endisset
                                    </h3>
                                </div>
                            </div>
                            <!-- /Search -->

                            <ul class="navbar-nav flex-row align-items-center ms-auto">

                                <!-- Notification -->
                                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        <i class="bx bx-bell bx-sm"></i>
                                        <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end py-0">
                                        <li class="dropdown-menu-header border-bottom">
                                            <div class="dropdown-header d-flex align-items-center py-3">
                                                <h5 class="text-body mb-0 me-auto">Notification</h5>
                                                <a href="javascript:void(0)"
                                                    class="dropdown-notifications-all text-body"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Mark all as read"><i
                                                        class="bx fs-4 bx-envelope-open"></i></a>
                                            </div>
                                        </li>
                                        <li class="dropdown-notifications-list scrollable-container">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-success"><i
                                                                        class="bx bx-pie-chart-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">Monthly report is generated</h6>
                                                            <p class="mb-0">July monthly financial report is
                                                                generated</p>
                                                            <small class="text-muted">3 days ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>



                                            </ul>
                                        </li>
                                        <li class="dropdown-menu-footer border-top">
                                            <a href="javascript:void(0);"
                                                class="dropdown-item d-flex justify-content-center p-3">
                                                View all notifications
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ Notification -->

                                <!-- User -->
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center justify-content-between"
                                        href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-online me-2">
                                                <img src="{{ asset('assets/img/avatars/1.png') }}" height="40"
                                                    width="40" alt class="rounded-circle" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-medium d-block lh-1">
                                                    {{ auth()->user()->name }}
                                                </span>
                                                <small>admin</small>
                                            </div>
                                        </div>
                                        <i class="bx bx-chevron-down ms-2"></i> <!-- Bootstrap Icons dropdown arrow -->
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="{{ asset('assets/img/avatars/1.png') }}"
                                                                height="40" width="40" alt
                                                                class="rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="fw-medium d-block lh-1">

                                                        </span>
                                                        <small></small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="bx bx-user mr-50"></i> Edit Profile
                                            </a>
                                        </li>


                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ User -->
                            </ul>
                        </div>

                        <!-- Search Small Screens -->
                        <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
                            <input type="text" class="form-control search-input border-0" placeholder="Search..."
                                aria-label="Search..." />
                            <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
                        </div>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0);">Home</a>
                                </li>

                                @if (isset($back_route))
                                    <li class="breadcrumb-item">
                                        @if (isset($back_route[2]))
                                            <a href="{{ $back_route[0] }}">
                                                {{ $back_route[1] }}
                                            </a> /
                                            </span>
                                        @else
                                            <a href="{{ route($back_route[0]) }}">
                                                {{ $back_route[1] }}
                                            </a>
                                        @endif
                                    </li>
                                @endif
                                <li class="breadcrumb-item active"> {{ $title ?? '' }}</li>
                            </ol>
                        </nav>

                        <div class="row">
                            <div class="col-12">
                                @if (\Illuminate\Support\Facades\Session::has('error'))
                                    <div class="alert alert-solid-danger alert-dismissible" role="alert">
                                        <h6 class="alert-heading mb-1"><i
                                                class="bx bx-xs bx-desktop align-top me-2"></i>Error!</h6>
                                        <span>{{ \Illuminate\Support\Facades\Session::get('error') }}</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (\Illuminate\Support\Facades\Session::has('success'))
                                    <div class="alert alert-solid-success alert-dismissible" role="alert">
                                        <h6 class="alert-heading mb-1"><i
                                                class="bx bx-xs bx-desktop align-top me-2"></i>Success!</h6>
                                        <span>{{ \Illuminate\Support\Facades\Session::get('success') }}</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @yield('content')
                    </div>
                    <!-- / Content -->



                    <!-- BEGIN: Footer-->
                    <footer class="footer bg-footer-theme">
                        <div
                            class="container-fluid d-flex flex-md-row flex-column justify-content-end align-items-md-center gap-1 container-p-x py-3">
                            <div>
                                <a href="https://demos.pixinvent.com/frest-html-admin-template/landing/"
                                    target="_blank" class="footer-text fw-bold">Frest</a>
                                ©
                            </div>
                            <div>
                                <a href="https://themeforest.net/licenses/standard" class="footer-link me-4"
                                    target="_blank">License</a>
                                <a href="javascript:void(0)" class="footer-link me-4">Help</a>
                                <a href="javascript:void(0)" class="footer-link me-4">Contact</a>
                                <a href="javascript:void(0)" class="footer-link">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </footer>
                    <!-- END: Footer-->
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="vendor/libs/jquery/jquery.js"></script>
    <script src="vendor/libs/popper/popper.js"></script>
    <script src="vendor/js/bootstrap.js"></script>
    <script src="vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/libs/hammer/hammer.js"></script>
    <script src="vendor/libs/i18n/i18n.js"></script>
    <script src="vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    @stack('verndor-scripts')
    @stack('plugin-scripts')
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <!-- Page JS -->
    @stack('scripts')
    @stack('scripts-bottom')
</body>

</html>
