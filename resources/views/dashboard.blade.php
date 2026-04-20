@extends('layouts.layout')
@section('content')
    <!-- Bootstrap 5 CSS + Icons -->
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

        /* Enhanced Filter Bar - Timeframe, Department, By Tehsil */
        .filter-panel {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 20px 22px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }
        .filter-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: flex-end;
        }
        .filter-item {
            flex: 1;
            min-width: 150px;
        }
        .filter-item label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .filter-item select, 
        .filter-item input {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 0.85rem;
            background: #fff;
            font-family: inherit;
            transition: 0.2s;
        }
        .filter-item select:focus, 
        .filter-item input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(24,95,165,.1);
        }
        .search-wrapper {
            position: relative;
        }
        .search-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.8rem;
        }
        .search-wrapper input {
            padding-left: 34px;
        }
        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }
        .btn-primary-sm {
            background: var(--primary);
            border: none;
            padding: 9px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.8rem;
            color: white;
            transition: 0.2s;
        }
        .btn-primary-sm:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        .btn-outline-sm {
            background: white;
            border: 1px solid var(--border);
            padding: 8px 18px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.8rem;
            color: var(--text);
            transition: 0.2s;
        }
        .btn-outline-sm:hover {
            background: var(--bg);
            border-color: var(--primary);
        }

        /* Table Card */
        .table-card {
            background: var(--card-bg);
            border-radius: 16px;
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

        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            margin-bottom: 0;
            min-width: 800px;
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

        .comp-id {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
        }
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

        .action-btns {
            display: flex;
            flex-direction: row;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }
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
        }
        .btn-view-sm { background: var(--primary); color: #fff; }
        .btn-view-sm:hover { background: var(--primary-dark); }
        .btn-fwd-sm { background: var(--success); color: #fff; }
        .btn-fwd-sm:hover { background: #0f7a5a; }

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

        .modal-header { background: var(--primary); color: #fff; }
        .modal-header .btn-close { filter: invert(1); }
        .detail-label { font-weight: 600; color: var(--muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.3px; }
        .detail-val   { color: var(--text); font-size: 0.8rem; word-break: break-word; }

        @media (max-width: 768px) {
            .wrap { padding: 16px 12px; }
            .page-title { font-size: 1.3rem; margin-bottom: 16px; }
            .filter-grid { flex-direction: column; gap: 12px; }
            .filter-item { width: 100%; }
            .filter-actions { width: 100%; justify-content: flex-end; }
            .action-btns { flex-direction: row; justify-content: flex-start; }
            .table-head-row .title { font-size: 0.9rem; }
            .pagination-row { flex-direction: column; align-items: center; text-align: center; }
            .modal-dialog { margin: 1rem; }
        }
        @media (max-width: 480px) {
            .action-btns { gap: 5px; }
            .btn-view-sm, .btn-fwd-sm { padding: 3px 8px; font-size: 0.65rem; }
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

    <!-- NEW FILTER SECTION: Timeframe, Department, By Tehsil (exactly as second screenshot) + search and additional filters -->
    <div class="filter-panel">
        <div class="filter-grid">
            <!-- Timeframe: All-time dropdown -->
            <div class="filter-item">
                <label><i class="far fa-clock me-1"></i> Timeframe</label>
                <select id="timeframeFilter">
                    <option value="all-time" selected>All-time</option>
                    <option value="last-month">Last Month</option>
                    <option value="last-week">Last Week</option>
                </select>
            </div>
            <!-- Department: All -->
            <div class="filter-item">
                <label><i class="fas fa-building me-1"></i> Department</label>
                <select id="deptFilterMain">
                    <option value="">All</option>
                    <option value="WASA">WASA</option>
                    <option value="Municipal Corporation">Municipal Corporation</option>
                    <option value="LESCO">LESCO</option>
                    <option value="Police">Police</option>
                </select>
            </div>
            <!-- By: Tehsil -->
            <div class="filter-item">
                <label><i class="fas fa-map-marker-alt me-1"></i> By: Tehsil</label>
                <select id="tehsilFilter">
                    <option value="">All Tehsils</option>
                    <option value="Peshawar City">Peshawar City</option>
                    <option value="Peshawar Saddar">Peshawar Saddar</option>
                    <option value="Charsadda Road">Charsadda Road</option>
                    <option value="Hayatabad">Hayatabad</option>
                    <option value="Gulberg">Gulberg</option>
                </select>
            </div>
            <!-- Search field -->
            <div class="filter-item" style="flex: 1.5;">
                <label><i class="fas fa-search me-1"></i> Search</label>
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" id="globalSearch" placeholder="Search by ID, name, service...">
                </div>
            </div>
            <!-- Status filter (additional) -->
            <div class="filter-item">
                <label><i class="fas fa-circle-dot me-1"></i> Status</label>
                <select id="statusFilterMain">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="under_review">Under Review</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                    <option value="rejected">Rejected</option>
                    <option value="appealed">Appealed</option>
                </select>
            </div>
            <!-- Month filter (additional) -->
            <div class="filter-item">
                <label><i class="fas fa-calendar-alt me-1"></i> Month</label>
                <select id="monthFilterMain">
                    <option value="">All Months</option>
                    <option value="1">January</option><option value="2">February</option>
                    <option value="3">March</option><option value="4">April</option>
                    <option value="5">May</option><option value="6">June</option>
                    <option value="7">July</option><option value="8">August</option>
                    <option value="9">September</option><option value="10">October</option>
                    <option value="11">November</option><option value="12">December</option>
                </select>
            </div>
            <div class="filter-actions">
                <button class="btn-primary-sm" onclick="applyAllFilters()"><i class="fas fa-filter me-1"></i> Apply</button>
                <button class="btn-outline-sm" onclick="resetAllFilters()"><i class="fas fa-undo-alt me-1"></i> Reset</button>
            </div>
        </div>
    </div>

    <!-- Table Card (complaint details) - Stat cards REMOVED as requested -->
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
                        <th><i class="fas fa-map-marker-alt me-1"></i>Tehsil</th>
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
   DATA (enhanced with tehsil field for filtering)
============================================================ */
const allComplaints = [
    { id: 1, complaint_number: 'CMP2024120001', complainant: { name: 'Muhammad Ali', cnic_number: '12345-6789012-3', contact_number: '03001234567', email: 'ali@example.com', postal_address: 'House #123, Main Street, Peshawar' }, service: { name: 'Water Supply Connection' }, department: { name: 'WASA' }, tehsil: 'Peshawar City', category: 'New Connection', title: 'New water connection application', description: 'Applied for new water connection 2 weeks ago but no response yet.', address_location: '123 Main Street, Peshawar', status: 'pending', priority: 'high', submitted_at: '2024-12-20 10:30:00', created_at: '2024-12-20 10:30:00', admin_remarks: null },
    { id: 2, complaint_number: 'CMP2024120002', complainant: { name: 'Sadia Khan', cnic_number: '12345-6789012-4', contact_number: '03111234567', email: 'sadia@example.com', postal_address: 'House #456, Canal Road, Peshawar' }, service: { name: 'Birth Certificate' }, department: { name: 'Municipal Corporation' }, tehsil: 'Peshawar Saddar', category: 'Document Missing', title: 'Birth certificate not issued', description: 'Applied for birth certificate online, status shows processing for 3 weeks.', address_location: '456 Canal Road, Peshawar', status: 'in_progress', priority: 'medium', submitted_at: '2024-12-18 14:45:00', created_at: '2024-12-18 14:45:00', admin_remarks: 'Under review by municipal committee' },
    { id: 3, complaint_number: 'CMP2024120003', complainant: { name: 'Ahmed Raza', cnic_number: '12345-6789012-5', contact_number: '03214567890', email: 'ahmed@example.com', postal_address: 'Apartment #789, Gulberg, Peshawar' }, service: { name: 'Electricity Bill' }, department: { name: 'LESCO' }, tehsil: 'Gulberg', category: 'Overbilling', title: 'Excessive electricity bill', description: 'Bill amount is 3 times higher than normal usage.', address_location: '789 Gulberg, Peshawar', status: 'under_review', priority: 'urgent', submitted_at: '2024-12-15 09:15:00', created_at: '2024-12-15 09:15:00', admin_remarks: 'Meter reading verification requested' },
    { id: 4, complaint_number: 'CMP2024120004', complainant: { name: 'Fatima Akhtar', cnic_number: '12345-6789012-6', contact_number: '03339876543', email: 'fatima@example.com', postal_address: 'Street #5, DHA Phase 2, Peshawar' }, service: { name: 'Road Repair' }, department: { name: 'Municipal Corporation' }, tehsil: 'Hayatabad', category: 'Infrastructure', title: 'Road damage near school', description: 'Road is severely damaged near children school.', address_location: 'DHA Phase 2, Peshawar', status: 'resolved', priority: 'high', submitted_at: '2024-12-10 11:20:00', created_at: '2024-12-10 11:20:00', admin_remarks: 'Road repair completed on 25th December' },
    { id: 5, complaint_number: 'CMP2024120005', complainant: { name: 'Imran Shah', cnic_number: '12345-6789012-7', contact_number: '03455678901', email: 'imran@example.com', postal_address: 'House #12, Model Town, Peshawar' }, service: { name: 'Police Complaint' }, department: { name: 'Police' }, tehsil: 'Peshawar City', category: 'Theft Report', title: 'Mobile phone stolen', description: 'Mobile phone stolen from bus stop.', address_location: 'Model Town Bus Stop, Peshawar', status: 'rejected', priority: 'high', submitted_at: '2024-12-05 16:30:00', created_at: '2024-12-05 16:30:00', admin_remarks: 'Insufficient evidence provided' },
    { id: 6, complaint_number: 'CMP2024120006', complainant: { name: 'Nadia Javed', cnic_number: '12345-6789012-8', contact_number: '03007654321', email: 'nadia@example.com', postal_address: 'Street #8, Johar Town, Peshawar' }, service: { name: 'Sewerage' }, department: { name: 'WASA' }, tehsil: 'Charsadda Road', category: 'Blockage', title: 'Sewerage line blockage', description: 'Sewerage line blocked since 5 days.', address_location: 'Johar Town, Peshawar', status: 'in_progress', priority: 'urgent', submitted_at: '2024-12-22 08:45:00', created_at: '2024-12-22 08:45:00', admin_remarks: 'Team dispatched for cleaning' },
    { id: 7, complaint_number: 'CMP2024120007', complainant: { name: 'Hassan Tariq', cnic_number: '12345-6789012-9', contact_number: '03123456789', email: 'hassan@example.com', postal_address: 'House #34, Garden Town, Peshawar' }, service: { name: 'Domicile' }, department: { name: 'Municipal Corporation' }, tehsil: 'Peshawar Saddar', category: 'Late Delivery', title: 'Domicile certificate delay', description: 'Applied for domicile certificate 1 month ago.', address_location: 'Garden Town, Peshawar', status: 'appealed', priority: 'medium', submitted_at: '2024-12-01 13:00:00', created_at: '2024-12-01 13:00:00', admin_remarks: 'Appeal under consideration' },
    { id: 8, complaint_number: 'CMP2024120008', complainant: { name: 'Zainab Malik', cnic_number: '12345-6789013-0', contact_number: '03349876543', email: 'zainab@example.com', postal_address: 'Apartment #22, Bahria Town, Peshawar' }, service: { name: 'Property Transfer' }, department: { name: 'Municipal Corporation' }, tehsil: 'Hayatabad', category: 'Document Issue', title: 'Property transfer delay', description: 'Property transfer application pending for 2 months.', address_location: 'Bahria Town, Peshawar', status: 'pending', priority: 'medium', submitted_at: '2024-12-19 15:20:00', created_at: '2024-12-19 15:20:00', admin_remarks: null },
    { id: 9, complaint_number: 'CMP2024120009', complainant: { name: 'Omar Farooq', cnic_number: '12345-6789013-1', contact_number: '03014567890', email: 'omar@example.com', postal_address: 'Street #12, Iqbal Town, Peshawar' }, service: { name: 'Garbage Collection' }, department: { name: 'Municipal Corporation' }, tehsil: 'Peshawar City', category: 'No Service', title: 'No garbage collection', description: 'Garbage not collected from our area.', address_location: 'Iqbal Town, Peshawar', status: 'resolved', priority: 'high', submitted_at: '2024-12-14 10:00:00', created_at: '2024-12-14 10:00:00', admin_remarks: 'Service restored' },
    { id: 10, complaint_number: 'CMP2024120010', complainant: { name: 'Sana Mirza', cnic_number: '12345-6789013-2', contact_number: '03129876543', email: 'sana@example.com', postal_address: 'House #78, DHA, Peshawar' }, service: { name: 'Power Outage' }, department: { name: 'LESCO' }, tehsil: 'Hayatabad', category: 'No Service', title: 'Frequent power outages', description: 'Area experiencing frequent power outages.', address_location: 'DHA Phase 1, Peshawar', status: 'under_review', priority: 'high', submitted_at: '2024-12-21 18:30:00', created_at: '2024-12-21 18:30:00', admin_remarks: 'Load shedding schedule being reviewed' }
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

function parseDateTimeToTimestamp(dateStr) {
    return new Date(dateStr).getTime();
}

function filterByTimeframe(timestamp, timeframeVal) {
    const now = new Date();
    if (timeframeVal === 'all-time') return true;
    if (timeframeVal === 'last-month') {
        const oneMonthAgo = new Date();
        oneMonthAgo.setMonth(now.getMonth() - 1);
        return timestamp >= oneMonthAgo.getTime();
    }
    if (timeframeVal === 'last-week') {
        const oneWeekAgo = now.getTime() - 7 * 24 * 60 * 60 * 1000;
        return timestamp >= oneWeekAgo;
    }
    return true;
}

function applyAllFilters() {
    const searchTerm = document.getElementById('globalSearch').value.toLowerCase();
    const timeframe = document.getElementById('timeframeFilter').value;
    const department = document.getElementById('deptFilterMain').value;
    const tehsil = document.getElementById('tehsilFilter').value;
    const status = document.getElementById('statusFilterMain').value;
    const month = document.getElementById('monthFilterMain').value;

    filtered = allComplaints.filter(item => {
        // search in id, name, service, category
        const matchSearch = !searchTerm || 
            item.complaint_number.toLowerCase().includes(searchTerm) ||
            item.complainant.name.toLowerCase().includes(searchTerm) ||
            item.service.name.toLowerCase().includes(searchTerm) ||
            item.category.toLowerCase().includes(searchTerm);
        
        const matchDepartment = !department || item.department.name === department;
        const matchTehsil = !tehsil || item.tehsil === tehsil;
        const matchStatus = !status || item.status === status;
        
        // month filter
        let matchMonth = true;
        if (month) {
            const itemMonth = new Date(item.created_at).getMonth() + 1;
            matchMonth = itemMonth.toString() === month;
        }
        
        // timeframe filter
        let matchTimeframe = true;
        if (timeframe !== 'all-time') {
            const ts = parseDateTimeToTimestamp(item.created_at);
            matchTimeframe = filterByTimeframe(ts, timeframe);
        }
        
        return matchSearch && matchDepartment && matchTehsil && matchStatus && matchMonth && matchTimeframe;
    });
    
    currentPage = 1;
    renderTable();
    showToast(`Filters applied · ${filtered.length} complaints found`, 'info');
}

function resetAllFilters() {
    document.getElementById('globalSearch').value = '';
    document.getElementById('timeframeFilter').value = 'all-time';
    document.getElementById('deptFilterMain').value = '';
    document.getElementById('tehsilFilter').value = '';
    document.getElementById('statusFilterMain').value = '';
    document.getElementById('monthFilterMain').value = '';
    applyAllFilters();
    showToast('All filters reset', 'success');
}

function renderTable() {
    const tbody = document.getElementById('complaints-body');
    document.getElementById('totalCount').textContent = filtered.length;

    if (!filtered.length) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-5 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>No complaints found. Try adjusting your filters.</td></tr>`;
        document.getElementById('showingInfo').textContent = 'Showing 0 complaints';
        document.getElementById('pagination').innerHTML = '';
        return;
    }

    const start = (currentPage - 1) * PER_PAGE;
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
            <td><span class="svc-badge" style="background:#e6f7ff;">${c.tehsil}</span></td>
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
                        <tr><td class="detail-label">Tehsil</td><td class="detail-val">${c.tehsil}</td></tr>
                        <tr><td class="detail-label">Category</td><td class="detail-val">${c.category}</td></tr>
                        <tr><td class="detail-label">Status</td><td class="detail-val">${statusBadge(c.status)}</td></tr>
                        <tr><td class="detail-label">Priority</td><td class="detail-val"><span class="badge bg-${c.priority==='urgent'?'danger':c.priority==='high'?'warning text-dark':'info'}">${c.priority}</span></td></tr>
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
    applyAllFilters();
}

// Event listeners for filter changes
document.getElementById('globalSearch').addEventListener('input', applyAllFilters);
document.getElementById('timeframeFilter').addEventListener('change', applyAllFilters);
document.getElementById('deptFilterMain').addEventListener('change', applyAllFilters);
document.getElementById('tehsilFilter').addEventListener('change', applyAllFilters);
document.getElementById('statusFilterMain').addEventListener('change', applyAllFilters);
document.getElementById('monthFilterMain').addEventListener('change', applyAllFilters);
document.getElementById('forwardFromModal').addEventListener('click', () => {
    if (window._selectedId) {
        forwardComplaint(window._selectedId);
        bootstrap.Modal.getInstance(document.getElementById('complaintModal')).hide();
    }
});

// Initial render
applyAllFilters();
</script>
@endsection