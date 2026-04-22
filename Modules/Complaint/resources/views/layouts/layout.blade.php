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
            padding: 1.5rem;
        }

        .topbar-card,
        .content-card {
            background: #fff;
            border: 1px solid #dbe4ef;
            border-radius: 1rem;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.06);
        }

        .topbar-card {
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }

        .content-card {
            padding: 1.25rem;
        }

        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0;
        }
    </style>
    @stack('stylesheets')
</head>
<body>
    <div class="container-fluid app-shell">
        <div class="row">
            @include('complaint::layouts.sidebar')

            <main class="col-lg-10 ms-sm-auto px-0">
                <div class="app-content">
                    <div class="topbar-card d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h1 class="page-title">{{ $title ?? 'Complaint Workflow' }}</h1>
                            <p class="page-subtitle">RTS complaint management workflow with role-based visibility and escalation handling.</p>
                        </div>

                        @auth
                            <div class="d-flex align-items-center gap-3">
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
    @stack('scripts')
</body>
</html>
