
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
            margin-bottom: 10px;
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
        .trend.none { color: var(--muted); }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .si-purple { background: #ede9fe; color: #8b5cf6; }
        .si-orange { background: #fff4e5; color: #f5a623; }
        .si-teal   { background: #e6faf3; color: #22c98e; }
        .si-pink   { background: #fff0f0; color: #f47c7c; }

        .main-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 2px solid #4a90d9;
            box-shadow: 0 2px 12px rgba(74,144,217,0.10);
            overflow: visible;
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 14px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .card-top h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
        }

        .month-select {
            padding: 6px 30px 6px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237b8aaa' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center;
            appearance: none;
            cursor: pointer;
        }
        .month-select:focus { outline: none; border-color: var(--blue); }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }

        thead tr th {
            background: #fff;
            padding: 10px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text);
            border-top: 1px solid var(--border);
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }

        tbody tr td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text);
            font-size: 0.855rem;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fafbfd; }

        .svc-cell {
            display: flex;
            align-items: center;
            gap: 11px;
        }
        .svc-logo {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #e6f4ea;
            border: 2px solid #b7dfc1;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 0.7rem;
            font-weight: 800;
            color: #2e7d32;
        }
        .svc-name { font-weight: 600; font-size: 0.855rem; }

        .perf-pill {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.72rem;
            font-weight: 700;
            text-align: center;
            line-height: 1.3;
            white-space: nowrap;
            min-width: 90px;
        }
        .p-satisfactory      { background: #22c98e; color: #fff; }
        .p-average           { background: #f5a623; color: #fff; }
        .p-below-satisfactory{ background: #f04e4e; color: #fff; }
        .p-below-average     { background: #ff9800; color: #fff; }
        .p-excellent         { background: #3b7cff; color: #fff; }

        .action-wrap { position: relative; display: inline-block; }
        .btn-dots {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            color: var(--muted);
            font-size: 1rem;
            transition: background .15s;
        }
        .btn-dots:hover { background: #f1f5f9; color: var(--text); }
        .action-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 4px);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            min-width: 180px;
            z-index: 100;
            overflow: hidden;
        }
        .action-dropdown.show { display: block; }
        .action-dropdown a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
            transition: background .15s;
        }
        .action-dropdown a:hover { background: #f8fafc; }
        .action-dropdown a i { color: var(--muted); font-size: 0.8rem; }

        .pag-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            font-size: 0.8rem;
            color: var(--muted);
            flex-wrap: wrap;
            gap: 10px;
        }
        .num { text-align: center; }
        .num-h { text-align: center; }

        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            body { padding: 14px 10px; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stat-card .val { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

<h1>
    <i class="fas fa-chart-line"></i> 
    Dashboard - KP RTPS | DC Office Peshawar
</h1>

<!-- STAT CARDS -->
<div class="stats-grid">
    <div class="stat-card">
        <div>
            <div class="label">Critically Delayed</div>
            <div class="val">2,845</div>
            <span class="trend none">—</span>
        </div>
        <div class="stat-icon si-purple"><i class="fas fa-user-friends"></i></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="label">Delivered Services</div>
            <div class="val">18,293</div>
            <span class="trend up"><i class="fas fa-arrow-trend-up"></i> 1.3% Up from past week</span>
        </div>
        <div class="stat-icon si-orange"><i class="fas fa-box"></i></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="label">Ontime Delivered</div>
            <div class="val">12,423</div>
            <span class="trend down"><i class="fas fa-arrow-trend-down"></i> 4.3% Down from yesterday</span>
        </div>
        <div class="stat-icon si-teal"><i class="fas fa-chart-line"></i></div>
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

<!-- SERVICE DELIVERY TABLE - Updated with Screenshot Data -->
<div class="main-card">
    <div class="card-top">
        <h2><i class="fas fa-list-ul me-2"></i> Service Delivery Details (DC Office Peshawar)</h2>
        <select class="month-select" id="monthSelect" onchange="filterMonth()">
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
                    <th>Service Title</th>
                    <th>Department</th>
                    <th>Notified Timelines<br>As per RTPS</th>
                    <th class="num-h">Total<br>Applications</th>
                    <th class="num-h">Delivered<br>on time</th>
                    <th class="num-h">Delayed</th>
                    <th class="num-h">Critically<br>Delayed</th>
                    <th>Performance</th>
                    <th>Take<br>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>

    <div class="pag-row">
        <span id="showInfo"></span>
        <nav><ul class="pagination pagination-sm mb-0" id="pagination"></ul></nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ============================================================
   DATA MAPPED EXACTLY FROM SCREENSHOT (DC Office Peshawar)
   Types of Service + Department + Official Time Limit
   All services under BOARD OF REVENUE/DC OFFICE as per image
   with realistic application volumes and performance metrics
============================================================ */

const servicesFromScreenshot = [
    { service: "All Pakistan Cartridge Increase", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "10 days", limitDays: 10 },
    { service: "Demarcation of Land", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "30 Days", limitDays: 30 },
    { service: "Domicile", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "10 days", limitDays: 10 },
    { service: "FARD", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "3 Days", limitDays: 3 },
    { service: "Inheritance Mutation (Entry in Roznamcha & Revenue Record)", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "30 Days", limitDays: 30 },
    { service: "Attestation (Revenue Record)", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "30 Days", limitDays: 30 },
    { service: "Issuance of Arms License", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "15 days after Verification", limitDays: 15 },
    { service: "Issuance of Certified Copies of Registered Documents", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "3 Days", limitDays: 3 },
    { service: "Processing of Arms License", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "07 days", limitDays: 7 },
    { service: "Verification of Arms Applicant", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "15 days", limitDays: 15 }
];

// Generate realistic data for each service with application volumes
function generatePerformanceData(serviceItem, month) {
    // Base volumes - realistic for a DC office
    const baseTotal = Math.floor(Math.random() * 180) + 40; // 40-220 applications
    const performanceRandom = Math.random();
    
    let ontimePct, delayedPct, criticalPct;
    if (performanceRandom < 0.3) {
        // Excellent performance
        ontimePct = 0.75 + Math.random() * 0.2;
        delayedPct = 0.05 + Math.random() * 0.1;
        criticalPct = 0.02 + Math.random() * 0.05;
    } else if (performanceRandom < 0.6) {
        // Average performance
        ontimePct = 0.45 + Math.random() * 0.2;
        delayedPct = 0.2 + Math.random() * 0.15;
        criticalPct = 0.1 + Math.random() * 0.1;
    } else {
        // Poor performance
        ontimePct = 0.2 + Math.random() * 0.2;
        delayedPct = 0.3 + Math.random() * 0.2;
        criticalPct = 0.2 + Math.random() * 0.2;
    }
    
    // Normalize to sum to 1
    const total = ontimePct + delayedPct + criticalPct;
    ontimePct = ontimePct / total;
    delayedPct = delayedPct / total;
    criticalPct = criticalPct / total;
    
    const totalApps = baseTotal;
    const ontime = Math.round(totalApps * ontimePct);
    const delayed = Math.round(totalApps * delayedPct);
    const critical = totalApps - ontime - delayed;
    
    // Determine performance label
    const perfRatio = ontime / totalApps;
    let perf, perfLabel;
    if (perfRatio >= 0.75) {
        perf = 'excellent';
        perfLabel = 'Excellent';
    } else if (perfRatio >= 0.6) {
        perf = 'satisfactory';
        perfLabel = 'Satisfactory';
    } else if (perfRatio >= 0.45) {
        perf = 'average';
        perfLabel = 'Average';
    } else if (perfRatio >= 0.3) {
        perf = 'below-average';
        perfLabel = 'Below Average';
    } else {
        perf = 'below-satisfactory';
        perfLabel = 'Below Satisfactory';
    }
    
    return {
        service: serviceItem.service,
        dept: serviceItem.dept,
        timeline: serviceItem.timeline,
        total: totalApps,
        ontime: ontime,
        delayed: delayed,
        critical: critical,
        perf: perf,
        perfLabel: perfLabel,
        month: month
    };
}

// Build dataset for October and November
let allData = [];
const months = [10, 10, 10, 10, 11, 11];

servicesFromScreenshot.forEach((svc, idx) => {
    // Generate for October (month 10)
    allData.push(generatePerformanceData(svc, 10));
    // Generate for November (month 11) with slightly different volumes
    allData.push(generatePerformanceData(svc, 11));
});

// Add a few additional entries for variety
allData.push({
    service: "Property Transfer (Mutation)", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "30 Days",
    total: 95, ontime: 28, delayed: 42, critical: 25, perf: 'below-satisfactory', perfLabel: 'Below Satisfactory', month: 10
});
allData.push({
    service: "Fard/Extract of Revenue Record", dept: "BOARD OF REVENUE/DC OFFICE", timeline: "3 Days",
    total: 210, ontime: 145, delayed: 48, critical: 17, perf: 'average', perfLabel: 'Average', month: 11
});

// Sort by service name for consistency
allData.sort((a, b) => a.service.localeCompare(b.service));

const perfClass = {
    'satisfactory':        'p-satisfactory',
    'average':             'p-average',
    'below-satisfactory':  'p-below-satisfactory',
    'below-average':       'p-below-average',
    'excellent':           'p-excellent'
};

function initials(s) {
    return s.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
}

let rows = [...allData];
let page = 1;
const PER = 8;

function render() {
    const tbody = document.getElementById('tableBody');
    const start = (page - 1) * PER;
    const slice = rows.slice(start, start + PER);

    if (!slice.length) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-5" style="color:#7b8aaa;">
            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>No records found</td></tr>`;
        document.getElementById('showInfo').textContent = 'No records';
        document.getElementById('pagination').innerHTML = '';
        return;
    }

    tbody.innerHTML = slice.map((r, i) => {
        const uid = `dd_${start + i}_${Date.now()}_${Math.random()}`;
        return `
        <tr>
            <td>
                <div class="svc-cell">
                    <div class="svc-logo">${initials(r.service)}</div>
                    <span class="svc-name">${r.service}</span>
                </div>
            </td>
            <td><span class="svc-name" style="font-weight:500;">${r.dept}</span></td>
            <td><span class="perf-pill" style="background:#eef2ff; color:#1e3a5f;">${r.timeline}</span></td>
            <td class="num"><strong>${r.total}</strong></td>
            <td class="num" style="color: #22c98e; font-weight:600;">${r.ontime}</td>
            <td class="num" style="color: #f5a623; font-weight:600;">${r.delayed}</td>
            <td class="num" style="color: #f04e4e; font-weight:600;">${r.critical}</td>
            <td>
                <span class="perf-pill ${perfClass[r.perf] || ''}">${r.perfLabel}</span>
            </td>
            <td>
                <div class="action-wrap" id="wrap_${uid}">
                    <button class="btn-dots" onclick="toggleDD('${uid}')">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="action-dropdown" id="${uid}">
                        <a href="#" onclick="showToast('Intimated ${r.service} department', 'success'); return false;">
                            <i class="fas fa-paper-plane"></i> Intimate Department
                        </a>
                        <a href="#" onclick="showToast('Disciplinary action initiated for ${r.service}', 'warning'); return false;">
                            <i class="fas fa-gavel"></i> Take Disciplinary Action
                        </a>
                        <a href="#" onclick="viewServiceDetails('${r.service}', '${r.dept}', ${r.total}, ${r.ontime}, ${r.delayed}, ${r.critical}, '${r.timeline}'); return false;">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>
                </div>
            </td>
        </tr>`;
    }).join('');

    const end = Math.min(start + PER, rows.length);
    document.getElementById('showInfo').textContent = `Showing ${start+1}–${end} of ${rows.length} service records`;
    renderPag();
}

function renderPag() {
    const total = Math.ceil(rows.length / PER);
    const ul = document.getElementById('pagination');
    if (total <= 1) { ul.innerHTML = ''; return; }

    const li = (p, label, dis, act) =>
        `<li class="page-item ${dis?'disabled':''} ${act?'active':''}">
            <a class="page-link" href="#" onclick="goPage(${p});return false;">${label}</a>
         </li>`;

    let h = li(page-1,'&laquo;', page===1, false);
    let startPage = Math.max(1, page - 2);
    let endPage = Math.min(total, startPage + 4);
    if (endPage - startPage < 4 && startPage > 1) startPage = Math.max(1, endPage - 4);
    
    for (let p = startPage; p <= endPage; p++) h += li(p, p, false, p===page);
    h += li(page+1,'&raquo;', page===total, false);
    ul.innerHTML = h;
}

function goPage(p) {
    const total = Math.ceil(rows.length / PER);
    if (p < 1 || p > total) return;
    closeAllDD();
    page = p;
    render();
}

function filterMonth() {
    const m = document.getElementById('monthSelect').value;
    rows = m ? allData.filter(r => r.month.toString() === m) : [...allData];
    page = 1;
    render();
}

function toggleDD(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const isOpen = el.classList.contains('show');
    closeAllDD();
    if (!isOpen) el.classList.add('show');
}

function closeAllDD() {
    document.querySelectorAll('.action-dropdown.show').forEach(d => d.classList.remove('show'));
}

function showToast(msg, type = 'success') {
    // Simple alert for demo - can be replaced with proper toast
    alert(msg);
}

function viewServiceDetails(service, dept, total, ontime, delayed, critical, timeline) {
    const delayedRate = ((delayed / total) * 100).toFixed(1);
    const criticalRate = ((critical / total) * 100).toFixed(1);
    const ontimeRate = ((ontime / total) * 100).toFixed(1);
    
    alert(`📋 Service Details\n\n` +
          `Service: ${service}\n` +
          `Department: ${dept}\n` +
          `Time Limit: ${timeline}\n` +
          `Total Applications: ${total}\n` +
          `✅ On-time: ${ontime} (${ontimeRate}%)\n` +
          `⚠️ Delayed: ${delayed} (${delayedRate}%)\n` +
          `🔴 Critically Delayed: ${critical} (${criticalRate}%)\n\n` +
          `Performance Score: ${(ontimeRate)}% delivery rate`);
}

document.addEventListener('click', e => {
    if (!e.target.closest('.action-wrap')) closeAllDD();
});

// Initialize
filterMonth();
</script>
@endsection
