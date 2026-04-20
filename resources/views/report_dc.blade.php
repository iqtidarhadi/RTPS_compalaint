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

        /* Enhanced Filter Bar (All-time, Department, By Tehsil + legacy search) */
        .filter-bar {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 18px 22px;
            margin-bottom: 28px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 20px;
            row-gap: 18px;
        }
        .filter-group-item {
            flex: 1;
            min-width: 150px;
        }
        .filter-group-item label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin-bottom: 6px;
            display: block;
        }
        .filter-group-item select, 
        .filter-group-item input {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 14px;
            font-size: 0.85rem;
            background: #fff;
            font-family: inherit;
            transition: 0.2s;
        }
        .filter-group-item select:focus, 
        .filter-group-item input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(30,58,95,0.1);
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
            font-size: 0.85rem;
        }
        .search-wrapper input {
            padding-left: 34px;
            width: 100%;
        }
        .btn-primary-custom {
            background: var(--primary);
            border: none;
            padding: 9px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.8rem;
            color: white;
            transition: 0.2s;
            margin-top: 6px;
        }
        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        .filter-actions {
            display: flex;
            gap: 12px;
            align-items: flex-end;
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
        /* Action buttons */
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

        @media (max-width: 740px) {
            .dashboard-container { padding: 16px; }
            .title-section h1 { font-size: 1.4rem; }
            .filter-row { flex-direction: column; gap: 12px; }
            .filter-group-item { width: 100%; }
            .filter-actions { width: 100%; justify-content: flex-end; }
            .action-group { gap: 5px; }
            .action-btn { padding: 4px 8px; font-size: 0.65rem; }
        }
    </style>


<div class="dashboard-container">
    <!-- Header unchanged -->
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
            <button class="btn-outline-custom" id="exportBtn"><i class="fas fa-download me-1"></i> Export</button>
        </div>
    </div>

    <!-- NEW FILTER SECTION: All-time, Department, By Tehsil (exactly as second screenshot) + search and service/type filters combined -->
    <div class="filter-bar">
        <div class="filter-row">
            <!-- Timeframe: All-time (dropdown) -->
            <div class="filter-group-item">
                <label><i class="far fa-clock me-1"></i> Timeframe</label>
                <select id="timeframeFilter">
                    <option value="all-time" selected>All-time</option>
                    <option value="last-month">Last Month</option>
                    <option value="last-week">Last Week</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
            <!-- Department: All -->
            <div class="filter-group-item">
                <label><i class="fas fa-building me-1"></i> Department</label>
                <select id="departmentFilter">
                    <option value="all" selected>All</option>
                    <option value="Revenue">Revenue</option>
                    <option value="Municipal Services">Municipal Services</option>
                    <option value="Health">Health</option>
                    <option value="Education">Education</option>
                </select>
            </div>
            <!-- By: Tehsil -->
            <div class="filter-group-item">
                <label><i class="fas fa-map-marker-alt me-1"></i> By: Tehsil</label>
                <select id="tehsilFilter">
                    <option value="all" selected>All Tehsils</option>
                    <option value="Peshawar City">Peshawar City</option>
                    <option value="Peshawar Saddar">Peshawar Saddar</option>
                    <option value="Charsadda Road">Charsadda Road</option>
                    <option value="Hayatabad">Hayatabad</option>
                </select>
            </div>
            <!-- Search by ID / keyword -->
            <div class="filter-group-item" style="flex: 1.5;">
                <label><i class="fas fa-search me-1"></i> Search</label>
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" id="globalSearchInput" placeholder="Search by ID, service, complaint type...">
                </div>
            </div>
            <!-- Additional legacy filters (Service, Type) kept for granular filtering -->
            <div class="filter-group-item">
                <label><i class="fas fa-concierge-bell me-1"></i> Service</label>
                <select id="serviceFilter">
                    <option value="">All Services</option>
                    <option value="Domicile">Domicile</option>
                    <option value="Birth Certificate">Birth Certificate</option>
                    <option value="Property Transfer">Property Transfer</option>
                    <option value="Garbage Collection">Garbage Collection</option>
                </select>
            </div>
            <div class="filter-group-item">
                <label><i class="fas fa-tag me-1"></i> Complaint Type</label>
                <select id="typeFilter">
                    <option value="">All Types</option>
                    <option value="Late Delivery">Late Delivery</option>
                    <option value="Document Issue">Document Issue</option>
                    <option value="Correction">Correction</option>
                    <option value="Transfer Delay">Transfer Delay</option>
                    <option value="No Service">No Service</option>
                </select>
            </div>
            <div class="filter-actions">
                <button class="btn-primary-custom" onclick="applyAllFilters()"><i class="fas fa-filter me-1"></i> Apply Filters</button>
                <button class="btn-outline-custom" onclick="resetFilters()" style="background:#f8fafc;"><i class="fas fa-undo-alt me-1"></i> Reset</button>
            </div>
        </div>
    </div>

    <!-- Table Card (complaint details) -->
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

<!-- Modal for Comment / Details / Decline / etc -->
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
    // Enhanced complaint dataset with tehsil & department fields for realistic filtering
    const complaintsData = [
        { id: "2665D9", service: "Domicile", type: "Late Delivery", datetime: "12.09.2019 - 12:53 PM", name: "Muhammad Tariq", status: "pending", tehsil: "Peshawar City", department: "Revenue" },
        { id: "2665DA", service: "Domicile", type: "Late Delivery", datetime: "15.10.2019 - 09:22 AM", name: "Sadia Khan", status: "resolved", tehsil: "Hayatabad", department: "Revenue" },
        { id: "2665DB", service: "Birth Certificate", type: "Document Issue", datetime: "02.11.2019 - 02:10 PM", name: "Ahmed Raza", status: "pending", tehsil: "Peshawar Saddar", department: "Municipal Services" },
        { id: "2665DC", service: "Property Transfer", type: "Document Issue", datetime: "18.11.2019 - 11:45 AM", name: "Fatima Akhtar", status: "declined", tehsil: "Charsadda Road", department: "Revenue" },
        { id: "2665DD", service: "Garbage Collection", type: "No Service", datetime: "05.12.2019 - 08:30 AM", name: "Imran Shah", status: "resolved", tehsil: "Peshawar City", department: "Municipal Services" },
        { id: "2665DE", service: "Domicile", type: "Late Delivery", datetime: "10.01.2020 - 03:20 PM", name: "Zainab Ali", status: "pending", tehsil: "Hayatabad", department: "Revenue" },
        { id: "2665DF", service: "Birth Certificate", type: "Correction", datetime: "22.02.2020 - 10:00 AM", name: "Hassan Tariq", status: "comment", tehsil: "Peshawar Saddar", department: "Municipal Services" },
        { id: "2665E0", service: "Domicile", type: "Late Delivery", datetime: "01.03.2020 - 04:15 PM", name: "Sana Mirza", status: "pending", tehsil: "Peshawar City", department: "Revenue" },
        { id: "2665E1", service: "Property Transfer", type: "Transfer Delay", datetime: "14.04.2020 - 09:50 AM", name: "Omar Farooq", status: "resolved", tehsil: "Charsadda Road", department: "Revenue" },
        { id: "2665E2", service: "Domicile", type: "Late Delivery", datetime: "20.05.2020 - 12:00 PM", name: "Nadia Javed", status: "declined", tehsil: "Hayatabad", department: "Revenue" }
    ];

    let filteredData = [...complaintsData];
    let currentPage = 1;
    const rowsPerPage = 6;

    // Helper: parse date for timeframe filtering (rough mapping for demo)
    function parseDateTimeToTimestamp(datetimeStr) {
        // format "12.09.2019 - 12:53 PM"
        let parts = datetimeStr.split(" - ");
        if (parts.length < 2) return new Date(0).getTime();
        let datePart = parts[0]; // DD.MM.YYYY
        let timePart = parts[1];
        let [day, month, year] = datePart.split(".");
        let adjustedYear = parseInt(year);
        let adjustedMonth = parseInt(month) - 1;
        let adjustedDay = parseInt(day);
        let hours = 0, minutes = 0;
        let timeMatch = timePart.match(/(\d+):(\d+)\s*(AM|PM)/i);
        if (timeMatch) {
            let h = parseInt(timeMatch[1]);
            let m = parseInt(timeMatch[2]);
            let meridiem = timeMatch[3].toUpperCase();
            if (meridiem === 'PM' && h !== 12) h += 12;
            if (meridiem === 'AM' && h === 12) h = 0;
            hours = h;
            minutes = m;
        }
        return new Date(adjustedYear, adjustedMonth, adjustedDay, hours, minutes).getTime();
    }

    function filterByTimeframe(timestamp, timeframeVal) {
        const now = new Date();
        const todayMidnight = new Date(now.getFullYear(), now.getMonth(), now.getDate()).getTime();
        if (timeframeVal === 'all-time') return true;
        if (timeframeVal === 'last-month') {
            const oneMonthAgo = new Date();
            oneMonthAgo.setMonth(now.getMonth() - 1);
            return timestamp >= oneMonthAgo.getTime();
        }
        if (timeframeVal === 'last-week') {
            const oneWeekAgo = todayMidnight - 7 * 24 * 60 * 60 * 1000;
            return timestamp >= oneWeekAgo;
        }
        return true;
    }

    function applyAllFilters() {
        const searchTerm = document.getElementById('globalSearchInput').value.toLowerCase();
        const serviceVal = document.getElementById('serviceFilter').value;
        const typeVal = document.getElementById('typeFilter').value;
        const timeframeVal = document.getElementById('timeframeFilter').value;
        const departmentVal = document.getElementById('departmentFilter').value;
        const tehsilVal = document.getElementById('tehsilFilter').value;
        
        filteredData = complaintsData.filter(item => {
            // search in id, service, type, name
            const matchSearch = searchTerm === '' || 
                item.id.toLowerCase().includes(searchTerm) || 
                item.service.toLowerCase().includes(searchTerm) || 
                item.type.toLowerCase().includes(searchTerm) ||
                (item.name && item.name.toLowerCase().includes(searchTerm));
            const matchService = !serviceVal || item.service === serviceVal;
            const matchType = !typeVal || item.type === typeVal;
            const matchDepartment = !departmentVal || departmentVal === 'all' || item.department === departmentVal;
            const matchTehsil = !tehsilVal || tehsilVal === 'all' || item.tehsil === tehsilVal;
            // timeframe
            let matchTimeframe = true;
            if (timeframeVal !== 'all-time') {
                const ts = parseDateTimeToTimestamp(item.datetime);
                matchTimeframe = filterByTimeframe(ts, timeframeVal);
            }
            return matchSearch && matchService && matchType && matchDepartment && matchTehsil && matchTimeframe;
        });
        currentPage = 1;
        renderTable();
        showToast(`Filters applied · ${filteredData.length} complaints found`, 'info');
    }

    function resetFilters() {
        document.getElementById('globalSearchInput').value = '';
        document.getElementById('serviceFilter').value = '';
        document.getElementById('typeFilter').value = '';
        document.getElementById('timeframeFilter').value = 'all-time';
        document.getElementById('departmentFilter').value = 'all';
        document.getElementById('tehsilFilter').value = 'all';
        applyAllFilters();
        showToast('All filters reset', 'success');
    }

    function renderTable() {
        const tbody = document.getElementById('complaintTableBody');
        const start = (currentPage - 1) * rowsPerPage;
        const paginated = filteredData.slice(start, start + rowsPerPage);
        
        if (paginated.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-5 text-muted">No complaints found with current filters</td></tr>`;
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

    // Action handler (View, Resolved, Pending, Decline, Comment)
    function handleAction(actionType, complaintId) {
        const complaint = complaintsData.find(c => c.id === complaintId);
        if (!complaint) return;
        
        let modalContent = '';
        switch(actionType) {
            case 'view':
                modalContent = `
                    <div class="mb-2"><span class="detail-label">Application ID</span><div class="fw-bold">${complaint.id}</div></div>
                    <div class="mb-2"><span class="detail-label">Service</span><div>${complaint.service}</div></div>
                    <div class="mb-2"><span class="detail-label">Complaint Type</span><div>${complaint.type}</div></div>
                    <div class="mb-2"><span class="detail-label">Date & Time</span><div>${complaint.datetime}</div></div>
                    <div class="mb-2"><span class="detail-label">Citizen Name</span><div>${complaint.name}</div></div>
                    <div class="mb-2"><span class="detail-label">Tehsil</span><div>${complaint.tehsil || 'N/A'}</div></div>
                    <div class="mb-2"><span class="detail-label">Department</span><div>${complaint.department || 'N/A'}</div></div>
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
        
        const modalTitleElem = document.querySelector('#actionModal .modal-title');
        if (actionType === 'view') modalTitleElem.innerHTML = `<i class="fas fa-info-circle me-2"></i>Complaint Details - ${complaintId}`;
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
        applyAllFilters();
        showToast('Dashboard refreshed', 'success');
    }
    
    // Event listeners for live search + filter keyup
    document.getElementById('globalSearchInput').addEventListener('keyup', () => applyAllFilters());
    document.getElementById('serviceFilter').addEventListener('change', () => applyAllFilters());
    document.getElementById('typeFilter').addEventListener('change', () => applyAllFilters());
    document.getElementById('timeframeFilter').addEventListener('change', () => applyAllFilters());
    document.getElementById('departmentFilter').addEventListener('change', () => applyAllFilters());
    document.getElementById('tehsilFilter').addEventListener('change', () => applyAllFilters());
    
    // Export CSV
    document.getElementById('exportBtn').addEventListener('click', () => {
        let csvRows = [["Application ID","Service","Complaint Type","Date Time","Citizen Name","Tehsil","Department"]];
        filteredData.forEach(item => {
            csvRows.push([item.id, item.service, item.type, item.datetime, item.name, item.tehsil || '', item.department || '']);
        });
        const csvContent = csvRows.map(row => row.map(cell => `"${cell}"`).join(",")).join("\n");
        const blob = new Blob([csvContent], { type: "text/csv" });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "complaints_export.csv";
        link.click();
        showToast("Exported current filtered complaints", "success");
    });
    
    // initial render
    applyAllFilters();
</script>
@endsection