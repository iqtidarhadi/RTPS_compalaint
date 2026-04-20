@extends('layouts.layout')
@section('content')
    <!-- Bootstrap 5 + Icons + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f8;
            color: #1e293b;
            padding: 30px 24px;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Section */
        .header-section {
            margin-bottom: 28px;
        }
        .header-section h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f3b5f;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }
        .header-section h1 i {
            color: #2d6a4f;
        }
        .badge-office {
            background: #e9ecef;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #495057;
            display: inline-block;
        }

        /* Stats Cards (Total, Approved, Pending) */
        .stats-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: white;
            border-radius: 24px;
            padding: 20px 24px;
            flex: 1;
            min-width: 180px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.1);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 16px;
        }
        .stat-value {
            font-size: 2.2rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .bg-soft-blue { background: #eef2ff; color: #3b82f6; }
        .bg-soft-green { background: #e0f2e9; color: #2b7a4b; }
        .bg-soft-amber { background: #fef3c7; color: #d97706; }

        /* Two Column Layout: Profile Card + Table */
        .content-grid {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 28px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            height: fit-content;
        }
        .profile-cover {
            background: linear-gradient(135deg, #1e4a6e 0%, #0f3b5f 100%);
            padding: 28px 24px 20px;
            text-align: center;
        }
        .avatar-circle {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.15);
        }
        .avatar-circle i {
            font-size: 3rem;
            color: #1e4a6e;
        }
        .profile-name {
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 6px;
        }
        .profile-id {
            font-size: 0.75rem;
            color: #cbd5e1;
            background: rgba(255,255,255,0.2);
            display: inline-block;
            padding: 4px 12px;
            border-radius: 40px;
        }
        .profile-details {
            padding: 20px 24px;
        }
        .detail-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
            font-size: 0.85rem;
        }
        .detail-icon {
            width: 32px;
            color: #64748b;
            font-size: 1rem;
            text-align: center;
        }
        .detail-text {
            flex: 1;
            color: #334155;
            line-height: 1.4;
        }
        .detail-label {
            font-weight: 700;
            color: #0f172a;
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 2px;
        }
        .address-text {
            font-size: 0.85rem;
            color: #475569;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 28px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }
        .table-header {
            padding: 18px 24px;
            border-bottom: 1px solid #eef2ff;
            background: #ffffff;
        }
        .table-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }
        .table-header h3 i {
            color: #2d6a4f;
        }
        .table-responsive-wrap {
            overflow-x: auto;
        }
        .applicant-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }
        .applicant-table th {
            padding: 14px 16px;
            background: #fafcff;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #5b6e8c;
            border-bottom: 1px solid #e9edf2;
        }
        .applicant-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f0f2f8;
            font-size: 0.85rem;
            vertical-align: middle;
        }
        .applicant-table tr:hover td {
            background: #fafbff;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 700;
        }
        .status-delivered {
            background: #e0f2e9;
            color: #1e6f3f;
        }
        .status-pending {
            background: #fff3e0;
            color: #b45309;
        }
        .action-icon {
            color: #ef4444;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.15s;
            background: none;
            border: none;
        }
        .action-icon:hover {
            color: #b91c1c;
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 900px) {
            body { padding: 20px 16px; }
            .content-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .stats-row { gap: 12px; }
            .stat-card { padding: 16px; }
            .stat-value { font-size: 1.8rem; }
        }
        @media (max-width: 550px) {
            .stats-row { flex-direction: column; }
        }

        /* Toast */
        .toast-custom {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1100;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid #2d6a4f;
            font-size: 0.85rem;
            font-weight: 500;
            transform: translateX(120%);
            transition: transform 0.3s ease;
        }
        .toast-custom.show {
            transform: translateX(0);
        }
        .toast-custom i {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- Header -->
    <div class="header-section">
        <h1>
            <i class="fas fa-user-circle"></i> 
            Applicant Dashboard
        </h1>
        <div class="badge-office">
            <i class="fas fa-building me-1"></i> Deputy Commissioner Office · Malakand District
        </div>
    </div>

    <!-- Stats Cards: Total Applications, Approved, Pending -->
    <div class="stats-row" id="statsRow">
        <div class="stat-card">
            <div class="stat-icon bg-soft-blue"><i class="fas fa-file-alt"></i></div>
            <div class="stat-value" id="totalApps">05</div>
            <div class="stat-label">Total Applications</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-soft-green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value" id="approvedApps">03</div>
            <div class="stat-label">Approved / Delivered</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-soft-amber"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-value" id="pendingApps">02</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    <!-- Main Grid: Profile + Table -->
    <div class="content-grid">
        <!-- LEFT: Profile Card -->
        <div class="profile-card">
            <div class="profile-cover">
                <div class="avatar-circle">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="profile-name">Fazal Manan</div>
                <div class="profile-id">15424-65475245</div>
            </div>
            <div class="profile-details">
                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-user"></i></div>
                    <div class="detail-text">
                        <span class="detail-label">Father Name</span>
                        Fazal Rahim
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-id-card"></i></div>
                    <div class="detail-text">
                        <span class="detail-label">CNIC No</span>
                        1234-4561898-5
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="detail-text">
                        <span class="detail-label">Contact</span>
                        0345 12345666
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-map-pin"></i></div>
                    <div class="detail-text">
                        <span class="detail-label">Tehsil</span>
                        Batkhela
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-globe-asia"></i></div>
                    <div class="detail-text">
                        <span class="detail-label">District</span>
                        Malakand
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-home"></i></div>
                    <div class="detail-text">
                        <span class="detail-label">Address</span>
                        <div class="address-text">Mohallah Sharifabad, Near Albarka Bank, Main Bazar Batkhela, Distt Malakand</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Service Delivery Table -->
        <div class="table-card">
            <div class="table-header">
                <h3>
                    <i class="fas fa-tasks"></i> 
                    Service Delivery Applicant Details
                </h3>
            </div>
            <div class="table-responsive-wrap">
                <table class="applicant-table">
                    <thead>
                        <tr>
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
                    <tbody id="applicationTableBody">
                        <!-- dynamic rows -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toastMsg" class="toast-custom">
    <i class="fas fa-trash-alt"></i>
    <span id="toastText">Application removed</span>
</div>

<script>
    // --------------------------------------------------------------
    // DATA as per screenshot: Fazal Manan applications
    // --------------------------------------------------------------
    let applications = [
        { id: 1, name: "Fazal Manan", address: "Malakand", cnic: "12548-547245-6", applyFor: "Arms License", date: "12 Jan 2026", approvedBy: "Shaukhan DC-Office", status: "Delivered" },
        { id: 2, name: "Fazal Manan", address: "Malakand", cnic: "12548-547245-6", applyFor: "Food Grin", date: "12 Jan 2026", approvedBy: "Shaukhan DC-Office", status: "Pending" },
        { id: 3, name: "Fazal Manan", address: "Malakand", cnic: "12548-547245-6", applyFor: "Driving License", date: "12 Jan 2026", approvedBy: "Shaukhan DC-Office", status: "Delivered" },
        { id: 4, name: "Fazal Manan", address: "Malakand", cnic: "12548-547245-6", applyFor: "Godowns", date: "12 Jan 2026", approvedBy: "Shaukhan DC-Office", status: "Pending" },
        { id: 5, name: "Fazal Manan", address: "Malakand", cnic: "12548-547245-6", applyFor: "Arms License", date: "12 Jan 2026", approvedBy: "Shaukhan DC-Office", status: "Delivered" }
    ];

    // Helper function to update stats (Total, Approved, Pending)
    function updateStats() {
        const total = applications.length;
        const approved = applications.filter(app => app.status === "Delivered").length;
        const pending = applications.filter(app => app.status === "Pending").length;
        
        document.getElementById('totalApps').innerText = total.toString().padStart(2, '0');
        document.getElementById('approvedApps').innerText = approved.toString().padStart(2, '0');
        document.getElementById('pendingApps').innerText = pending.toString().padStart(2, '0');
    }

    // Render table rows
    function renderTable() {
        const tbody = document.getElementById('applicationTableBody');
        if (!applications.length) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-5 text-muted">No applications found</td></tr>`;
            updateStats();
            return;
        }

        tbody.innerHTML = applications.map(app => `
            <tr>
                <td><strong>${app.name}</strong></td>
                <td>${app.address}</td>
                <td>${app.cnic}</td>
                <td>${app.applyFor}</td>
                <td>${app.date}</td>
                <td>${app.approvedBy}</td>
                <td>
                    <span class="status-badge ${app.status === 'Delivered' ? 'status-delivered' : 'status-pending'}">
                        <i class="fas ${app.status === 'Delivered' ? 'fa-check-circle' : 'fa-clock'}"></i>
                        ${app.status}
                    </span>
                </td>
                <td>
                    <button class="action-icon" onclick="deleteApplication(${app.id})" title="Delete Application">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `).join('');
        
        updateStats();
    }

    // Delete application with confirmation & toast
    function deleteApplication(id) {
        const app = applications.find(a => a.id === id);
        if (!app) return;
        
        // confirmation dialog (optional but user-friendly)
        if (confirm(`Are you sure you want to delete application for "${app.applyFor}"?`)) {
            applications = applications.filter(a => a.id !== id);
            renderTable();
            showToast(`Application for "${app.applyFor}" has been removed`, '#ef4444');
        }
    }

    // Toast notification function
    let toastTimeout;
    function showToast(message, borderColor = '#2d6a4f') {
        const toastEl = document.getElementById('toastMsg');
        const toastTextSpan = document.getElementById('toastText');
        toastTextSpan.innerText = message;
        toastEl.style.borderLeftColor = borderColor;
        toastEl.classList.add('show');
        
        if (toastTimeout) clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toastEl.classList.remove('show');
        }, 2800);
    }

    // initial render
    renderTable();
    
    // Optional: Export functionality (if needed)
    console.log("Dashboard ready — Fazal Manan portal");
</script>
@endsection