@extends('layouts.layout')
@section('content')
    <!-- Bootstrap 5 CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1e3a5f;
            --primary-dark: #0f2b48;
            --success: #2b7a4b;
            --danger: #c73e3a;
            --warning: #e68a2e;
            --info: #3b82f6;
            --bg: #f1f5f9;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #475569;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
        }

        .dashboard-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 28px 24px;
        }

        /* Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
        }
        .title-section h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .title-section h1 i {
            font-size: 1.6rem;
            color: var(--primary);
        }
        .title-section .badge-date {
            font-size: 0.75rem;
            color: var(--muted);
            background: #eef2ff;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
        }
        .header-actions {
            display: flex;
            gap: 12px;
        }
        .btn-outline-custom {
            border: 1px solid var(--border);
            background: white;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: 0.2s;
        }
        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Stat Cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 20px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -12px rgba(0,0,0,0.12);
        }
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
        .stat-header span {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
            margin-bottom: 8px;
        }
        .stat-trend {
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .trend-up { color: var(--success); background: #e0f2e9; padding: 2px 8px; border-radius: 30px; }
        .trend-down { color: var(--danger); background: #ffe5e5; padding: 2px 8px; border-radius: 30px; }

        /* Filter Bar */
        .filter-bar {
            background: white;
            border-radius: 18px;
            border: 1px solid var(--border);
            padding: 16px 20px;
            margin-bottom: 28px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
        }
        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            flex: 2;
        }
        .filter-group input, .filter-group select {
            padding: 9px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 0.8rem;
            background: #fff;
            font-family: inherit;
        }
        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 220px;
        }
        .search-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
        }
        .search-wrapper input {
            width: 100%;
            padding-left: 34px;
        }
        .btn-primary-custom {
            background: var(--primary);
            border: none;
            padding: 8px 20px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.8rem;
            color: white;
            transition: 0.2s;
        }
        .btn-primary-custom:hover {
            background: var(--primary-dark);
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 24px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .table-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .table-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .table-responsive-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .complaint-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }
        .complaint-table th {
            text-align: left;
            padding: 16px 20px;
            background: #fafcff;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
        }
        .complaint-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f2f5;
            font-size: 0.85rem;
            vertical-align: middle;
        }
        .complaint-table tr:hover td {
            background: #fafbff;
        }
        .app-id {
            font-family: monospace;
            font-weight: 700;
            background: #eef2ff;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 0.75rem;
            color: var(--primary);
        }
        .service-badge {
            background: #f1f3f4;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        /* Action buttons group (View Details, Resolved, Pending, Decline, Comment) */
        .action-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }
        .action-btn {
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.15s;
            background: white;
            border: 1px solid var(--border);
            color: var(--text);
        }
        .action-btn i { margin-right: 4px; font-size: 0.7rem; }
        .action-btn-view { background: #eef2ff; color: var(--primary); border-color: #cbd5e1; }
        .action-btn-view:hover { background: var(--primary); color: white; }
        .action-btn-resolved { background: #e0f2e9; color: var(--success); border-color: #bcd9cc; }
        .action-btn-resolved:hover { background: var(--success); color: white; }
        .action-btn-pending { background: #fff3e0; color: var(--warning); border-color: #ffd9a5; }
        .action-btn-pending:hover { background: var(--warning); color: white; }
        .action-btn-decline { background: #ffe8e8; color: var(--danger); border-color: #f5c2c2; }
        .action-btn-decline:hover { background: var(--danger); color: white; }
        .action-btn-comment { background: #e9f0ff; color: var(--info); border-color: #cbdff5; }
        .action-btn-comment:hover { background: var(--info); color: white; }

        .pagination-area {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        /* Modal */
        .modal-custom .modal-header {
            background: var(--primary);
            color: white;
            border-bottom: none;
        }
        .detail-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
        }

        @media (max-width: 640px) {
            .dashboard-container { padding: 16px; }
            .title-section h1 { font-size: 1.4rem; }
            .filter-group { flex-direction: column; width: 100%; }
            .search-wrapper { width: 100%; }
            .action-group { gap: 5px; }
            .action-btn { padding: 4px 8px; font-size: 0.65rem; }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- Header: Title changed to "DC Peshawar" -->
    <div class="dashboard-header">
        <div class="title-section">
            <h1>
                <i class="fas fa-landmark"></i> 
                DC Peshawar
            </h1>
            <div class="badge-date">
                <i class="far fa-calendar-alt me-1"></i> Deputy Commissioner Office · Peshawar
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-outline-custom" onclick="refreshDashboard()"><i class="fas fa-sync-alt me-1"></i> Refresh</button>
            <button class="btn-outline-custom"><i class="fas fa-download me-1"></i> Export</button>
        </div>
    </div>

    <!-- Stat Cards (Numbers as per reference) -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span><i class="fas fa-users me-1"></i> Total User</span>
                <div class="stat-icon" style="background:#eef2ff; color:#1e3a5f;"><i class="fas fa-user-group"></i></div>
            </div>
            <div class="stat-value">40,689</div>
            <div class="stat-trend"><span class="trend-up"><i class="fas fa-arrow-up me-1"></i>8.5%</span> Up from yesterday</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span><i class="fas fa-clock me-1"></i> Total Pending</span>
                <div class="stat-icon" style="background:#fff3e0; color:#e68a2e;"><i class="fas fa-hourglass-half"></i></div>
            </div>
            <div class="stat-value">10,293</div>
            <div class="stat-trend"><span class="trend-up"><i class="fas fa-arrow-up me-1"></i>1.3%</span> Up from past week</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span><i class="fas fa-undo-alt me-1"></i> Total Rverted</span>
                <div class="stat-icon" style="background:#ffe8e8; color:#c73e3a;"><i class="fas fa-rotate-left"></i></div>
            </div>
            <div class="stat-value">123</div>
            <div class="stat-trend"><span class="trend-down"><i class="fas fa-arrow-down me-1"></i>4.3%</span> Down from yesterday</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span><i class="fas fa-chart-line me-1"></i> Total Pending</span>
                <div class="stat-icon" style="background:#e0f2e9; color:#2b7a4b;"><i class="fas fa-chart-simple"></i></div>
            </div>
            <div class="stat-value">2,040</div>
            <div class="stat-trend"><span class="trend-up"><i class="fas fa-arrow-up me-1"></i>1.8%</span> Up from yesterday</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <div class="filter-group">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search by ID, service, complaint type...">
            </div>
            <select id="serviceFilter">
                <option value="">All Services</option>
                <option value="Domicile">Domicile</option>
                <option value="Birth Certificate">Birth Certificate</option>
                <option value="Property">Property Transfer</option>
                <option value="Garbage">Garbage Collection</option>
            </select>
            <select id="typeFilter">
                <option value="">All Types</option>
                <option value="Late Delivery">Late Delivery</option>
                <option value="Document Issue">Document Issue</option>
                <option value="Overbilling">Overbilling</option>
                <option value="Infrastructure">Infrastructure</option>
            </select>
        </div>
        <button class="btn-primary-custom" onclick="filterComplaints()"><i class="fas fa-filter me-1"></i> Apply</button>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-header">
            <h3><i class="fas fa-list-ul"></i> Complaint Details</h3>
            <span class="text-muted" style="font-size:0.75rem;">Total: <strong id="totalCountSpan">0</strong> entries</span>
        </div>
        <div class="table-responsive-wrap">
            <table class="complaint-table">
                <thead>
                    <tr>
                        <th>Application ID</th>
                        <th>Service</th>
                        <th>Complaint Type</th>
                        <th>Date - Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="complaintTableBody">
                    <!-- dynamic rows -->
                </tbody>
            </table>
        </div>
        <div class="pagination-area">
            <div id="infoText" class="text-muted small"></div>
            <nav>
                <ul class="pagination pagination-sm mb-0" id="paginationControls"></ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal for Comment / Details -->
<div class="modal fade modal-custom" id="actionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-pen-alt me-2"></i>Update Complaint</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                <!-- dynamic -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="confirmActionBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100;">
    <div id="liveToast" class="toast" data-bs-autohide="true" data-bs-delay="2500">
        <div class="toast-header bg-primary text-white">
            <i class="fas fa-bell me-2"></i>
            <strong class="me-auto">DC Office</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toastMsg"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sample complaint data (enhanced with realistic fields, but keeping the reference style)
    const complaintsData = [
        { id: "2665D9", service: "Domicile", type: "Late Delivery", datetime: "12.09.2019 - 12:53 PM", name: "Muhammad Tariq", status: "pending" },
        { id: "2665DA", service: "Domicile", type: "Late Delivery", datetime: "15.10.2019 - 09:22 AM", name: "Sadia Khan", status: "resolved" },
        { id: "2665DB", service: "Birth Certificate", type: "Document Issue", datetime: "02.11.2019 - 02:10 PM", name: "Ahmed Raza", status: "pending" },
        { id: "2665DC", service: "Property Transfer", type: "Document Issue", datetime: "18.11.2019 - 11:45 AM", name: "Fatima Akhtar", status: "declined" },
        { id: "2665DD", service: "Garbage Collection", type: "No Service", datetime: "05.12.2019 - 08:30 AM", name: "Imran Shah", status: "resolved" },
        { id: "2665DE", service: "Domicile", type: "Late Delivery", datetime: "10.01.2020 - 03:20 PM", name: "Zainab Ali", status: "pending" },
        { id: "2665DF", service: "Birth Certificate", type: "Correction", datetime: "22.02.2020 - 10:00 AM", name: "Hassan Tariq", status: "comment" },
        { id: "2665E0", service: "Domicile", type: "Late Delivery", datetime: "01.03.2020 - 04:15 PM", name: "Sana Mirza", status: "pending" },
        { id: "2665E1", service: "Property", type: "Transfer Delay", datetime: "14.04.2020 - 09:50 AM", name: "Omar Farooq", status: "resolved" },
        { id: "2665E2", service: "Domicile", type: "Late Delivery", datetime: "20.05.2020 - 12:00 PM", name: "Nadia Javed", status: "declined" }
    ];

    let filteredData = [...complaintsData];
    let currentPage = 1;
    const rowsPerPage = 6;

    function renderTable() {
        const tbody = document.getElementById('complaintTableBody');
        const start = (currentPage - 1) * rowsPerPage;
        const paginated = filteredData.slice(start, start + rowsPerPage);
        
        if (paginated.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-5 text-muted">No complaints found</td></tr>`;
            document.getElementById('totalCountSpan').innerText = filteredData.length;
            document.getElementById('infoText').innerText = `Showing 0 - 0 of 0`;
            return;
        }

        tbody.innerHTML = paginated.map(item => `
            <tr>
                <td><span class="app-id"><i class="fas fa-hashtag me-1"></i>${item.id}</span></td>
                <td><span class="service-badge">${item.service}</span></td>
                <td>${item.type}</td>
                <td><i class="far fa-calendar-alt me-1 text-muted"></i> ${item.datetime}</td>
                <td>
                    <div class="action-group">
                        <button class="action-btn action-btn-view" onclick="handleAction('view', '${item.id}')"><i class="fas fa-eye"></i> View Details</button>
                        <button class="action-btn action-btn-resolved" onclick="handleAction('resolved', '${item.id}')"><i class="fas fa-check-circle"></i> Resolved</button>
                        <button class="action-btn action-btn-pending" onclick="handleAction('pending', '${item.id}')"><i class="fas fa-clock"></i> Pending</button>
                        <button class="action-btn action-btn-decline" onclick="handleAction('decline', '${item.id}')"><i class="fas fa-times-circle"></i> Decline</button>
                        <button class="action-btn action-btn-comment" onclick="handleAction('comment', '${item.id}')"><i class="fas fa-comment-dots"></i> Comment</button>
                    </div>
                </td>
            </tr>
        `).join('');
        
        document.getElementById('totalCountSpan').innerText = filteredData.length;
        const end = Math.min(start + rowsPerPage, filteredData.length);
        document.getElementById('infoText').innerHTML = `Showing ${start+1}–${end} of ${filteredData.length} complaints`;
        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        const paginationUl = document.getElementById('paginationControls');
        if (totalPages <= 1) { paginationUl.innerHTML = ''; return; }
        let html = '';
        const prevDisabled = currentPage === 1 ? 'disabled' : '';
        html += `<li class="page-item ${prevDisabled}"><a class="page-link" href="#" onclick="changePage(${currentPage-1}); return false;">«</a></li>`;
        for (let i = 1; i <= totalPages; i++) {
            if (i === currentPage) html += `<li class="page-item active"><a class="page-link" href="#">${i}</a></li>`;
            else html += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${i}); return false;">${i}</a></li>`;
        }
        const nextDisabled = currentPage === totalPages ? 'disabled' : '';
        html += `<li class="page-item ${nextDisabled}"><a class="page-link" href="#" onclick="changePage(${currentPage+1}); return false;">»</a></li>`;
        paginationUl.innerHTML = html;
    }

    function changePage(page) {
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTable();
    }

    function filterComplaints() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const serviceVal = document.getElementById('serviceFilter').value;
        const typeVal = document.getElementById('typeFilter').value;
        
        filteredData = complaintsData.filter(item => {
            const matchSearch = searchTerm === '' || item.id.toLowerCase().includes(searchTerm) || item.service.toLowerCase().includes(searchTerm) || item.type.toLowerCase().includes(searchTerm);
            const matchService = !serviceVal || item.service === serviceVal;
            const matchType = !typeVal || item.type === typeVal;
            return matchSearch && matchService && matchType;
        });
        currentPage = 1;
        renderTable();
    }

    // Action handler for all 5 buttons: View Details, Resolved, Pending, Decline, Comment
    function handleAction(actionType, complaintId) {
        const complaint = complaintsData.find(c => c.id === complaintId);
        if (!complaint) return;
        
        let modalTitle = '', modalContent = '';
        switch(actionType) {
            case 'view':
                modalTitle = `Complaint Details - ${complaintId}`;
                modalContent = `
                    <div class="mb-2"><span class="detail-label">Application ID</span><div class="fw-bold">${complaint.id}</div></div>
                    <div class="mb-2"><span class="detail-label">Service</span><div>${complaint.service}</div></div>
                    <div class="mb-2"><span class="detail-label">Complaint Type</span><div>${complaint.type}</div></div>
                    <div class="mb-2"><span class="detail-label">Date & Time</span><div>${complaint.datetime}</div></div>
                    <div class="mb-2"><span class="detail-label">Citizen Name</span><div>${complaint.name}</div></div>
                    <div class="mt-3 alert alert-light">Full description: Citizen reported ${complaint.type} issue regarding ${complaint.service}. Awaiting processing.</div>
                `;
                break;
            case 'resolved':
                modalContent = `<p>Mark complaint <strong>${complaintId}</strong> as <span class="text-success">RESOLVED</span>?</p><p class="small text-muted">This will update the status to resolved.</p>`;
                break;
            case 'pending':
                modalContent = `<p>Mark complaint <strong>${complaintId}</strong> as <span class="text-warning">PENDING</span>?</p><p class="small text-muted">Complaint will remain in pending queue.</p>`;
                break;
            case 'decline':
                modalContent = `<p>Decline complaint <strong>${complaintId}</strong>?</p><textarea class="form-control mt-2" id="declineReason" rows="2" placeholder="Reason for decline..."></textarea>`;
                break;
            case 'comment':
                modalContent = `<p>Add internal comment for <strong>${complaintId}</strong></p><textarea class="form-control" id="commentText" rows="3" placeholder="Write your comment..."></textarea>`;
                break;
            default: return;
        }
        
        const modalBody = document.getElementById('modalBodyContent');
        if (actionType === 'view') modalBody.innerHTML = modalContent;
        else modalBody.innerHTML = `<h6 class="mb-3">${actionType.toUpperCase()} ACTION</h6>${modalContent}`;
        
        const modal = new bootstrap.Modal(document.getElementById('actionModal'));
        const confirmBtn = document.getElementById('confirmActionBtn');
        
        // remove previous listener and attach new one
        const newConfirmBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        
        newConfirmBtn.addEventListener('click', () => {
            if (actionType === 'decline') {
                const reason = document.getElementById('declineReason')?.value || 'No reason provided';
                showToast(`Complaint ${complaintId} declined. Reason: ${reason.substring(0, 60)}`, 'danger');
            } 
            else if (actionType === 'comment') {
                const comment = document.getElementById('commentText')?.value || 'No comment';
                showToast(`Comment added for ${complaintId}: "${comment.substring(0, 80)}"`, 'info');
            }
            else if (actionType === 'resolved') {
                showToast(`Complaint ${complaintId} marked as RESOLVED`, 'success');
            }
            else if (actionType === 'pending') {
                showToast(`Complaint ${complaintId} status changed to PENDING`, 'warning');
            }
            else if (actionType === 'view') {
                showToast(`Viewed details for ${complaintId}`, 'info');
            }
            modal.hide();
        });
        
        // override modal title
        const modalTitleElem = document.querySelector('#actionModal .modal-title');
        if (actionType === 'view') modalTitleElem.innerHTML = `<i class="fas fa-info-circle me-2"></i>${modalTitle}`;
        else modalTitleElem.innerHTML = `<i class="fas ${actionType === 'resolved' ? 'fa-check-circle' : actionType === 'decline' ? 'fa-ban' : actionType === 'comment' ? 'fa-comment' : 'fa-edit'} me-2"></i>${actionType.toUpperCase()} Complaint`;
        
        modal.show();
    }
    
    function showToast(msg, type = 'success') {
        const toastEl = document.getElementById('liveToast');
        const toastBody = document.getElementById('toastMsg');
        toastBody.innerText = msg;
        const toastHeader = document.querySelector('#liveToast .toast-header');
        toastHeader.className = `toast-header ${type === 'success' ? 'bg-success' : type === 'danger' ? 'bg-danger' : 'bg-primary'} text-white`;
        const bsToast = bootstrap.Toast.getOrCreateInstance(toastEl);
        bsToast.show();
    }
    
    function refreshDashboard() {
        filterComplaints();
        showToast('Dashboard refreshed successfully', 'success');
    }
    
    // Event listeners for filters
    document.getElementById('searchInput').addEventListener('keyup', () => filterComplaints());
    document.getElementById('serviceFilter').addEventListener('change', () => filterComplaints());
    document.getElementById('typeFilter').addEventListener('change', () => filterComplaints());
    
    // initial render
    filterComplaints();
</script>
@endsection