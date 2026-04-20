@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Str;

    $currentRoute = Route::currentRouteName();

    // Define route groups dynamically
    $menuRoutes = [
        'dashboard_group' => [
            'dashboard.',
            'dashboard.dc',
            'dashboard.dmo',
            'dashboard.rtcp',
            'dashboard.fazal-manan',
            'dashboard.arms-licence',
            'dashboard.arms-licence-detail',
            'dashboard.arms-licence-forward',
        ],
        'administration' => [
            'app.users.',
            'app.roles.',
            'app.departments.',
            'app.services.',
            'app.officers.',
            'app.citizens.',
        ],
        'location' => [
            'app.provinces.',
            'app.districts.',
            'app.divisions.',
            'app.tehsils.',
            'app.union-councils.',
            'app.villages.',
        ],
        'reports_group' => [
            'report.',
            'report.dc',
            'report.dmo',
            'report.kprts',
            'app.reports.',
            'app.analytics.',
        ],
    ];

    // Determine active parent menu
    $activeMenu = '';
    foreach ($menuRoutes as $menu => $routes) {
        foreach ($routes as $routePrefix) {
            if (Str::startsWith($currentRoute, $routePrefix)) {
                $activeMenu = $menu;
                break 2;
            }
        }
    }
@endphp

<ul class="menu-inner py-1">
    
    <!-- ============================================ -->
    <!-- DASHBOARD DROPDOWN (Group 1) -->
    <!-- ============================================ -->
    <li class="menu-item {{ $activeMenu === 'dashboard_group' ? 'open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-dashboard"></i>
            <div data-i18n="Dashboards">Dashboards</div>
        </a>
        <ul class="menu-sub">
            @if (Route::has('dashboard'))
                <li class="menu-item {{ $currentRoute === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <div data-i18n="Main Dashboard">Main Dashboard</div>
                    </a>
                </li>
            @endif

            @if (Route::has('dashboard.dc'))
                <li class="menu-item {{ $currentRoute === 'dashboard.dc' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.dc') }}" class="menu-link">
                        <div data-i18n="DC Dashboard">DC Dashboard</div>
                    </a>
                </li>
            @endif

            @if (Route::has('dashboard.dmo'))
                <li class="menu-item {{ $currentRoute === 'dashboard.dmo' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.dmo') }}" class="menu-link">
                        <div data-i18n="DMO Dashboard">DMO Dashboard</div>
                    </a>
                </li>
            @endif

            @if (Route::has('dashboard.rtcp'))
                <li class="menu-item {{ $currentRoute === 'dashboard.rtcp' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.rtcp') }}" class="menu-link">
                        <div data-i18n="RTCP Dashboard">RTCP Dashboard</div>
                    </a>
                </li>
            @endif

            @if (Route::has('dashboard.fazal-manan'))
                <li class="menu-item {{ $currentRoute === 'dashboard.fazal-manan' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.fazal-manan') }}" class="menu-link">
                        <div data-i18n="Fazal Manan Dashboard">Fazal Manan Dashboard</div>
                    </a>
                </li>
            @endif

            @if (Route::has('dashboard.arms-licence'))
                <li class="menu-item {{ $currentRoute === 'dashboard.arms-licence' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.arms-licence') }}" class="menu-link">
                        <div data-i18n="Arms License Dashboard">Arms License Dashboard</div>
                    </a>
                </li>
            @endif

            @if (Route::has('dashboard.arms-licence-detail'))
                <li class="menu-item {{ $currentRoute === 'dashboard.arms-licence-detail' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.arms-licence-detail') }}" class="menu-link">
                        <div data-i18n="Arms License Detail">Arms License Detail</div>
                    </a>
                </li>
            @endif

            @if (Route::has('dashboard.arms-licence-forward'))
                <li class="menu-item {{ $currentRoute === 'dashboard.arms-licence-forward' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.arms-licence-forward') }}" class="menu-link">
                        <div data-i18n="Arms License Forward">Arms License Forward</div>
                    </a>
                </li>
            @endif
        </ul>
    </li>

    <!-- ============================================ -->
    <!-- ADMINISTRATION DROPDOWN -->
    <!-- ============================================ -->
    @canany(['user-list', 'role-list', 'department-list', 'service-list', 'officer-list', 'citizen-list'])
        <li class="menu-item {{ $activeMenu === 'administration' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Administration">Administration</div>
            </a>
            <ul class="menu-sub">
                {{-- Users --}}
                @can('user-list')
                    @if (Route::has('app.users.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.users.') ? 'active' : '' }}">
                            <a href="{{ route('app.users.index') }}" class="menu-link">
                                <div data-i18n="User Listings">User Listings</div>
                            </a>
                        </li>
                    @endif
                @endcan

                {{-- Roles --}}
                @can('role-list')
                    @if (Route::has('app.roles.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.roles.') ? 'active' : '' }}">
                            <a href="{{ route('app.roles.index') }}" class="menu-link">
                                <div data-i18n="Roles Listings">Roles Listings</div>
                            </a>
                        </li>
                    @endif
                @endcan

                {{-- Departments --}}
                @can('department-list')
                    @if (Route::has('app.departments.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.departments.') ? 'active' : '' }}">
                            <a href="{{ route('app.departments.index') }}" class="menu-link">
                                <div data-i18n="Department Listings">Department Listings</div>
                            </a>
                        </li>
                    @endif
                @endcan

                {{-- Services --}}
                @can('service-list')
                    @if (Route::has('app.services.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.services.') ? 'active' : '' }}">
                            <a href="{{ route('app.services.index') }}" class="menu-link">
                                <div data-i18n="Service Listings">Service Listings</div>
                            </a>
                        </li>
                    @endif
                @endcan

                {{-- Officers --}}
                @can('officer-list')
                    @if (Route::has('app.officers.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.officers.') ? 'active' : '' }}">
                            <a href="{{ route('app.officers.index') }}" class="menu-link">
                                <div data-i18n="Officer Listings">Officer Listings</div>
                            </a>
                        </li>
                    @endif
                @endcan

                {{-- Citizens --}}
                @can('citizen-list')
                    @if (Route::has('app.citizens.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.citizens.') ? 'active' : '' }}">
                            <a href="{{ route('app.citizens.index') }}" class="menu-link">
                                <div data-i18n="Citizen Listings">Citizen Listings</div>
                            </a>
                        </li>
                    @endif
                @endcan
            </ul>
        </li>
    @endcanany

    <!-- ============================================ -->
    <!-- LOCATION MANAGEMENT DROPDOWN -->
    <!-- ============================================ -->
    @canany(['province-list', 'division-list', 'district-list', 'tehsil-list', 'union-council-list', 'village-list'])
        <li class="menu-item {{ $activeMenu === 'location' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-map"></i>
                <div data-i18n="Location Management">Location Management</div>
            </a>
            <ul class="menu-sub">
                @can('province-list')
                    @if (Route::has('app.provinces.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.provinces.') ? 'active' : '' }}">
                            <a href="{{ route('app.provinces.index') }}" class="menu-link">
                                <div data-i18n="Provinces">Provinces</div>
                            </a>
                        </li>
                    @endif
                @endcan

                @can('division-list')
                    @if (Route::has('app.divisions.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.divisions.') ? 'active' : '' }}">
                            <a href="{{ route('app.divisions.index') }}" class="menu-link">
                                <div data-i18n="Divisions">Divisions</div>
                            </a>
                        </li>
                    @endif
                @endcan

                @can('district-list')
                    @if (Route::has('app.districts.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.districts.') ? 'active' : '' }}">
                            <a href="{{ route('app.districts.index') }}" class="menu-link">
                                <div data-i18n="Districts">Districts</div>
                            </a>
                        </li>
                    @endif
                @endcan

                @can('tehsil-list')
                    @if (Route::has('app.tehsils.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.tehsils.') ? 'active' : '' }}">
                            <a href="{{ route('app.tehsils.index') }}" class="menu-link">
                                <div data-i18n="Tehsils">Tehsils</div>
                            </a>
                        </li>
                    @endif
                @endcan

                @can('union-council-list')
                    @if (Route::has('app.union-councils.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.union-councils.') ? 'active' : '' }}">
                            <a href="{{ route('app.union-councils.index') }}" class="menu-link">
                                <div data-i18n="Union Councils">Union Councils</div>
                            </a>
                        </li>
                    @endif
                @endcan

                @can('village-list')
                    @if (Route::has('app.villages.index'))
                        <li class="menu-item {{ Str::startsWith($currentRoute, 'app.villages.') ? 'active' : '' }}">
                            <a href="{{ route('app.villages.index') }}" class="menu-link">
                                <div data-i18n="Villages">Villages</div>
                            </a>
                        </li>
                    @endif
                @endcan
            </ul>
        </li>
    @endcanany

    <!-- ============================================ -->
    <!-- REPORTS DROPDOWN -->
    <!-- ============================================ -->
    <li class="menu-item {{ $activeMenu === 'reports_group' ? 'open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-line-chart"></i>
            <div data-i18n="Reports">Reports</div>
        </a>
        <ul class="menu-sub">
            @if (Route::has('report.dc'))
                <li class="menu-item {{ $currentRoute === 'report.dc' ? 'active' : '' }}">
                    <a href="{{ route('report.dc') }}" class="menu-link">
                        <div data-i18n="DC Report">DC Report</div>
                    </a>
                </li>
            @endif

            @if (Route::has('report.dmo'))
                <li class="menu-item {{ $currentRoute === 'report.dmo' ? 'active' : '' }}">
                    <a href="{{ route('report.dmo') }}" class="menu-link">
                        <div data-i18n="DMO Report">DMO Report</div>
                    </a>
                </li>
            @endif

            @if (Route::has('report.kprts'))
                <li class="menu-item {{ $currentRoute === 'report.kprts' ? 'active' : '' }}">
                    <a href="{{ route('report.kprts') }}" class="menu-link">
                        <div data-i18n="KP-RTPS Report">KP-RTPS Report</div>
                    </a>
                </li>
            @endif

            @if (Route::has('app.reports.index'))
                <li class="menu-item {{ Str::startsWith($currentRoute, 'app.reports.') ? 'active' : '' }}">
                    <a href="{{ route('app.reports.index') }}" class="menu-link">
                        <div data-i18n="All Reports">All Reports</div>
                    </a>
                </li>
            @endif

            @if (Route::has('app.analytics.index'))
                <li class="menu-item {{ Str::startsWith($currentRoute, 'app.analytics.') ? 'active' : '' }}">
                    <a href="{{ route('app.analytics.index') }}" class="menu-link">
                        <div data-i18n="Analytics">Analytics</div>
                    </a>
                </li>
            @endif
        </ul>
    </li>

    <!-- Logout Section -->
    <div class="flex-grow-1"></div>
    <hr style="border-top: 1px solid #f1f1f1; background-color: #f1f1f1; opacity: 1; width: 87%; margin: 10px auto;">
    <li class="menu-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="btn w-100 d-flex align-items-center justify-content-center text-danger fw-bold"
                style="background: white; border-radius: 5px; padding: 10px;">
                <i class="bx bx-exit me-2"></i> Logout
            </button>
        </form>
    </li>
</ul>