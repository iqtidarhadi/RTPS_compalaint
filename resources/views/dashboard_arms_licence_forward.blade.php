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
            --radius: 12px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            padding: 28px 24px 40px;
            font-size: 13px;
        }

        /* ── TITLE ── */
        .page-title {
            font-size: 1.2rem;
            font-weight: 800;
            text-decoration: underline;
            text-underline-offset: 3px;
            margin-bottom: 16px;
        }

        /* ══════════════════════════
           SECTION 1 – DELAYED
        ══════════════════════════ */
        .sec-label {
            font-size: 0.78rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .delayed-card {
            background: var(--card);
            border: 2px solid #4a90d9;
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(74,144,217,.08);
        }
        .delayed-card table { width:100%; border-collapse:collapse; }
        .delayed-card thead th {
            padding: 10px 14px;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text);
            background: #fff;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .delayed-card tbody td {
            padding: 12px 14px;
            font-size: 0.82rem;
            border-bottom: 1px solid #f8f9fc;
            vertical-align: middle;
        }
        .delayed-card tbody tr:last-child td { border-bottom: none; }
        .delayed-card tbody tr:hover { background: #f8fbff; }

        /* ══════════════════════════
           SECTION 2 – APPLICANT
        ══════════════════════════ */
        .app-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
            overflow: hidden;
            margin-bottom: 20px;
        }
        .app-card-top {
            padding: 16px 18px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            border-bottom: 1px solid var(--border);
        }
        .app-card-top h2 { font-size: 0.95rem; font-weight: 700; }

        .search-wrap { position:relative; }
        .search-wrap .fa-search {
            position:absolute; left:9px; top:50%; transform:translateY(-50%);
            color:var(--muted); font-size:0.7rem; pointer-events:none;
        }
        .search-wrap input {
            padding: 6px 10px 6px 27px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.78rem;
            width: 180px;
            background: #fafbfd;
        }
        .search-wrap input:focus { outline:none; border-color:var(--blue); }

        .filter-select {
            padding: 6px 26px 6px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text);
            background: #fafbfd url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%237b8aaa' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 8px center;
            appearance: none;
            cursor: pointer;
        }

        /* Applicant table */
        .app-card table { width:100%; border-collapse:collapse; }
        .app-card thead th {
            padding: 10px 12px;
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--text);
            background: #f8fafc;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .app-card tbody td {
            padding: 11px 12px;
            font-size: 0.82rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .app-card tbody tr:last-child td { border-bottom: none; }
        .app-card tbody tr:hover { background: #fafbfd; }

        /* Checked row highlight */
        .app-card tbody tr.row-checked { background: #f0f6ff; }

        /* Status pills */
        .sp {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 6px;
            font-size: 0.68rem;
            font-weight: 700;
            white-space: nowrap;
            min-width: 76px;
            text-align: center;
        }
        .sp-delayed    { background: #f5a623; color:#fff; }
        .sp-critical   { background: #f04e4e; color:#fff; line-height:1.3; padding:3px 8px; }
        .sp-dependency { background: #f04e4e; color:#fff; }
        .sp-pending    { background: #f5a623; color:#fff; }
        .sp-delivered  { background: #22c98e; color:#fff; }
        .sp-payment    { background: #f5a623; color:#fff; }

        /* Action buttons in delayed table */
        .btn-remind {
            padding: 5px 12px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: 0.68rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
        }
        .btn-remind:hover { background: #2560d8; }

        /* Icon buttons */
        .icon-btn {
            background: none; border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 3px 5px;
            border-radius: 5px;
            font-size: 0.85rem;
            transition: color .15s, background .15s;
        }
        .icon-btn:hover { color: var(--blue); background: #eef2ff; }

        /* ── TABLE FOOTER ── */
        .tbl-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 8px;
            font-size: 0.75rem;
            color: var(--muted);
        }
        .tbl-footer .left { display:flex; align-items:center; gap:6px; }
        .tbl-footer select {
            padding: 3px 8px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.75rem;
            font-family: inherit;
        }
        .tbl-footer .right a {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.75rem;
            cursor: pointer;
        }
        .tbl-footer .right a:hover { text-decoration: underline; }

        /* ══════════════════════════
           REMARKS BOX
        ══════════════════════════ */
        .remarks-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 16px 18px;
            margin-bottom: 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .remarks-card h3 { font-size: 0.9rem; font-weight: 700; margin-bottom: 10px; }
        .remarks-card textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-family: inherit;
            font-size: 0.82rem;
            color: var(--text);
            resize: vertical;
            min-height: 80px;
            background: #fafbfd;
        }
        .remarks-card textarea:focus { outline: none; border-color: var(--blue); }
        .remarks-card textarea::placeholder { color: var(--muted); }

        /* ══════════════════════════
           SELECT OFFICER
        ══════════════════════════ */
        .officer-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 16px 18px;
            margin-bottom: 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .officer-card h3 { font-size: 0.9rem; font-weight: 700; margin-bottom: 12px; }

        .officer-search-wrap {
            position: relative;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fafbfd;
            padding: 7px 12px 7px 32px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            min-height: 38px;
            cursor: text;
            margin-bottom: 10px;
        }
        .officer-search-wrap .fa-search {
            position: absolute; left: 10px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted); font-size: 0.72rem; pointer-events: none;
        }
        .officer-search-wrap input {
            border: none; background: transparent;
            font-family: inherit; font-size: 0.8rem;
            outline: none; flex: 1; min-width: 120px;
        }

        /* Selected officer tags */
        .officer-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #e8f0fe;
            color: #2d5bce;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .officer-tag .remove {
            cursor: pointer;
            font-size: 0.65rem;
            color: #6b8dd6;
            background: none;
            border: none;
            padding: 0;
            line-height: 1;
            font-weight: 700;
        }
        .officer-tag .remove:hover { color: var(--red); }

        /* ══════════════════════════
           BOTTOM ACTION BAR
        ══════════════════════════ */
        .action-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 4px;
        }
        .btn-action {
            flex: 1;
            min-width: 100px;
            padding: 11px 16px;
            border: none;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .15s, transform .15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-action:hover { opacity: .88; transform: translateY(-1px); }
        .btn-revert  { background: #f1f5f9; color: var(--text); border: 1px solid var(--border); }
        .btn-approve { background: #22c98e; color: #fff; }
        .btn-decline { background: #f04e4e; color: #fff; }
        .btn-forward { background: #3b7cff; color: #fff; }

        /* Checkbox */
        .form-check-input { cursor:pointer; width:14px; height:14px; }

        /* Mono CNIC */
        .mono { font-family: monospace; font-size: 0.78rem; }

        @media (max-width: 640px) {
            body { padding: 12px 8px 32px; }
            .app-card-top { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

    <div class="page-title">Arms License - Service Delivery Details</div>

    <!-- ══ SECTION 1: SEND REMINDER ══ -->
    <div class="sec-label">Send Reminder - Delayed Application</div>
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
                <tbody>
                    <tr>
                        <td><strong>Fazal Manan</strong></td>
                        <td>Malakand</td>
                        <td class="mono">12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td><strong>42</strong></td>
                        <td><span class="sp sp-delayed">Delayed</span></td>
                        <td><button class="btn-remind" onclick="toast('Reminder sent!')">Send Reminder</button></td>
                    </tr>
                    <tr>
                        <td><strong>Fazal Manan</strong></td>
                        <td>Malakand</td>
                        <td class="mono">12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td><strong>35</strong></td>
                        <td><span class="sp sp-delayed">Delayed</span></td>
                        <td><button class="btn-remind" onclick="toast('Reminder sent!')">Send Reminder</button></td>
                    </tr>
                    <tr>
                        <td><strong>Fazal Manan</strong></td>
                        <td>Malakand</td>
                        <td class="mono">12548-547245-6</td>
                        <td>Arms License</td>
                        <td>12 Jan 2026</td>
                        <td><strong>32</strong></td>
                        <td><span class="sp sp-delayed">Delayed</span></td>
                        <td><button class="btn-remind" onclick="toast('Reminder sent!')">Send Reminder</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ══ SECTION 2: APPLICANT TABLE ══ -->
    <div class="app-card">
        <div class="app-card-top">
            <h2>Service Delivery Applicant Details</h2>
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search" oninput="applyFilters()">
                </div>
                <select class="filter-select" id="statusFilt" onchange="applyFilters()">
                    <option value="">Omnibus</option>
                    <option value="dependency">Dependency</option>
                    <option value="pending">Pending</option>
                    <option value="delivered">Delivered</option>
                    <option value="payment">Payment</option>
                </select>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" class="form-check-input" id="selAll" onchange="toggleAll(this)"></th>
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
                <tbody id="appBody"></tbody>
            </table>
        </div>

        <div class="tbl-footer">
            <div class="left">
                Showing
                <select id="perPageSel" onchange="changePerPage()">
                    <option value="8">8</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                </select>
                of <span id="totalCount">0</span> rows per page
            </div>
            <div class="right">
                <span id="selCount" style="color:var(--muted);margin-right:12px;"></span>
                <a onclick="selectAll()">Total <span id="totalSelCount">0</span> Application Selected</a>
                &nbsp;|&nbsp;
                <a onclick="unselectAll()">Unselect All</a>
            </div>
        </div>
    </div>

    <!-- ══ REMARKS ══ -->
    <div class="remarks-card">
        <h3>Remarks</h3>
        <textarea id="remarksArea" placeholder="Enter your remarks here..."></textarea>
    </div>

    <!-- ══ SELECT OFFICER ══ -->
    <div class="officer-card">
        <h3>Select Officer &nbsp;<span style="color:var(--muted);font-weight:400;font-size:.8rem;">/ Forward to</span></h3>

        <div class="officer-search-wrap" onclick="document.getElementById('officerInput').focus()">
            <i class="fas fa-search"></i>
            <input type="text" id="officerInput" placeholder="Search Designated officer" oninput="filterOfficers()">
            <i class="fas fa-chevron-down" style="color:var(--muted);font-size:.7rem;margin-left:auto;pointer-events:none;"></i>
        </div>

        <!-- Officer dropdown suggestions -->
        <div id="officerDropdown" style="display:none;border:1px solid var(--border);border-radius:8px;background:#fff;box-shadow:0 4px 16px rgba(0,0,0,.1);margin-bottom:10px;overflow:hidden;max-height:160px;overflow-y:auto;">
        </div>

        <!-- Selected tags -->
        <div id="selectedOfficers" class="d-flex flex-wrap gap-2">
            <!-- pre-selected from screenshot -->
        </div>
    </div>

    <!-- ══ ACTION BUTTONS ══ -->
    <div class="action-bar">
        <button class="btn-action btn-revert"  onclick="toast('Reverted back')">
            <i class="fas fa-undo"></i> Revert Back
        </button>
        <button class="btn-action btn-approve" onclick="toast('Approved successfully!')">
            <i class="fas fa-check"></i> Approve
        </button>
        <button class="btn-action btn-decline" onclick="toast('Application declined')">
            <i class="fas fa-times"></i> Decline
        </button>
        <button class="btn-action btn-forward" onclick="toast('Forwarded to officer!')">
            Forward <i class="fas fa-chevron-right"></i>
        </button>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ── DATA ── */
const allApplicants = [
    { name:'Fazal Manan',  addr:'Malakand', cnic:'12548-547245-6', apply:'Arms License', date:'12 Jan 2026', approved:'Shaukhan DC-Office', status:'dependency', checked:true  },
    { name:'Jawad Khan',   addr:'Peshawar', cnic:'12548-547245-6', apply:'Arms License', date:'12 Jan 2026', approved:'Shaukhan DC-Office', status:'pending',    checked:false },
    { name:'Mustafa Jan',  addr:'Peshawar', cnic:'12548-547245-6', apply:'Arms License', date:'12 Jan 2026', approved:'Shaukhan DC-Office', status:'delivered',  checked:true  },
    { name:'Rafiullah',    addr:'Peshawar', cnic:'12548-547245-6', apply:'Arms License', date:'12 Jan 2026', approved:'Shaukhan DC-Office', status:'payment',    checked:false },
    { name:'Kashif Khan',  addr:'Peshawar', cnic:'12548-547245-6', apply:'Arms License', date:'12 Jan 2026', approved:'Shaukhan DC-Office', status:'dependency', checked:true  },
    { name:'Jawad Khan',   addr:'Peshawar', cnic:'12548-547245-6', apply:'Arms License', date:'12 Jan 2026', approved:'Shaukhan DC-Office', status:'pending',    checked:true  },
    { name:'Mustafa Jan',  addr:'Peshawar', cnic:'12548-547245-6', apply:'Arms License', date:'12 Jan 2026', approved:'Shaukhan DC-Office', status:'delivered',  checked:false },
    { name:'Rafiullah',    addr:'Peshawar', cnic:'12548-547245-6', apply:'Arms License', date:'12 Jan 2026', approved:'Shaukhan DC-Office', status:'payment',    checked:false },
    { name:'Amjad Ullah',  addr:'Mardan',   cnic:'12548-547245-6', apply:'Arms License', date:'15 Jan 2026', approved:'Shaukhan DC-Office', status:'pending',    checked:false },
    { name:'Sara Bibi',    addr:'Swat',     cnic:'12548-547245-6', apply:'Arms License', date:'15 Jan 2026', approved:'Shaukhan DC-Office', status:'delivered',  checked:false },
];

const spClass = {
    dependency: ['sp-dependency','Dependency'],
    pending:    ['sp-pending','Pending'],
    delivered:  ['sp-delivered','Delivered'],
    payment:    ['sp-payment','Payment'],
};

let filtered = [...allApplicants];
let perPage  = 8;
let page     = 1;

function applyFilters() {
    const q  = document.getElementById('searchInput').value.toLowerCase();
    const sf = document.getElementById('statusFilt').value;
    filtered = allApplicants.filter(r => {
        const mq = !q  || r.name.toLowerCase().includes(q) || r.cnic.includes(q);
        const ms = !sf || r.status === sf;
        return mq && ms;
    });
    page = 1;
    render();
}

function changePerPage() {
    perPage = parseInt(document.getElementById('perPageSel').value);
    page = 1;
    render();
}

function render() {
    const tbody = document.getElementById('appBody');
    const start = (page - 1) * perPage;
    const slice = filtered.slice(start, start + perPage);

    document.getElementById('totalCount').textContent = filtered.length;
    const selCount = allApplicants.filter(r=>r.checked).length;
    document.getElementById('selCount').textContent = '';
    document.getElementById('totalSelCount').textContent = selCount;

    if (!slice.length) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4" style="color:#7b8aaa;font-size:.82rem;">
            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>No records found</td></tr>`;
        return;
    }

    tbody.innerHTML = slice.map((r, i) => {
        const idx = start + i;
        const [cls, label] = spClass[r.status] || ['',''];
        const rowCls = r.checked ? 'row-checked' : '';
        return `
        <tr class="${rowCls}" id="row_${idx}">
            <td><input type="checkbox" class="form-check-input row-chk" data-idx="${idx}"
                ${r.checked ? 'checked' : ''} onchange="rowCheck(this)"></td>
            <td><strong>${r.name}</strong></td>
            <td>${r.addr}</td>
            <td class="mono">${r.cnic}</td>
            <td>${r.apply}</td>
            <td>${r.date}</td>
            <td style="font-size:.78rem;line-height:1.3;">${r.approved}</td>
            <td><span class="sp ${cls}">${label}</span></td>
            <td>
                <button class="icon-btn" title="View" onclick="toast('Viewing ${r.name}')"><i class="fas fa-eye"></i></button>
                <button class="icon-btn" title="Edit" onclick="toast('Editing ${r.name}')"><i class="fas fa-pen"></i></button>
            </td>
        </tr>`;
    }).join('');
}

function rowCheck(cb) {
    const idx = parseInt(cb.dataset.idx);
    allApplicants[idx].checked = cb.checked;
    const row = document.getElementById('row_' + idx);
    if (row) row.className = cb.checked ? 'row-checked' : '';
    updateSelCount();
}

function updateSelCount() {
    const c = allApplicants.filter(r=>r.checked).length;
    document.getElementById('totalSelCount').textContent = c;
}

function toggleAll(cb) {
    allApplicants.forEach(r => r.checked = cb.checked);
    render();
}

function selectAll() {
    allApplicants.forEach(r => r.checked = true);
    render();
}

function unselectAll() {
    allApplicants.forEach(r => r.checked = false);
    document.getElementById('selAll').checked = false;
    render();
}

/* ── OFFICER SELECTOR ── */
const officers = ['Abdul Ahad', 'Jawad Khan', 'Fahad Mustafa', 'Imran Shah', 'Sara Bibi', 'Nadia Javed', 'Hassan Tariq'];
let selectedOfficers = ['Abdul Ahad', 'Jawad Khan', 'Fahad Mustafa'];

function renderOfficerTags() {
    const container = document.getElementById('selectedOfficers');
    container.innerHTML = selectedOfficers.map(o => `
        <span class="officer-tag">
            ${o}
            <button class="remove" onclick="removeOfficer('${o}')" title="Remove">&times;</button>
        </span>`).join('');
}

function removeOfficer(name) {
    selectedOfficers = selectedOfficers.filter(o => o !== name);
    renderOfficerTags();
}

function filterOfficers() {
    const q = document.getElementById('officerInput').value.toLowerCase();
    const dd = document.getElementById('officerDropdown');
    if (!q) { dd.style.display = 'none'; return; }
    const matches = officers.filter(o => o.toLowerCase().includes(q) && !selectedOfficers.includes(o));
    if (!matches.length) { dd.style.display = 'none'; return; }
    dd.innerHTML = matches.map(o =>
        `<div onclick="addOfficer('${o}')" style="padding:9px 14px;cursor:pointer;font-size:.8rem;font-weight:600;
            border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'"
            onmouseout="this.style.background=''">${o}</div>`).join('');
    dd.style.display = 'block';
}

function addOfficer(name) {
    if (!selectedOfficers.includes(name)) selectedOfficers.push(name);
    document.getElementById('officerInput').value = '';
    document.getElementById('officerDropdown').style.display = 'none';
    renderOfficerTags();
}

document.addEventListener('click', e => {
    if (!e.target.closest('.officer-search-wrap') && !e.target.closest('#officerDropdown')) {
        document.getElementById('officerDropdown').style.display = 'none';
    }
});

/* ── TOAST ── */
function toast(msg) {
    let t = document.getElementById('_t');
    if (!t) {
        t = document.createElement('div');
        t.id = '_t';
        t.style.cssText = `position:fixed;bottom:22px;right:22px;background:#1a2235;color:#fff;
            padding:9px 16px;border-radius:10px;font-size:.8rem;font-weight:600;
            z-index:9999;box-shadow:0 4px 16px rgba(0,0,0,.18);transition:opacity .3s;`;
        document.body.appendChild(t);
    }
    t.textContent = msg; t.style.opacity = '1';
    clearTimeout(t._t);
    t._t = setTimeout(() => t.style.opacity = '0', 2500);
}

/* INIT */
render();
renderOfficerTags();
</script>
@endsection