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

<aside class="col-lg-2 px-0 bg-white border-end min-vh-100">
    <div class="p-3 border-bottom">
        <a href="{{ route('complaint.dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 42px; height: 42px; background: linear-gradient(135deg, #0c447c, #1d6ecf);">
                RT
            </span>
            <div>
                <div class="fw-bold text-dark">RTS Complaint</div>
                <div class="text-muted small">Workflow Console</div>
            </div>
        </a>
    </div>

    <div class="p-3">
        <div class="text-uppercase text-muted small fw-semibold mb-3">Navigation</div>

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
                    <i class="bx {{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</aside>
