@extends('layouts.layout')
@section('content')
    <!-- Bootstrap 5 CSS + Icons (ensuring mobile-first) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #185FA5;
            --primary-dark: #0C447C;
            --success: #1D9E75;
            --danger: #E24B4A;
            --warning: #EF9F27;
            --bg: #f0f4f8;
            --card-bg: #ffffff;
            --border: #dde3ec;
            --text: #1a2332;
            --muted: #64748b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'IBM Plex Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
        }

        .wrap {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px 20px;
        }

        /* Page Title */
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .page-title i { color: var(--primary); }

        /* Stat Cards - fully responsive grid */
        .stat-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 18px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            transition: box-shadow 0.2s, transform 0.2s;
            height: 100%;
        }
        .stat-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.09); transform: translateY(-2px); }

        .stat-info .label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 4px;
            white-space: nowrap;
        }
        .stat-info .value {
            font-size: 1.7rem;
            font-weight: 700;
            line-height: 1.1;
            color: var(--text);
            margin-bottom: 6px;
        }
        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 20px;
        }
        .badge-up   { background: #d1fae5; color: #059669; }
        .badge-down { background: #fee2e2; color: #dc2626; }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
        }
        .icon-purple { background: #ede9fe; color: #7c3aed; }
        .icon-amber  { background: #fef3c7; color: #d97706; }
        .icon-teal   { background: #d1fae5; color: #059669; }
        .icon-coral  { background: #fee2e2; color: #dc2626; }

        /* Filter row - responsive wrap */
        .filter-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-wrap {
            position: relative;
            flex: 2;
            min-width: 180px;
        }
        .search-wrap .fas {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted); pointer-events: none;
        }
        .search-wrap input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.875rem;
            background: #fff;
        }
        .search-wrap input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(24,95,165,.1); }

        .filter-row select {
            padding: 8px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.8rem;
            background: #fff;
            min-width: 120px;
            flex: 1 0 auto;
        }
        .filter-row button {
            white-space: nowrap;
            padding: 8px 16px;
            font-size: 0.8rem;
        }
        
        /* Table Card */
        .table-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow-x: auto;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }

        .table-head-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 10px;
        }
        .table-head-row .title {
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text);
        }
        .table-head-row .title i { color: var(--primary); }

        /* Responsive table: horizontal scroll on small screens */
        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            margin-bottom: 0;
            min-width: 700px;
        }
        .table thead tr th {
            background: #f8fafc;
            padding: 10px 12px;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .6px;
            border-bottom: 2px solid var(--border) !important;
            white-space: nowrap;
        }
        .table tbody tr td {
            padding: 10px 12px;
            font-size: 0.8rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9 !important;
        }
        .table tbody tr:last-child td { border-bottom: none !important; }
        .table tbody tr:hover { background: #f8fafc; }

        /* Complaint number */
        .comp-id {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
        }

        /* Service badge */
        .svc-badge {
            display: inline-block;
            padding: 3px 8px;
            background: #ede9fe;
            color: #7c3aed;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Status badges */
        .s-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .s-pending      { background: #fef3c7; color: #d97706; }
        .s-under_review { background: #e0e7ff; color: #4338ca; }
        .s-in_progress  { background: #dbeafe; color: #2563eb; }
        .s-resolved     { background: #d1fae5; color: #059669; }
        .s-rejected     { background: #fee2e2; color: #dc2626; }
        .s-appealed     { background: #fce7f3; color: #db2777; }

        /* Action buttons - responsive block/stack on mobile? But we keep inline but flexible */
        .btn-view-sm, .btn-fwd-sm {
            display: inline-block;
            padding: 4px 10px;
            border: none;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
            text-align: center;
            width: auto;
        }
        .btn-view-sm { background: var(--primary); color: #fff; }
        .btn-view-sm:hover { background: var(--primary-dark); }
        .btn-fwd-sm { background: var(--success); color: #fff; }
        .btn-fwd-sm:hover { background: #0f7a5a; }
        
        /* Action wrapper for small screens to stack vertically if needed, but we keep inline */
        .action-btns {
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: flex-end;
        }
        @media (max-width: 640px) {
            .action-btns {
                flex-direction: row;
                justify-content: flex-end;
                gap: 8px;
            }
            .btn-view-sm, .btn-fwd-sm {
                padding: 3px 8px;
                font-size: 0.65rem;
            }
        }

        /* Pagination row responsive */
        .pagination-row {
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.75rem;
            color: var(--muted);
        }

        /* Modal adjustments */
        .modal-header { background: var(--primary); color: #fff; }
        .modal-header .btn-close { filter: invert(1); }
        .detail-label { font-weight: 600; color: var(--muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.3px; }
        .detail-val   { color: var(--text); font-size: 0.8rem; word-break: break-word; }

        /* Extra small screens */
        @media (max-width: 576px) {
            .wrap { padding: 16px 12px; }
            .page-title { font-size: 1.3rem; margin-bottom: 16px; }
            .stat-info .value { font-size: 1.4rem; }
            .stat-icon { width: 40px; height: 40px; font-size: 1rem; }
            .stat-card { padding: 12px; }
            .filter-row select, .filter-row .search-wrap { width: 100%; flex: auto; }
            .filter-row { flex-direction: column; align-items: stretch; }
            .filter-row button { width: 100%; }
            .table-head-row .title { font-size: 0.9rem; }
            .pagination-row { flex-direction: column; align-items: center; text-align: center; }
        }
        
        /* Ensure modal content fits on mobile */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 1rem;
            }
            .detail-label, .detail-val {
                font-size: 0.75rem;
            }
        }
        
        /* Card inner tables on modal */
        .info-card-table td {
            padding: 6px 4px;
        }
    </style>
</head>
<body>

<div class="wrap">
    <!-- Page Title -->
    <div class="page-title">
        <i class="fas fa-chart-line"></i>
        Dashboard — DMO Peshawar
    </div>

    <!-- Stat Cards (Responsive row) -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-info">
                    <div class="label"><i class="fas fa-file-alt me-1"></i>Total Complaints</div>
                    <div class="value" id="totalComplaints">0</div>
                    <span class="stat-badge badge-up"><i class="fas fa-arrow-up"></i> 8.5% this month</span>
                </div>
                <div class="stat-icon icon-purple"><i class="fas fa-file-alt"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-info">
                    <div class="label"><i class="fas fa-clock me-1"></i>Pending</div>
                    <div class="value" id="pendingComplaints">0</div>
                    <span class="stat-badge badge-up"><i class="fas fa-arrow-up"></i> 1.3% this week</span>
                </div>
                <div class="stat-icon icon-amber"><i class="fas fa-hourglass-half"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-info">
                    <div class="label"><i class="fas fa-check-circle me-1"></i>Resolved</div>
                    <div class="value" id="resolvedComplaints">0</div>
                    <span class="stat-badge badge-up"><i class="fas fa-arrow-up"></i> 4.3% this week</span>
                </div>
                <div class="stat-icon icon-teal"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-info">
                    <div class="label"><i class="fas fa-spinner me-1"></i>In Progress</div>
                    <div class="value" id="inProgressComplaints">0</div>
                    <span class="stat-badge badge-up"><i class="fas fa-arrow-up"></i> 1.8% yesterday</span>
                </div>
                <div class="stat-icon icon-coral"><i class="fas fa-chart-bar"></i></div>
            </div>
        </div>
    </div>

    <!-- Filters (fully responsive) -->
    <div class="filter-row">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search by ID, name, service…">
        </div>
        <select id="statusFilter">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="under_review">Under Review</option>
            <option value="in_progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="rejected">Rejected</option>
            <option value="appealed">Appealed</option>
        </select>
        <select id="departmentFilter">
            <option value="">All Departments</option>
            <option value="WASA">WASA</option>
            <option value="Municipal Corporation">Municipal Corporation</option>
            <option value="LESCO">LESCO</option>
            <option value="Police">Police</option>
        </select>
        <select id="monthSelect">
            <option value="">All Months</option>
            <option value="1">January</option><option value="2">February</option>
            <option value="3">March</option><option value="4">April</option>
            <option value="5">May</option><option value="6">June</option>
            <option value="7">July</option><option value="8">August</option>
            <option value="9">September</option><option value="10">October</option>
            <option value="11">November</option><option value="12">December</option>
        </select>
        <button class="btn btn-primary btn-sm px-3" onclick="refreshData()">
            <i class="fas fa-sync-alt me-1"></i>Refresh
        </button>
    </div>

    <!-- Table Card with horizontal scroll wrapper -->
    <div class="table-card">
        <div class="table-head-row">
            <div class="title"><i class="fas fa-list-alt"></i> Complaint Details</div>
            <span class="text-muted" style="font-size:.75rem;">
                Total: <strong id="totalCount">0</strong> complaints
            </span>
        </div>

        <div class="table-responsive-custom">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="fas fa-hashtag me-1"></i>Application ID</th>
                        <th><i class="fas fa-user me-1"></i>Complainant</th>
                        <th><i class="fas fa-concierge-bell me-1"></i>Service</th>
                        <th><i class="fas fa-building me-1"></i>Department</th>
                        <th><i class="fas fa-tag me-1"></i>Category</th>
                        <th><i class="fas fa-circle-dot me-1"></i>Status</th>
                        <th><i class="fas fa-calendar-alt me-1"></i>Date</th>
                        <th class="text-end"><i class="fas fa-cog me-1"></i>Action</th>
                    </tr>
                </thead>
                <tbody id="complaints-body">
                </tbody>
            </table>
        </div>

        <div class="pagination-row">
            <div id="showingInfo"></div>
            <nav>
                <ul class="pagination pagination-sm mb-0" id="pagination"></ul>
            </nav>
        </div>
    </div>
</div><!-- /wrap -->

<!-- Detail Modal -->
<div class="modal fade" id="complaintModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-alt me-2"></i>Complaint Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="complaintModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="forwardFromModal">
                    <i class="fas fa-share me-1"></i>Forward to Department
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999;">
    <div id="liveToast" class="toast" data-bs-autohide="true" data-bs-delay="3000">
        <div class="toast-header" id="toastHeader">
            <i class="fas fa-bell me-2"></i>
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toastMessage"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ============================================================
   DATA (unchanged - exactly as provided)
============================================================ */
const allComplaints = [
    {
        id: 1,
        complaint_number: 'CMP2024120001',
        complainant: { name: 'Muhammad Ali', cnic_number: '12345-6789012-3', contact_number: '03001234567', email: 'ali@example.com', postal_address: 'House #123, Main Street, Lahore' },
        service: { name: 'Water Supply Connection' },
        department: { name: 'WASA' },
        category: 'New Connection',
        title: 'New water connection application',
        description: 'Applied for new water connection 2 weeks ago but no response yet.',
        address_location: '123 Main Street, Lahore',
        status: 'pending', priority: 'high',
        submitted_at: '2024-12-20 10:30:00', created_at: '2024-12-20 10:30:00',
        admin_remarks: null
    },
    {
        id: 2,
        complaint_number: 'CMP2024120002',
        complainant: { name: 'Sadia Khan', cnic_number: '12345-6789012-4', contact_number: '03111234567', email: 'sadia@example.com', postal_address: 'House #456, Canal Road, Lahore' },
        service: { name: 'Birth Certificate' },
        department: { name: 'Municipal Corporation' },
        category: 'Document Missing',
        title: 'Birth certificate not issued',
        description: 'Applied for birth certificate online, status shows processing for 3 weeks.',
        address_location: '456 Canal Road, Lahore',
        status: 'in_progress', priority: 'medium',
        submitted_at: '2024-12-18 14:45:00', created_at: '2024-12-18 14:45:00',
        admin_remarks: 'Under review by municipal committee'
    },
    {
        id: 3,
        complaint_number: 'CMP2024120003',
        complainant: { name: 'Ahmed Raza', cnic_number: '12345-6789012-5', contact_number: '03214567890', email: 'ahmed@example.com', postal_address: 'Apartment #789, Gulberg, Lahore' },
        service: { name: 'Electricity Bill' },
        department: { name: 'LESCO' },
        category: 'Overbilling',
        title: 'Excessive electricity bill',
        description: 'Bill amount is 3 times higher than normal usage. Meter reading seems incorrect.',
        address_location: '789 Gulberg, Lahore',
        status: 'under_review', priority: 'urgent',
        submitted_at: '2024-12-15 09:15:00', created_at: '2024-12-15 09:15:00',
        admin_remarks: 'Meter reading verification requested'
    },
    {
        id: 4,
        complaint_number: 'CMP2024120004',
        complainant: { name: 'Fatima Akhtar', cnic_number: '12345-6789012-6', contact_number: '03339876543', email: 'fatima@example.com', postal_address: 'Street #5, DHA Phase 2, Lahore' },
        service: { name: 'Road Repair' },
        department: { name: 'Municipal Corporation' },
        category: 'Infrastructure',
        title: 'Road damage near school',
        description: 'Road is severely damaged near children school, causing safety issues.',
        address_location: 'DHA Phase 2, Lahore',
        status: 'resolved', priority: 'high',
        submitted_at: '2024-12-10 11:20:00', created_at: '2024-12-10 11:20:00',
        admin_remarks: 'Road repair completed on 25th December'
    },
    {
        id: 5,
        complaint_number: 'CMP2024120005',
        complainant: { name: 'Imran Shah', cnic_number: '12345-6789012-7', contact_number: '03455678901', email: 'imran@example.com', postal_address: 'House #12, Model Town, Lahore' },
        service: { name: 'Police Complaint' },
        department: { name: 'Police' },
        category: 'Theft Report',
        title: 'Mobile phone stolen',
        description: 'Mobile phone stolen from bus stop. CCTV footage available.',
        address_location: 'Model Town Bus Stop, Lahore',
        status: 'rejected', priority: 'high',
        submitted_at: '2024-12-05 16:30:00', created_at: '2024-12-05 16:30:00',
        admin_remarks: 'Insufficient evidence provided'
    },
    {
        id: 6,
        complaint_number: 'CMP2024120006',
        complainant: { name: 'Nadia Javed', cnic_number: '12345-6789012-8', contact_number: '03007654321', email: 'nadia@example.com', postal_address: 'Street #8, Johar Town, Lahore' },
        service: { name: 'Sewerage' },
        department: { name: 'WASA' },
        category: 'Blockage',
        title: 'Sewerage line blockage',
        description: 'Sewerage line blocked since 5 days, dirty water spreading on street.',
        address_location: 'Johar Town, Lahore',
        status: 'in_progress', priority: 'urgent',
        submitted_at: '2024-12-22 08:45:00', created_at: '2024-12-22 08:45:00',
        admin_remarks: 'Team dispatched for cleaning'
    },
    {
        id: 7,
        complaint_number: 'CMP2024120007',
        complainant: { name: 'Hassan Tariq', cnic_number: '12345-6789012-9', contact_number: '03123456789', email: 'hassan@example.com', postal_address: 'House #34, Garden Town, Lahore' },
        service: { name: 'Domicile' },
        department: { name: 'Municipal Corporation' },
        category: 'Late Delivery',
        title: 'Domicile certificate delay',
        description: 'Applied for domicile certificate 1 month ago, still not received.',
        address_location: 'Garden Town, Lahore',
        status: 'appealed', priority: 'medium',
        submitted_at: '2024-12-01 13:00:00', created_at: '2024-12-01 13:00:00',
        admin_remarks: 'Appeal under consideration'
    },
    {
        id: 8,
        complaint_number: 'CMP2024120008',
        complainant: { name: 'Zainab Malik', cnic_number: '12345-6789013-0', contact_number: '03349876543', email: 'zainab@example.com', postal_address: 'Apartment #22, Bahria Town, Lahore' },
        service: { name: 'Property Transfer' },
        department: { name: 'Municipal Corporation' },
        category: 'Document Issue',
        title: 'Property transfer delay',
        description: 'Property transfer application pending for 2 months.',
        address_location: 'Bahria Town, Lahore',
        status: 'pending', priority: 'medium',
        submitted_at: '2024-12-19 15:20:00', created_at: '2024-12-19 15:20:00',
        admin_remarks: null
    },
    {
        id: 9,
        complaint_number: 'CMP2024120009',
        complainant: { name: 'Omar Farooq', cnic_number: '12345-6789013-1', contact_number: '03014567890', email: 'omar@example.com', postal_address: 'Street #12, Iqbal Town, Lahore' },
        service: { name: 'Garbage Collection' },
        department: { name: 'Municipal Corporation' },
        category: 'No Service',
        title: 'No garbage collection for 1 week',
        description: 'Garbage not collected from our area since last week, creating health hazard.',
        address_location: 'Iqbal Town, Lahore',
        status: 'resolved', priority: 'high',
        submitted_at: '2024-12-14 10:00:00', created_at: '2024-12-14 10:00:00',
        admin_remarks: 'Service restored, extra collection done'
    },
    {
        id: 10,
        complaint_number: 'CMP2024120010',
        complainant: { name: 'Sana Mirza', cnic_number: '12345-6789013-2', contact_number: '03129876543', email: 'sana@example.com', postal_address: 'House #78, DHA, Lahore' },
        service: { name: 'Power Outage' },
        department: { name: 'LESCO' },
        category: 'No Service',
        title: 'Frequent power outages',
        description: 'Area experiencing power outages 4-5 times daily for 30-40 minutes each.',
        address_location: 'DHA Phase 1, Lahore',
        status: 'under_review', priority: 'high',
        submitted_at: '2024-12-21 18:30:00', created_at: '2024-12-21 18:30:00',
        admin_remarks: 'Load shedding schedule being reviewed'
    }
];

/* ──── Global state ──── */
let currentPage = 1;
const PER_PAGE = 8;
let filtered = [...allComplaints];

const STATUS_META = {
    pending:      { cls: 's-pending',      icon: 'fa-clock',        label: 'Pending' },
    under_review: { cls: 's-under_review', icon: 'fa-magnifying-glass', label: 'Under Review' },
    in_progress:  { cls: 's-in_progress',  icon: 'fa-spinner',      label: 'In Progress' },
    resolved:     { cls: 's-resolved',     icon: 'fa-check-circle', label: 'Resolved' },
    rejected:     { cls: 's-rejected',     icon: 'fa-times-circle', label: 'Rejected' },
    appealed:     { cls: 's-appealed',     icon: 'fa-gavel',        label: 'Appealed' }
};

function statusBadge(s) {
    const m = STATUS_META[s] || STATUS_META.pending;
    return `<span class="s-badge ${m.cls}"><i class="fas ${m.icon}"></i> ${m.label}</span>`;
}

function fmtDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleString('en-PK', { day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit' });
}

function priorityBadge(p) {
    const map = { urgent: 'danger', high: 'warning text-dark', medium: 'info text-dark', low: 'secondary' };
    return `<span class="badge bg-${map[p] || 'secondary'}">${p}</span>`;
}

function updateStats() {
    document.getElementById('totalComplaints').textContent    = filtered.length;
    document.getElementById('pendingComplaints').textContent  = filtered.filter(c => c.status === 'pending').length;
    document.getElementById('resolvedComplaints').textContent = filtered.filter(c => c.status === 'resolved').length;
    document.getElementById('inProgressComplaints').textContent = filtered.filter(c => c.status === 'in_progress').length;
}

function applyFilters() {
    const q    = document.getElementById('searchInput').value.toLowerCase();
    const stat = document.getElementById('statusFilter').value;
    const dept = document.getElementById('departmentFilter').value;
    const mon  = document.getElementById('monthSelect').value;

    filtered = allComplaints.filter(c => {
        const matchQ   = !q || c.complaint_number.toLowerCase().includes(q)
                            || c.complainant.name.toLowerCase().includes(q)
                            || c.service.name.toLowerCase().includes(q)
                            || c.category.toLowerCase().includes(q);
        const matchS   = !stat || c.status === stat;
        const matchD   = !dept || c.department.name === dept;
        const matchM   = !mon  || (new Date(c.created_at).getMonth() + 1).toString() === mon;
        return matchQ && matchS && matchD && matchM;
    });

    currentPage = 1;
    updateStats();
    renderTable();
}

function renderTable() {
    const tbody = document.getElementById('complaints-body');
    document.getElementById('totalCount').textContent = filtered.length;

    if (!filtered.length) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-5 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>No complaints found. Try adjusting your filters.</td></tr>`;
        document.getElementById('showingInfo').textContent = 'Showing 0 complaints';
        document.getElementById('pagination').innerHTML = '';
        return;
    }

    const start  = (currentPage - 1) * PER_PAGE;
    const pageItems = filtered.slice(start, start + PER_PAGE);

    tbody.innerHTML = pageItems.map((c, i) => {
        const rowNum = start + i + 1;
        return `
        <tr>
            <td class="text-muted" style="font-size:.7rem;">${rowNum}</td>
            <td><span class="comp-id"><i class="fas fa-ticket-alt me-1"></i>${c.complaint_number}</span></td>
            <td><div style="font-weight:600;">${c.complainant.name}</div><small class="text-muted">${c.complainant.cnic_number}</small></td>
            <td><span class="svc-badge">${c.service.name}</span></td>
            <td>${c.department.name}</td>
            <td>${c.category}</td>
            <td>${statusBadge(c.status)}</td>
            <td style="white-space:nowrap;color:var(--muted);"><i class="far fa-calendar-alt me-1"></i>${fmtDate(c.created_at)}</td>
            <td class="text-end"><div class="action-btns"><button class="btn-view-sm" onclick="viewDetails(${c.id})"><i class="fas fa-eye me-1"></i>View</button><button class="btn-fwd-sm" onclick="forwardComplaint(${c.id})"><i class="fas fa-share me-1"></i>Forward</button></div></td>
        </tr>`;
    }).join('');

    const end = Math.min(start + PER_PAGE, filtered.length);
    document.getElementById('showingInfo').textContent = `Showing ${start + 1}–${end} of ${filtered.length} complaints`;
    renderPagination();
}

function renderPagination() {
    const total = Math.ceil(filtered.length / PER_PAGE);
    const ul = document.getElementById('pagination');
    if (total <= 1) { ul.innerHTML = ''; return; }

    const btn = (page, label, disabled, active) =>
        `<li class="page-item ${disabled?'disabled':''} ${active?'active':''}"><a class="page-link" href="#" onclick="goPage(${page});return false;">${label}</a></li>`;

    let html = btn(currentPage - 1, '&laquo;', currentPage === 1, false);
    let s = Math.max(1, currentPage - 2);
    let e = Math.min(total, s + 4);
    if (s > 1) { html += btn(1, '1', false, false); if (s > 2) html += `<li class="page-item disabled"><span class="page-link">…</span></li>`; }
    for (let p = s; p <= e; p++) html += btn(p, p, false, p === currentPage);
    if (e < total) { if (e < total - 1) html += `<li class="page-item disabled"><span class="page-link">…</span></li>`; html += btn(total, total, false, false); }
    html += btn(currentPage + 1, '&raquo;', currentPage === total, false);
    ul.innerHTML = html;
}

function goPage(p) {
    const total = Math.ceil(filtered.length / PER_PAGE);
    if (p < 1 || p > total) return;
    currentPage = p;
    renderTable();
}

function viewDetails(id) {
    const c = allComplaints.find(x => x.id === id);
    if (!c) return;
    document.getElementById('complaintModalBody').innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 rounded-3 mb-2" style="background:#f8fafc; border:1px solid #e2e8f0;">
                    <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Complaint Info</h6>
                    <table class="table table-sm table-borderless mb-0"><tbody>
                        <tr><td class="detail-label">Complaint No.</td><td class="detail-val"><span class="comp-id">${c.complaint_number}</span></td></tr>
                        <tr><td class="detail-label">Service</td><td class="detail-val">${c.service.name}</td></tr>
                        <tr><td class="detail-label">Department</td><td class="detail-val">${c.department.name}</td></tr>
                        <tr><td class="detail-label">Category</td><td class="detail-val">${c.category}</td></tr>
                        <tr><td class="detail-label">Status</td><td class="detail-val">${statusBadge(c.status)}</td></tr>
                        <tr><td class="detail-label">Priority</td><td class="detail-val">${priorityBadge(c.priority)}</td></tr>
                        <tr><td class="detail-label">Submitted</td><td class="detail-val">${fmtDate(c.submitted_at)}</td></tr>
                    </tbody></table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded-3 mb-2" style="background:#f8fafc; border:1px solid #e2e8f0;">
                    <h6 class="fw-bold mb-3"><i class="fas fa-user me-2 text-primary"></i>Complainant Info</h6>
                    <table class="table table-sm table-borderless mb-0"><tbody>
                        <tr><td class="detail-label">Name</td><td class="detail-val">${c.complainant.name}</td></tr>
                        <tr><td class="detail-label">CNIC</td><td class="detail-val">${c.complainant.cnic_number}</td></tr>
                        <tr><td class="detail-label">Contact</td><td class="detail-val">${c.complainant.contact_number}</td></tr>
                        <tr><td class="detail-label">Email</td><td class="detail-val">${c.complainant.email}</td></tr>
                        <tr><td class="detail-label">Address</td><td class="detail-val">${c.complainant.postal_address}</td></tr>
                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="mt-2 p-3 rounded-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
            <h6 class="fw-bold mb-2"><i class="fas fa-file-text me-2 text-primary"></i>Complaint Details</h6>
            <p class="mb-1"><span class="detail-label">Title:</span> ${c.title}</p>
            <p class="mb-1"><span class="detail-label">Description:</span> ${c.description}</p>
            <p class="mb-0"><span class="detail-label">Location:</span> ${c.address_location}</p>
        </div>
        ${c.admin_remarks ? `<div class="alert alert-info mt-3 mb-0"><i class="fas fa-comment-dots me-2"></i><strong>Admin Remarks:</strong> ${c.admin_remarks}</div>` : ''}
    `;
    window._selectedId = id;
    new bootstrap.Modal(document.getElementById('complaintModal')).show();
}

function forwardComplaint(id) {
    const c = allComplaints.find(x => x.id === id);
    if (!c) return;
    showToast(`Complaint ${c.complaint_number} forwarded to ${c.department.name}.`, 'success');
}

function showToast(msg, type = 'success') {
    const header = document.getElementById('toastHeader');
    const body = document.getElementById('toastMessage');
    const colors = { success: '#1D9E75', error: '#E24B4A', info: '#185FA5' };
    header.style.background = colors[type] || colors.info;
    header.style.color = '#fff';
    body.textContent = msg;
    bootstrap.Toast.getOrCreateInstance(document.getElementById('liveToast')).show();
}

function refreshData() {
    applyFilters();
    showToast('Data refreshed successfully.', 'success');
}

// Event listeners
document.getElementById('searchInput').addEventListener('input', applyFilters);
document.getElementById('statusFilter').addEventListener('change', applyFilters);
document.getElementById('departmentFilter').addEventListener('change', applyFilters);
document.getElementById('monthSelect').addEventListener('change', applyFilters);
document.getElementById('forwardFromModal').addEventListener('click', () => {
    if (window._selectedId) {
        forwardComplaint(window._selectedId);
        bootstrap.Modal.getInstance(document.getElementById('complaintModal')).hide();
    }
});

applyFilters();
</script>
@endsection