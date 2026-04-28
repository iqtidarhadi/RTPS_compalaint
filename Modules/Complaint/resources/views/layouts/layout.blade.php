<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - {{ $title ?? 'Complaint Workflow' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f7fb;
            color: #14213d;
        }

        .app-shell {
            min-height: 100vh;
        }

        .app-content {
            padding: 1rem;
            padding-bottom: 5rem;
        }

        @media (min-width: 992px) {
            .app-content {
                padding: 1.5rem;
                padding-bottom: 1.5rem;
            }
        }

        .topbar-card,
        .content-card {
            background: #fff;
            border: 1px solid #dbe4ef;
            border-radius: 1rem;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.06);
        }

        .topbar-card {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .content-card {
            padding: 1rem;
        }

        @media (min-width: 768px) {
            .topbar-card {
                padding: 1rem 1.25rem;
            }
            .content-card {
                padding: 1.25rem;
            }
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        @media (min-width: 768px) {
            .page-title {
                font-size: 1.4rem;
            }
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 0.8rem;
            margin-bottom: 0;
        }

        @media (min-width: 768px) {
            .page-subtitle {
                font-size: 0.9rem;
            }
        }

        /* Mobile adjustments */
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0 !important;
            }
        }

        /* Ensure content is visible above mobile nav */
        .content-wrapper {
            padding-bottom: 4rem;
        }

        /* Sidebar collapse styles */
        #sidebar {
            width: 16.666667% !important;
            max-width: 220px;
            min-width: 220px;
            transition: all 0.3s ease;
            height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: #c7d2e2;
            border-radius: 999px;
        }

        #sidebar.collapsed {
            width: 47px !important;
            max-width: 61px;
            min-width: 57px;
        }

        #sidebar.collapsed .sidebar-text {
            display: none;
        }

        #sidebar.collapsed .sidebar-icon {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        #sidebar .sidebar-icon {
            display: none !important;
        }

        #sidebar.collapsed .sidebar-header a {
            justify-content: center;
        }

        #sidebar.collapsed .nav-link {
            justify-content: center;
            width: 30px;
            height: 30px;
            margin: 0 auto;
            padding: 0;
            gap: 0 !important;
        }

        #sidebar.collapsed .sidebar-header {
            padding: 0.25rem;
            text-align: center;
        }

        #sidebar.collapsed .nav-link i {
            margin: 0;
            font-size: 1rem;
            line-height: 1;
        }

        #sidebar.collapsed #toggleIcon {
            transform: rotate(180deg);
        }

        #sidebar.collapsed .p-3 {
            padding-left: 0.25rem !important;
            padding-right: 0.25rem !important;
        }

        #sidebar.collapsed .sidebar-header .sidebar-icon {
            width: 30px !important;
            height: 30px !important;
            font-size: 0.75rem;
        }

        .main-content {
            transition: margin-left 0.3s ease, width 0.3s ease;
            margin-left: 16.666667%;
            width: 83.333333%;
        }

        .main-content.expanded {
            margin-left: 0 !important;
            width: 100%;
        }

        /* Hide navigation label when collapsed */
        #sidebar.collapsed .text-uppercase {
            display: none;
        }

        /* Adjust main content for collapsed sidebar */
        @media (min-width: 992px) {
            .main-content.expanded {
                margin-left: 0 !important;
                width: 100%;
            }
        }
    </style>
    @stack('stylesheets')
</head>
<body>
    <div class="container-fluid app-shell">
        <div class="row">
            @include('complaint::layouts.sidebar')

            <main class="px-0 main-content">
                <div class="app-content content-wrapper">
                    <div class="topbar-card d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h1 class="page-title">{{ $title ?? 'Complaint Workflow' }}</h1>
                            <p class="page-subtitle">RTS complaint management workflow with role-based visibility and escalation handling.</p>
                        </div>

                        @auth
                            <div class="d-none d-lg-flex align-items-center gap-3">
                                <div class="text-end">
                                    <div class="fw-semibold">{{ trim((auth()->user()->firstname ?? '') . ' ' . (auth()->user()->lastname ?? '')) ?: (auth()->user()->name ?? auth()->user()->email) }}</div>
                                    <div class="text-muted small">{{ auth()->user()->role }}</div>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                                </form>
                            </div>
                        @endauth
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="content-card">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const toggleIcon = document.getElementById('toggleIcon');
            const mainContent = document.querySelector('.main-content');
            
            // Check localStorage for sidebar state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
            
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Save state to localStorage
                const isNowCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isNowCollapsed);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
