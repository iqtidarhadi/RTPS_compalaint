@extends('layouts.layout')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f5f7fb;
            --card: #fff;
            --border: #e4e9f2;
            --text: #1a2235;
            --muted: #7b8aaa;
            --red: #f04e4e;
            --orange: #f5a623;
            --green: #22c98e;
            --blue: #3b7cff;
            --purple: #7c3aed;
            --radius: 12px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            padding: 32px 28px;
            font-size: 14px;
        }

        /* ── PAGE TITLE ── */
        .page-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        /* ══════════════════════════════
           SECTION 1 — DELAYED REMINDER
        ══════════════════════════════ */
        .section-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 12px;
        }

        .delayed-card {
            background: var(--card);
            border: 1.5px solid #f04e4e55;
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 32px;
            box-shadow: 0 2px 8px rgba(240,78,78,0.06);
        }

        .delayed-card table { width: 100%; border-collapse: collapse; }

        .delayed-card thead th {
            padding: 12px 18px;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text);
            background: #fff;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .delayed-card tbody td {
            padding: 14px 18px;
            font-size: 0.855rem;
            border-bottom: 1px solid #f8f9fc;
            vertical-align: middle;
        }
        .delayed-card tbody tr:last-child td { border-bottom: none; }
        .delayed-card tbody tr:hover { background: #fff9f9; }

        /* ══════════════════════════════
           SECTION 2 — APPLICANT DETAILS
        ══════════════════════════════ */
        .applicant-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .applicant-card-top {
            padding: 18px 20px 14px;
            border-bottom: 1px solid var(--border);
        }
        .applicant-card-top h2 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 14px;
        }

        /* Filter row */
        .filter-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 180px;
            max-width: 220px;
        }
        .search-wrap .fa-search {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.75rem;
            pointer-events: none;
        }
        .search-wrap input {
            width: 100%;
            padding: 7px 10px 7px 30px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.8rem;
            color: var(--text);
            background: #fafbfd;
        }
        .search-wrap input:focus { outline: none; border-color: var(--blue); }

        .filter-select {
            padding: 7px 28px 7px 11px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
            background: #fafbfd url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%237b8aaa' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 9px center;
            appearance: none;
            cursor: pointer;
            min-width: 130px;
        }
        .filter-select:focus { outline: none; border-color: var(--blue); }

        /* Main applicant table */
        .applicant-card table { width: 100%; border-collapse: collapse; }

        .applicant-card thead th {
            padding: 11px 14px;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text);
            background: #f8fafc;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .applicant-card tbody td {
            padding: 13px 14px;
            font-size: 0.855rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .applicant-card tbody tr:last-child td { border-bottom: none; }
        .applicant-card tbody tr:hover { background: #fafbfd; }

        /* Checkbox */
        .form-check-input { cursor: pointer; width: 15px; height: 15px; }

        /* Status pills */
        .status-pill {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            white-space: nowrap;
            min-width: 80px;
            text-align: center;
        }
        .s-critically-delayed { background: #f04e4e; color: #fff; line-height: 1.3; padding: 4px 8px; }
        .s-delayed       { background: #f5a623; color: #fff; }
        .s-dependency    { background: #f04e4e; color: #fff; }
        .s-pending       { background: #f5a623; color: #fff; }
        .s-delivered     { background: #22c98e; color: #fff; }
        .s-payment       { background: #f5a623; color: #fff; }

        /* Action buttons */
        .btn-show-cause {
            padding: 5px 14px;
            background: #3b7cff;
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: 0.72rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
        }
        .btn-show-cause:hover { background: #2560d8; }

        .btn-send-reminder {
            padding: 5px 14px;
            background: #3b7cff;
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: 0.72rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
        }
        .btn-send-reminder:hover { background: #2560d8; }

        /* Icon action buttons */
        .icon-btn {
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 4px 5px;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: color .15s, background .15s;
        }
        .icon-btn:hover { color: var(--blue); background: #eef2ff; }

        /* Pagination */
        .pag-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            font-size: 0.78rem;
            color: var(--muted);
            flex-wrap: wrap;
            gap: 8px;
        }

        @media (max-width: 768px) {
            body { padding: 14px 10px; }
            .filter-row { gap: 6px; }
            .filter-select { min-width: 110px; }
        }
    </style>
</head>
<body>

    <!-- Page Title -->
    <div class="page-title mb-1">Arms License - Service Delivery Details</div>

    <!-- ══ SECTION 1: DELAYED APPLICATIONS ══ -->
    <div class="section-label mt-3">Send Reminder - Delayed Application</div>

    <div class="delayed-card">
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>CNIC</th>
                        <th>Apply For</th>
                        <th>Date</th>
                        <th>Delayed Days</th>
                        <th>Application Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="delayedBody"></tbody>
            </table>
        </div>
    </div>

    <!-- ══ SECTION 2: APPLICANT DETAILS ══ -->
    <div class="applicant-card">
        <div class="applicant-card-top">
            <h2>Service Delivery Applicant Details</h2>
            <div class="filter-row">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search Application" oninput="applyFilters()">
                </div>
                <select class="filter-select" id="districtFilter" onchange="applyFilters()">
                    <option value="">Select District</option>
                    <option value="Peshawar">Peshawar</option>
                    <option value="Malakand">Malakand</option>
                    <option value="Mardan">Mardan</option>
                    <option value="Swat">Swat</option>
                </select>
                <select class="filter-select" id="serviceFilter" onchange="applyFilters()">
                    <option value="">Select Service</option>
                    <option value="Arms License">Arms License</option>
                    <option value="Domicile">Domicile</option>
                </select>
                <select class="filter-select" id="deptFilter" onchange="applyFilters()">
                    <option value="">Select Department</option>
                    <option value="Shaukhan DC-Office">Shaukhan DC-Office</option>
                </select>
                <select class="filter-select" id="dateFilter" onchange="applyFilters()">
                    <option value="">Select Date</option>
                    <option value="12 Jan 2026">12 Jan 2026</option>
                    <option value="15 Jan 2026">15 Jan 2026</option>
                </select>
                <select class="filter-select" id="priorityFilter" onchange="applyFilters()">
                    <option value="">All Priority</option>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" class="form-check-input" id="selectAll" onclick="toggleAll(this)"></th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>CNIC</th>
                        <th>Apply For</th>
                        <th>Date</th>
                        <th>Approved by</th>
                        <th>Application Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="applicantBody"></tbody>
            </table>
        </div>

        <div class="pag-row">
            <span id="pagInfo"></span>
            <nav><ul class="pagination pagination-sm mb-0" id="pagination"></ul></nav>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

/* ── DELAYED DATA ── */
const delayedData = [
    { name: 'Fazal Manan', address: 'Malakand', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', delayedDays: 42, status: 'critically-delayed' },
    { name: 'Fazal Manan', address: 'Malakand', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', delayedDays: 35, status: 'delayed' },
    { name: 'Fazal Manan', address: 'Malakand', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', delayedDays: 32, status: 'delayed' },
];

/* ── APPLICANT DATA ── */
const applicantData = [
    { name: 'Fazal Manan',  address: 'Malakand', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'dependency' },
    { name: 'Jawad Khan',   address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'pending' },
    { name: 'Mustafa Jan',  address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'delivered' },
    { name: 'Rafiullah',    address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'payment' },
    { name: 'Kashif Khan',  address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'dependency' },
    { name: 'Jawad Khan',   address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'pending' },
    { name: 'Mustafa Jan',  address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'delivered' },
    { name: 'Rafiullah',    address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '12 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'payment' },
    { name: 'Amjad Ullah',  address: 'Mardan',   cnic: '12548-547245-6', applyFor: 'Arms License', date: '15 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'pending' },
    { name: 'Sara Bibi',    address: 'Swat',     cnic: '12548-547245-6', applyFor: 'Arms License', date: '15 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'delivered' },
    { name: 'Imran Shah',   address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '15 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'dependency' },
    { name: 'Nadia Javed',  address: 'Peshawar', cnic: '12548-547245-6', applyFor: 'Arms License', date: '15 Jan 2026', approvedBy: 'Shaukhan DC-Office', status: 'pending' },
];

/* ── STATUS CONFIG ── */
const statusCfg = {
    'critically-delayed': { cls: 's-critically-delayed', label: 'Critically\nDelayed' },
    'delayed':     { cls: 's-delayed',     label: 'Delayed' },
    'dependency':  { cls: 's-dependency',  label: 'Dependency' },
    'pending':     { cls: 's-pending',     label: 'Pending' },
    'delivered':   { cls: 's-delivered',   label: 'Delivered' },
    'payment':     { cls: 's-payment',     label: 'Payment' },
};

/* ── RENDER DELAYED TABLE ── */
function renderDelayed() {
    document.getElementById('delayedBody').innerHTML = delayedData.map(r => {
        const s = statusCfg[r.status];
        const actionBtn = r.status === 'critically-delayed'
            ? `<button class="btn-show-cause" onclick="showToast('Show cause sent!')">Show cause</button>`
            : `<button class="btn-send-reminder" onclick="showToast('Reminder sent!')">Send Reminder</button>`;
        return `
        <tr>
            <td><strong>${r.name}</strong></td>
            <td>${r.address}</td>
            <td style="font-family:monospace;font-size:.8rem;">${r.cnic}</td>
            <td>${r.applyFor}</td>
            <td>${r.date}</td>
            <td><strong>${r.delayedDays}</strong></td>
            <td><span class="status-pill ${s.cls}">${s.label.replace('\n','<br>')}</span></td>
            <td>${actionBtn}</td>
        </tr>`;
    }).join('');
}

/* ── APPLICANT FILTER + PAGINATE ── */
let filtered = [...applicantData];
let page = 1;
const PER = 7;

function applyFilters() {
    const q    = document.getElementById('searchInput').value.toLowerCase();
    const dist = document.getElementById('districtFilter').value;
    const svc  = document.getElementById('serviceFilter').value;
    const dept = document.getElementById('deptFilter').value;
    const date = document.getElementById('dateFilter').value;

    filtered = applicantData.filter(r => {
        const mq = !q || r.name.toLowerCase().includes(q) || r.cnic.includes(q) || r.applyFor.toLowerCase().includes(q);
        const md = !dist || r.address === dist;
        const ms = !svc  || r.applyFor === svc;
        const me = !dept || r.approvedBy === dept;
        const mt = !date || r.date === date;
        return mq && md && ms && me && mt;
    });

    page = 1;
    renderApplicants();
}

function renderApplicants() {
    const tbody = document.getElementById('applicantBody');
    const start = (page - 1) * PER;
    const slice = filtered.slice(start, start + PER);

    if (!slice.length) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4" style="color:#7b8aaa;">
            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>No records found</td></tr>`;
        document.getElementById('pagInfo').textContent = 'No records';
        document.getElementById('pagination').innerHTML = '';
        return;
    }

    tbody.innerHTML = slice.map((r, i) => {
        const s = statusCfg[r.status] || { cls: '', label: r.status };
        return `
        <tr>
            <td><input type="checkbox" class="form-check-input row-check"></td>
            <td><strong>${r.name}</strong></td>
            <td>${r.address}</td>
            <td style="font-family:monospace;font-size:.8rem;">${r.cnic}</td>
            <td>${r.applyFor}</td>
            <td>${r.date}</td>
            <td style="font-size:.82rem;">${r.approvedBy}</td>
            <td><span class="status-pill ${s.cls}">${s.label}</span></td>
            <td>
                <button class="icon-btn" title="View" onclick="showToast('Viewing ${r.name}')">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="icon-btn" title="Edit" onclick="showToast('Editing ${r.name}')">
                    <i class="fas fa-pen"></i>
                </button>
            </td>
        </tr>`;
    }).join('');

    const end = Math.min(start + PER, filtered.length);
    document.getElementById('pagInfo').textContent = `Showing ${start + 1}–${end} of ${filtered.length} records`;
    renderPag();
}

function renderPag() {
    const total = Math.ceil(filtered.length / PER);
    const ul = document.getElementById('pagination');
    if (total <= 1) { ul.innerHTML = ''; return; }

    const li = (p, label, dis, act) =>
        `<li class="page-item ${dis?'disabled':''} ${act?'active':''}">
            <a class="page-link" href="#" onclick="goPage(${p});return false;">${label}</a>
         </li>`;

    let h = li(page-1,'&laquo;', page===1, false);
    for (let p=1; p<=total; p++) h += li(p, p, false, p===page);
    h += li(page+1,'&raquo;', page===total, false);
    ul.innerHTML = h;
}

function goPage(p) {
    const total = Math.ceil(filtered.length / PER);
    if (p < 1 || p > total) return;
    page = p;
    renderApplicants();
}

function toggleAll(cb) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
}

/* ── TOAST ── */
function showToast(msg) {
    let t = document.getElementById('_toast');
    if (!t) {
        t = document.createElement('div');
        t.id = '_toast';
        t.style.cssText = `position:fixed;bottom:24px;right:24px;background:#1a2235;color:#fff;
            padding:10px 18px;border-radius:10px;font-size:.82rem;font-weight:600;
            z-index:9999;box-shadow:0 4px 16px rgba(0,0,0,.18);transition:opacity .3s;`;
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.style.opacity = '0', 2500);
}

/* INIT */
renderDelayed();
applyFilters();
</script>
@endsection