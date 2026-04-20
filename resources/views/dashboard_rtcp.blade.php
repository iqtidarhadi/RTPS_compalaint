@extends('layouts.layout')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f4f6fb;
            --card: #ffffff;
            --border: #e8edf5;
            --text: #1a2235;
            --muted: #7b8aaa;
            --green: #22c98e;
            --orange: #f5a623;
            --red: #f04e4e;
            --blue: #3b7cff;
            --radius: 14px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding: 32px 24px;
        }

        h1 {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 26px;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        h1 i { color: var(--blue); }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 20px 22px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .stat-card .label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .stat-card .val {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1.1;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }
        .trend {
            font-size: 0.72rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .trend.up   { color: var(--green); }
        .trend.down { color: var(--red); }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .si-blue   { background: #eef2ff; color: #6c8dfa; }
        .si-orange { background: #fff4e5; color: #f5a623; }
        .si-green  { background: #e6faf3; color: #22c98e; }
        .si-pink   { background: #fff0f0; color: #f47c7c; }

        .main-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 16px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .card-top h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
        }

        .month-select {
            padding: 6px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            background: #fff;
            cursor: pointer;
            appearance: none;
            padding-right: 28px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237b8aaa' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
        }

        .table-wrap { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        thead tr th {
            background: #f8fafc;
            padding: 12px 20px;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        tbody tr td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text);
        }
        tbody tr:hover { background: #fafbfd; }

        .dept-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dept-logo {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: #eef2ff;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .dept-logo-placeholder {
            font-size: 1rem;
            font-weight: 700;
            color: var(--blue);
        }
        .dept-name { font-weight: 600; font-size: 0.85rem; line-height: 1.3; }

        .svc-pill {
            display: inline-block;
            padding: 3px 10px;
            background: #eef2ff;
            color: #4361b8;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            white-space: normal;
            word-break: break-word;
            max-width: 280px;
        }

        .status-pill {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .s-ontime   { background: var(--green); color: #fff; }
        .s-delayed  { background: var(--orange); color: #fff; }
        .s-critical { background: var(--red); color: #fff; }

        .ot-ok   { color: var(--green); font-weight: 600; }
        .ot-warn { color: var(--orange); font-weight: 600; }
        .ot-crit { color: var(--red); font-weight: 600; }

        .time-limit-badge {
            background: #f1f5f9;
            padding: 3px 8px;
            border-radius: 16px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }

        .pagination-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 10px;
            font-size: 0.8rem;
            color: var(--muted);
        }
        .pagination-row .pagination { margin: 0; }

        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            body { padding: 16px 12px; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stat-card .val { font-size: 1.5rem; }
            .svc-pill { max-width: 200px; }
        }
    </style>
</head>
<body>

<h1>
    <i class="fas fa-chart-line"></i> 
    Dashboard - KP RTPS 
</h1>

<!-- STAT CARDS (unchanged, cosmetic only) -->
<div class="stats-grid">
    <div class="stat-card">
        <div>
            <div class="label">Total User</div>
            <div class="val">40,689</div>
            <span class="trend up"><i class="fas fa-arrow-trend-up"></i> 8.5% Up from yesterday</span>
        </div>
        <div class="stat-icon si-blue"><i class="fas fa-users"></i></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="label">Total Pending</div>
            <div class="val">10,293</div>
            <span class="trend up"><i class="fas fa-arrow-trend-up"></i> 1.3% Up from past week</span>
        </div>
        <div class="stat-icon si-orange"><i class="fas fa-box"></i></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="label">Total Reverted</div>
            <div class="val">123</div>
            <span class="trend down"><i class="fas fa-arrow-trend-down"></i> 4.3% Down from yesterday</span>
        </div>
        <div class="stat-icon si-green"><i class="fas fa-chart-line"></i></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="label">Total Pending</div>
            <div class="val">2,040</div>
            <span class="trend up"><i class="fas fa-arrow-trend-up"></i> 1.8% Up from yesterday</span>
        </div>
        <div class="stat-icon si-pink"><i class="fas fa-clock-rotate-left"></i></div>
    </div>
</div>

<!-- MAIN TABLE CARD -->
<div class="main-card">
    <div class="card-top">
        <h2><i class="fas fa-list-ul me-2"></i> Service Delivery Details</h2>
        <select class="month-select" id="monthSelect" onchange="filterByMonth()">
            <option value="">All Months</option>
            <option value="1">January</option><option value="2">February</option>
            <option value="3">March</option><option value="4">April</option>
            <option value="5">May</option><option value="6">June</option>
            <option value="7">July</option><option value="8">August</option>
            <option value="9">September</option>
            <option value="10" selected>October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Type of Service</th>
                    <th>Location</th>
                    <th>Submission Date</th>
                    <th>Time Limit (Official)</th>
                    <th>Actual Delivery</th>
                    <th>Overtime</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>

    <div class="pagination-row">
        <span id="showInfo">Showing 1–8 of 12 records</span>
        <nav>
            <ul class="pagination pagination-sm mb-0" id="pagination"></ul>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ============================================================
   DATA MAPPED EXACTLY FROM SCREENSHOT (DC Office Peshawar)
   Types of Service + Department + Official Time Limit
   + realistic delivery data, location, overtime status
============================================================ */
const servicesFromScreenshot = [
    { service: "All Pakistan Cartridge Increase", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "10 days", limitDays: 10 },
    { service: "Demarcation of Land", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "30 Days", limitDays: 30 },
    { service: "Domicile", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "10 days", limitDays: 10 },
    { service: "FARD", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "3 Days", limitDays: 3 },
    { service: "Inheritance Mutation (Entry in Roznamcha & Revenue Record)", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "30 Days", limitDays: 30 },
    { service: "Attestation (Revenue Record)", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "30 Days", limitDays: 30 },
    { service: "Issuance of Arms License", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "15 days after Verification", limitDays: 15 },
    { service: "Issuance of Certified Copies of Registered Documents", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "3 Days", limitDays: 3 },
    { service: "Processing of Arms License", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "07 days", limitDays: 7 },
    { service: "Verification of Arms Applicant", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "15 days", limitDays: 15 }
];

// Additional services for variety (still within DC Office domain)
const extraServices = [
    { service: "Property Transfer (Mutation)", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "30 Days", limitDays: 30 },
    { service: "Fard/Extract of Revenue Record", dept: "BOARD OF REVENUE/DC OFFICE", timeLimit: "3 Days", limitDays: 3 }
];

const allServiceCatalog = [...servicesFromScreenshot, ...extraServices];

// Location pool (Tehsils within Peshawar district)
const locations = [
    "Peshawar City", "Peshawar Saddar", "Charsadda Road", "Hayatabad", 
    "Gulberg", "University Town", "Faqirabad", "Badaber"
];

// Helper: generate realistic actual delivery days based on limitDays (some delayed, some on time)
function getActualDelivery(limitDays) {
    const random = Math.random();
    if (random < 0.45) return limitDays; // on time
    if (random < 0.7) return limitDays + Math.floor(Math.random() * (limitDays * 0.4)) + 1; // slight delay
    return limitDays + Math.floor(Math.random() * (limitDays * 1.2)) + 3; // heavy delay
}

function formatOvertime(days) {
    if (days <= 0) return "0 Days";
    if (days >= 30) return `${Math.floor(days/30)} Month${Math.floor(days/30)>1?'s':''} ${days%30>0? days%30+' Days':''}`;
    return `${days} Days`;
}

function getStatus(overtimeVal, limitDays) {
    if (overtimeVal <= 0) return "ontime";
    if (overtimeVal <= limitDays * 0.5) return "delayed";
    return "critical";
}

// Build dataset with 20+ records based on screenshot services + varied months
let complaintData = [];
let idGen = 1;
const months = [10, 10, 10, 10, 11, 11]; // mostly october/november

allServiceCatalog.forEach((svc, idx) => {
    // generate 2-3 records per service type for realistic volume
    const numRecords = svc.service.includes("Arms") ? 2 : 2;
    for (let i = 0; i < numRecords; i++) {
        const limit = svc.limitDays;
        let actual = getActualDelivery(limit);
        let overtimeVal = actual - limit;
        if (overtimeVal < 0) overtimeVal = 0;
        const status = getStatus(overtimeVal, limit);
        const randomMonth = months[Math.floor(Math.random() * months.length)];
        const randomDay = 5 + Math.floor(Math.random() * 22);
        const dateStr = `${randomDay.toString().padStart(2,'0')}.${randomMonth.toString().padStart(2,'0')}.2024`;
        const location = locations[Math.floor(Math.random() * locations.length)];
        complaintData.push({
            id: idGen++,
            department: svc.dept,
            serviceName: svc.service,
            location: location,
            submissionDate: dateStr,
            officialTimeLimit: svc.timeLimit,
            limitDays: limit,
            actualDeliveryDays: actual,
            overtimeDays: overtimeVal,
            overtimeDisplay: formatOvertime(overtimeVal),
            status: status,
            month: randomMonth
        });
    }
});

// Add few extra records for arms license variations
complaintData.push({
    id: idGen++, department: "BOARD OF REVENUE/DC OFFICE", serviceName: "Arms License Renewal", location: "Hayatabad",
    submissionDate: "15.10.2024", officialTimeLimit: "15 days after Verification", limitDays: 15,
    actualDeliveryDays: 22, overtimeDays: 7, overtimeDisplay: "7 Days", status: "delayed", month: 10
});
complaintData.push({
    id: idGen++, department: "BOARD OF REVENUE/DC OFFICE", serviceName: "Demarcation of Land (Urgent)", location: "Charsadda Road",
    submissionDate: "05.11.2024", officialTimeLimit: "30 Days", limitDays: 30,
    actualDeliveryDays: 45, overtimeDays: 15, overtimeDisplay: "15 Days", status: "critical", month: 11
});

// Sort by date (newest first)
complaintData.sort((a,b) => {
    const [dA, mA, yA] = a.submissionDate.split('.');
    const [dB, mB, yB] = b.submissionDate.split('.');
    return new Date(yA, mA-1, dA) - new Date(yB, mB-1, dB);
});

// Global state
let filteredData = [...complaintData];
let currentPage = 1;
const rowsPerPage = 8;

function getStatusBadge(status) {
    if (status === 'ontime') return '<span class="status-pill s-ontime"><i class="fas fa-check-circle me-1"></i>On Time</span>';
    if (status === 'delayed') return '<span class="status-pill s-delayed"><i class="fas fa-exclamation-triangle me-1"></i>Delayed</span>';
    return '<span class="status-pill s-critical"><i class="fas fa-hourglass-end me-1"></i>Critical Delay</span>';
}

function overtimeClassStyle(val) {
    if (val === 0) return 'ot-ok';
    if (val < 10) return 'ot-warn';
    return 'ot-crit';
}

function initials(str) {
    if (!str) return 'BR';
    return str.split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
}

function renderTable() {
    const tbody = document.getElementById('tableBody');
    const start = (currentPage - 1) * rowsPerPage;
    const pageData = filteredData.slice(start, start + rowsPerPage);
    
    if (pageData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-5 text-muted">
            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>No service records found</td></tr>`;
        document.getElementById('showInfo').textContent = 'Showing 0 records';
        document.getElementById('pagination').innerHTML = '';
        return;
    }
    
    tbody.innerHTML = pageData.map(record => {
        const actualDisplay = record.actualDeliveryDays + (record.actualDeliveryDays > 1 ? ' Days' : ' Day');
        return `
        <tr>
            <td>
                <div class="dept-cell">
                    <div class="dept-logo">
                        <span class="dept-logo-placeholder">${initials(record.department)}</span>
                    </div>
                    <span class="dept-name">${record.department}</span>
                </div>
            </td>
            <td><span class="svc-pill">${record.serviceName}</span></td>
            <td>${record.location}</td>
            <td>${record.submissionDate}</td>
            <td><span class="time-limit-badge"><i class="far fa-hourglass me-1"></i>${record.officialTimeLimit}</span></td>
            <td>${actualDisplay}</td>
            <td class="${overtimeClassStyle(record.overtimeDays)}">${record.overtimeDisplay}</td>
            <td>${getStatusBadge(record.status)}</td>
        </table>`;
    }).join('');
    
    const end = Math.min(start + rowsPerPage, filteredData.length);
    document.getElementById('showInfo').innerHTML = `Showing ${start+1}–${end} of ${filteredData.length} service records`;
    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(filteredData.length / rowsPerPage);
    const paginationUl = document.getElementById('pagination');
    if (totalPages <= 1) { paginationUl.innerHTML = ''; return; }
    
    let html = '';
    const prevDisabled = currentPage === 1 ? 'disabled' : '';
    html += `<li class="page-item ${prevDisabled}"><a class="page-link" href="#" onclick="changePage(${currentPage-1}); return false;">«</a></li>`;
    
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    if (endPage - startPage < 4 && startPage > 1) startPage = Math.max(1, endPage - 4);
    
    for (let i = startPage; i <= endPage; i++) {
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

function filterByMonth() {
    const selectedMonth = document.getElementById('monthSelect').value;
    if (!selectedMonth) {
        filteredData = [...complaintData];
    } else {
        filteredData = complaintData.filter(item => item.month.toString() === selectedMonth);
    }
    currentPage = 1;
    renderTable();
}

// Optional refresh (if any external filter needed)
function refreshData() {
    filterByMonth();
}

// Initialize
filterByMonth();
</script>
@endsection