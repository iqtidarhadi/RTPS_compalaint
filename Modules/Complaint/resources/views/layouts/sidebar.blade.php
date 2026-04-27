@php
    $roleNames = auth()->check()
        ? auth()->user()->roles->pluck('name')->map(fn ($role) => strtolower($role))->all()
        : [];

    $isCitizen = in_array('citizen', $roleNames, true);
    $isDepartment = collect(['service point officer', 'appellate authority'])->intersect($roleNames)->isNotEmpty();
    $isRts = in_array('rts commission officer', $roleNames, true);
    $isAdmin = collect(['admin', 'super admin'])->intersect($roleNames)->isNotEmpty() || (!$isCitizen && !$isDepartment && !$isRts);

    $items = [
        ['label' => 'Dashboard', 'route' => 'complaint.dashboard', 'icon' => 'bx-grid-alt', 'visible' => true],
        ['label' => 'All Complaints', 'route' => 'complaints.index', 'icon' => 'bx-folder-open', 'visible' => $isAdmin],
        ['label' => 'Citizen Complaints', 'route' => 'complaints.index', 'icon' => 'bx-user', 'visible' => $isCitizen || $isAdmin, 'query' => ['scope' => 'citizen']],
        ['label' => 'Department Complaints', 'route' => 'complaints.index', 'icon' => 'bx-building-house', 'visible' => $isDepartment || $isAdmin, 'query' => ['scope' => 'department']],
        ['label' => 'RTS Complaints', 'route' => 'complaints.index', 'icon' => 'bx-shield-quarter', 'visible' => $isRts || $isAdmin, 'query' => ['scope' => 'rts']],
        ['label' => 'Pending Complaints', 'route' => 'complaints.index', 'icon' => 'bx-time', 'visible' => true, 'query' => ['scope' => 'pending']],
        ['label' => 'In Progress Complaints', 'route' => 'complaints.index', 'icon' => 'bx-loader-circle', 'visible' => true, 'query' => ['scope' => 'in_progress']],
        ['label' => 'Resolved Complaints', 'route' => 'complaints.index', 'icon' => 'bx-check-circle', 'visible' => true, 'query' => ['scope' => 'resolved']],
        ['label' => 'Rejected Complaints', 'route' => 'complaints.index', 'icon' => 'bx-x-circle', 'visible' => true, 'query' => ['scope' => 'rejected']],
    ];

    $currentRoute = request()->route()?->getName();
    $currentScope = request('scope');
@endphp

<aside class="px-0 bg-white border-end min-vh-100 position-fixed start-0 top-0 z-1000 d-none d-lg-block transition-all duration-300" id="sidebar">
    <!-- Sidebar Toggle Button -->
    <button class="btn btn-link position-absolute end-0 top-0 z-10 mt-3 text-muted" type="button" id="sidebarToggle" style="right: 8px;">
        <i class="bx bx-chevron-left fs-5" id="toggleIcon"></i>
    </button>
    
    <div class="p-3 border-bottom sidebar-header">
        <a href="{{ route('complaint.dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <!-- Collapsed Logo - RT Initials -->
            <span class="sidebar-icon d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold flex-shrink-0" style="width: 42px; height: 42px; background: linear-gradient(135deg, #0c447c, #1d6ecf); display: none;">
                RT
            </span>
            <!-- Expanded Logo and Text -->
            <div class="sidebar-text">
                <div class="fw-bold text-dark"><img src="{{ asset('assets/img/logo.png') }}" width="100" height="100" alt="RTS Logo"/></div>
                <div class="text-muted small">RTS Complaint</div>
            </div>
        </a>
    </div>

    <div class="p-3">
        <div class="text-uppercase text-muted small fw-semibold mb-3 sidebar-text">Navigation</div>

        <div class="nav flex-column gap-2">
            @foreach ($items as $item)
                @continue(!$item['visible'])

                @php
                    $isActive = $currentRoute === $item['route']
                        && (($item['query']['scope'] ?? null) === null || ($item['query']['scope'] ?? null) === $currentScope);
                @endphp

                <a
                    href="{{ route($item['route'], $item['query'] ?? []) }}"
                    class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $isActive ? 'active bg-primary text-white' : 'text-dark bg-light-subtle' }}"
                >
                    <i class="bx {{ $item['icon'] }} flex-shrink-0"></i>
                    <span class="sidebar-text">{{ $item['label'] }}</span>
                </a>
            @endforeach

            @if($isRts)
                @php
                    $isRtsNavActive = in_array($currentRoute, ['rts.services.index', 'rts.services.statistics', 'rts.services.department']);
                @endphp
                <a class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $isRtsNavActive ? 'active bg-primary text-white' : 'text-dark bg-light-subtle' }}"
                   data-bs-toggle="collapse"
                   href="#rtsServicesMenu"
                   role="button"
                   aria-expanded="{{ $isRtsNavActive ? 'true' : 'false' }}"
                   aria-controls="rtsServicesMenu">
                    <i class="bx bx-list-ul flex-shrink-0"></i>
                    <span class="sidebar-text">RTS Services</span>
                    <i class="bx bx-chevron-down ms-auto"></i>
                </a>
                <div class="collapse ms-3 {{ $isRtsNavActive ? 'show' : '' }}" id="rtsServicesMenu">
                    <a href="{{ route('rts.services.index') }}" class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $currentRoute === 'rts.services.index' ? 'active bg-primary text-white' : 'text-dark bg-light-subtle' }}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="sidebar-text">Services</span>
                    </a>
                    <a href="{{ route('rts.services.statistics') }}" class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $currentRoute === 'rts.services.statistics' ? 'active bg-primary text-white' : 'text-dark bg-light-subtle' }}">
                        <i class="bx bx-stats"></i>
                        <span class="sidebar-text">Statistics</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</aside>

<!-- Mobile Bottom Navigation -->
<div class="d-lg-none fixed-bottom bg-white border-top shadow-lg" id="mobileNav">
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-12">
                <div class="d-flex justify-content-around align-items-center py-2">
                    <a href="{{ route('complaint.dashboard') }}" class="text-decoration-none text-center p-2 {{ $currentRoute === 'complaint.dashboard' ? 'text-primary' : 'text-muted' }}">
                        <i class="bx bx-grid-alt d-block fs-5"></i>
                        <small class="d-block mt-1" style="font-size: 0.7rem;">Dashboard</small>
                    </a>

                    @can('create', \Modules\Complaint\Models\Complaint::class)
                        <a href="{{ route('citizen.complaints.create') }}" class="text-decoration-none text-center p-2 {{ $currentRoute === 'citizen.complaints.create' ? 'text-primary' : 'text-muted' }}">
                            <i class="bx bx-message-square-add d-block fs-5"></i>
                            <small class="d-block mt-1" style="font-size: 0.7rem;">New</small>
                        </a>
                    @endcan

                    <a href="{{ route('complaints.index') }}" class="text-decoration-none text-center p-2 {{ $currentRoute === 'complaints.index' ? 'text-primary' : 'text-muted' }}">
                        <i class="bx bx-folder-open d-block fs-5"></i>
                        <small class="d-block mt-1" style="font-size: 0.7rem;">Complaints</small>
                    </a>

                    <!-- Mobile Menu Toggle -->
                    <button class="btn btn-link text-decoration-none text-center p-2 text-muted" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuCanvas" aria-controls="mobileMenuCanvas">
                        <i class="bx bx-menu d-block fs-5"></i>
                        <small class="d-block mt-1" style="font-size: 0.7rem;">Menu</small>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Menu Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenuCanvas" aria-labelledby="mobileMenuCanvasLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="mobileMenuCanvasLabel">
            <div class="d-flex align-items-center gap-2">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 36px; height: 36px; background: linear-gradient(135deg, #0c447c, #1d6ecf);">
                    RT
                </span>
                <span>RTS Complaint</span>
            </div>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="nav flex-column gap-2">
            @foreach ($items as $item)
                @continue(!$item['visible'])

                @php
                    $isActive = $currentRoute === $item['route']
                        && (($item['query']['scope'] ?? null) === null || ($item['query']['scope'] ?? null) === $currentScope);
                @endphp

                <a
                    href="{{ route($item['route'], $item['query'] ?? []) }}"
                    class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $isActive ? 'active bg-primary text-white' : 'text-dark bg-light-subtle' }}"
                    data-bs-dismiss="offcanvas"
                >
                    <i class="bx {{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach

            @if($isRts)
                @php
                    $isRtsNavActive = in_array($currentRoute, ['rts.services.index', 'rts.services.statistics', 'rts.services.department']);
                @endphp
                <a class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $isRtsNavActive ? 'active bg-primary text-white' : 'text-dark bg-light-subtle' }}"
                   data-bs-toggle="collapse"
                   href="#mobileRtsServicesMenu"
                   role="button"
                   aria-expanded="{{ $isRtsNavActive ? 'true' : 'false' }}"
                   aria-controls="mobileRtsServicesMenu"
                   data-bs-dismiss="offcanvas">
                    <i class="bx bx-list-ul"></i>
                    <span>RTS Services</span>
                    <i class="bx bx-chevron-down ms-auto"></i>
                </a>
                <div class="collapse ms-3 {{ $isRtsNavActive ? 'show' : '' }}" id="mobileRtsServicesMenu">
                    <a href="{{ route('rts.services.index') }}" class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $currentRoute === 'rts.services.index' ? 'active bg-primary text-white' : 'text-dark bg-light-subtle' }}" data-bs-dismiss="offcanvas">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span>Services</span>
                    </a>
                    <a href="{{ route('rts.services.statistics') }}" class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $currentRoute === 'rts.services.statistics' ? 'active bg-primary text-white' : 'text-dark bg-light-subtle' }}" data-bs-dismiss="offcanvas">
                        <i class="bx bx-stats"></i>
                        <span>Statistics</span>
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-auto pt-3 border-top">
            @auth
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ trim((auth()->user()->firstname ?? '') . ' ' . (auth()->user()->lastname ?? '')) ?: (auth()->user()->name ?? auth()->user()->email) }}</div>
                        <div class="text-muted small">{{ auth()->user()->role }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</div>
