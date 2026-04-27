@extends('complaint::layouts.layout')

@section('content')
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: #F4F6FA;
    color: #1e2a3a;
    font-size: 13px;
    min-height: 100vh;
    padding: 24px;
  }

  a { color: #3B82F6; text-decoration: none; }
  a:hover { text-decoration: underline; }

  /* Page title */
  .page-title {
    font-size: 15px;
    font-weight: 600;
    color: #2563EB;
    text-decoration: underline;
    margin-bottom: 18px;
  }

  /* Application ID */
  .app-id {
    font-size: 13px;
    font-weight: 600;
    color: #1e2a3a;
    margin-bottom: 16px;
  }

  /* Layout: left content + right sidebar */
  .layout {
    display: flex;
    gap: 16px;
    align-items: flex-start;
  }
  .main { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 14px; }
  .sidebar { width: 220px; flex-shrink: 0; display: flex; flex-direction: column; gap: 14px; }

  /* Card */
  .card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    padding: 16px;
  }

  /* Info grid */
  .info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 14px 10px;
  }
  .info-item label {
    display: block;
    font-size: 10px;
    color: #9ca3af;
    margin-bottom: 3px;
    font-weight: 500;
  }
  .info-item .val {
    font-size: 12.5px;
    font-weight: 500;
    color: #1e2a3a;
  }
  .info-item.full { grid-column: 1 / -1; }

  /* Arms License card (top right) */
  .arms-badge {
    background: linear-gradient(135deg, #1e3a6e 0%, #2563EB 100%);
    border-radius: 10px;
    padding: 14px;
    color: white;
    position: relative;
    overflow: hidden;
  }
  .arms-badge::after {
    content: '';
    position: absolute;
    top: -20px; right: -20px;
    width: 80px; height: 80px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
  }
  .arms-badge .badge-title { font-size: 13px; font-weight: 700; margin-bottom: 4px; }
  .arms-badge .badge-date { font-size: 10px; opacity: 0.8; margin-bottom: 2px; }
  .arms-badge .badge-id { font-size: 10px; opacity: 0.8; margin-bottom: 10px; }
  .arms-badge .qr-placeholder {
    width: 48px; height: 48px;
    background: white;
    border-radius: 4px;
    position: absolute;
    right: 14px; top: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }
  .arms-badge .qr-placeholder svg { width: 42px; height: 42px; }

  /* CNIC photos */
  .cnic-photos { display: flex; gap: 8px; }
  .cnic-photo {
    flex: 1;
    height: 56px;
    border-radius: 6px;
    background: linear-gradient(120deg, #e0e7ef 0%, #cbd5e1 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    color: #64748b;
    border: 1px solid #dde3ed;
    overflow: hidden;
    position: relative;
  }
  .cnic-photo::before {
    content: '';
    position: absolute;
    left: 0; top: 0; width: 30%; height: 100%;
    background: linear-gradient(120deg, #b6c4d8 0%, transparent 100%);
    border-radius: 4px 0 0 4px;
  }
  .cnic-label { font-size: 9px; color: #94a3b8; margin-top: 4px; text-align: center; }

  /* Section heading */
  .section-heading {
    font-size: 12px;
    font-weight: 600;
    color: #1e2a3a;
    border-bottom: 1px solid #f0f2f6;
    padding-bottom: 8px;
    margin-bottom: 12px;
  }

  /* License details grid */
  .lic-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px 12px;
  }
  .lic-item label {
    display: block;
    font-size: 10px;
    color: #9ca3af;
    margin-bottom: 3px;
    font-weight: 500;
  }
  .lic-item .val {
    font-size: 12.5px;
    font-weight: 500;
    color: #1e2a3a;
  }
  .lic-item .val.green { color: #10B981; font-weight: 600; }
  .lic-item .val.valid { color: #10B981; font-weight: 600; }
  .lic-item .val.blue  { color: #3B82F6; font-weight: 600; }
  .lic-item .val.fee   { color: #10B981; font-weight: 600; }

  /* Divider */
  .divider { border: none; border-top: 1px solid #f0f2f6; margin: 4px 0 12px; }

  /* Attachments */
  .attachment-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #f5f7fb;
  }
  .attachment-item:last-child { border-bottom: none; padding-bottom: 0; }
  .att-icon {
    width: 32px; height: 36px;
    background: #FEE2E2;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .att-icon svg { width: 16px; height: 16px; }
  .att-info { flex: 1; min-width: 0; }
  .att-name { font-size: 11px; font-weight: 600; color: #1e2a3a; }
  .att-meta { font-size: 10px; color: #9ca3af; }
  .att-actions { display: flex; gap: 8px; }
  .att-btn {
    width: 26px; height: 26px;
    border-radius: 5px;
    border: 1px solid #e5e7eb;
    background: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s;
  }
  .att-btn:hover { background: #f3f4f6; }
  .att-btn svg { width: 13px; height: 13px; }

  /* Remarks */
  .remarks-textarea {
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    padding: 10px 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    color: #6b7280;
    resize: none;
    height: 80px;
    background: #fafbfc;
    outline: none;
    transition: border-color 0.15s;
  }
  .remarks-textarea:focus { border-color: #3B82F6; background: white; }

  /* Select Officer */
  .select-officer-label {
    font-size: 12px;
    font-weight: 600;
    color: #1e2a3a;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .select-officer-label span { color: #9ca3af; font-weight: 400; font-size: 11px; }
  .officer-select {
    width: 100%;
    padding: 9px 32px 9px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    background: white;
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    color: #9ca3af;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23aaa' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    outline: none;
    cursor: pointer;
  }
  .officer-select:focus { border-color: #3B82F6; }

  /* Action buttons */
  .action-bar {
    display: flex;
    gap: 10px;
    margin-top: 16px;
    flex-wrap: wrap;
  }
  .btn {
    padding: 9px 22px;
    border-radius: 7px;
    border: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .btn-outline {
    background: white;
    border: 1px solid #d1d5db;
    color: #374151;
  }
  .btn-outline:hover { background: #f9fafb; }
  .btn-approve {
    background: #10B981;
    color: white;
  }
  .btn-approve:hover { background: #059669; }
  .btn-decline {
    background: #EF4444;
    color: white;
  }
  .btn-decline:hover { background: #dc2626; }
  .btn-forward {
    background: #1e3a6e;
    color: white;
    margin-left: auto;
  }
  .btn-forward:hover { background: #1e40af; }

  /* CNIC label row */
  .cnic-label-row {
    font-size: 10px;
    color: #9ca3af;
    margin-bottom: 6px;
    font-weight: 500;
  }
</style>
</head>
<body>

<div class="page-title">Arms License - Service Delivery Details</div>
<div class="app-id">Application ID: 123456</div>

<div class="layout">
  <!-- LEFT MAIN COLUMN -->
  <div class="main">

    <!-- Applicant Info Card -->
    <div class="card">
      <div class="info-grid">
        <div class="info-item">
          <label>Applicant Name</label>
          <div class="val">Fazal Manan</div>
        </div>
        <div class="info-item">
          <label>Father Name</label>
          <div class="val">Fazal Rahim</div>
        </div>
        <div class="info-item">
          <label>CNIC No</label>
          <div class="val">1234-45618988-5</div>
        </div>
        <div class="info-item">
          <label>Contact</label>
          <div class="val">0345 12345666</div>
        </div>
        <div class="info-item">
          <label>Tehsil</label>
          <div class="val">Batkhela</div>
        </div>
        <div class="info-item">
          <label>District</label>
          <div class="val">Malakand</div>
        </div>
        <div class="info-item full">
          <label>Address</label>
          <div class="val">Mohallah Sharifabad, Near Albarks Bank, Main Bazar Batkhela, Distt Malakand</div>
        </div>
      </div>
    </div>

    <!-- License Application Card -->
    <div class="card">
      <div class="section-heading">License Application</div>
      <div class="lic-grid">
        <div class="lic-item">
          <label>Type of License</label>
          <div class="val">Arms License</div>
        </div>
        <div class="lic-item">
          <label>License Fee</label>
          <div class="val fee">Rs. 5000</div>
        </div>
        <div class="lic-item">
          <label>Type</label>
          <div class="val">Pistol</div>
        </div>
        <div class="lic-item">
          <label>License No</label>
          <div class="val blue">ARM123</div>
        </div>
        <div class="lic-item">
          <label>License Validity</label>
          <div class="val">DD/MM/YY</div>
        </div>
        <div class="lic-item">
          <label>License</label>
          <div class="val green">Attached</div>
        </div>
        <div class="lic-item">
          <label>Address</label>
          <div class="val">Main Bazar Batkhela, Distt Malakand</div>
        </div>
        <div class="lic-item">
          <label>Status</label>
          <div class="val valid">Valid</div>
        </div>
      </div>
    </div>

    <!-- Remarks -->
    <div class="card">
      <div class="section-heading">Remarks</div>
      <textarea class="remarks-textarea" placeholder="Enter your remarks here..."></textarea>
    </div>

    <!-- Select Officer -->
    <div class="card">
      <div class="select-officer-label">
        Select Officer <span>/ Forward to</span>
      </div>
      <select class="officer-select">
        <option value="" disabled selected>Section Officer</option>
        <option>District Officer</option>
        <option>Deputy Commissioner</option>
        <option>Commissioner</option>
      </select>

      <div class="action-bar">
        <button class="btn btn-outline">Revert Back</button>
        <button class="btn btn-approve">Approve</button>
        <button class="btn btn-decline">Decline</button>
        <button class="btn btn-forward">Forward &rsaquo;</button>
      </div>
    </div>

  </div>

  <!-- RIGHT SIDEBAR -->
  <div class="sidebar">

    <!-- Arms License Badge -->
    <div class="arms-badge">
      <div class="badge-title">Arms License</div>
      <div class="badge-date">Aug 01 2025</div>
      <div class="badge-id">KP - 2025 - 00000232</div>
      <div class="qr-placeholder">
        <!-- QR Code SVG placeholder -->
        <svg viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="2" y="2" width="16" height="16" rx="1" fill="none" stroke="#000" stroke-width="2"/>
          <rect x="6" y="6" width="8" height="8" fill="#000"/>
          <rect x="24" y="2" width="16" height="16" rx="1" fill="none" stroke="#000" stroke-width="2"/>
          <rect x="28" y="6" width="8" height="8" fill="#000"/>
          <rect x="2" y="24" width="16" height="16" rx="1" fill="none" stroke="#000" stroke-width="2"/>
          <rect x="6" y="28" width="8" height="8" fill="#000"/>
          <rect x="24" y="24" width="4" height="4" fill="#000"/>
          <rect x="30" y="24" width="4" height="4" fill="#000"/>
          <rect x="36" y="24" width="4" height="4" fill="#000"/>
          <rect x="24" y="30" width="4" height="4" fill="#000"/>
          <rect x="30" y="30" width="4" height="4" fill="#000"/>
          <rect x="36" y="36" width="4" height="4" fill="#000"/>
          <rect x="24" y="36" width="4" height="4" fill="#000"/>
          <rect x="36" y="30" width="4" height="4" fill="#000"/>
        </svg>
      </div>
    </div>

    <!-- CNIC Photos -->
    <div class="card">
      <div class="cnic-label-row">CNIC Photos</div>
      <div class="cnic-photos">
        <div>
          <div class="cnic-photo">
            <svg width="36" height="24" viewBox="0 0 36 24" fill="none">
              <rect width="36" height="24" rx="3" fill="#dde6f0"/>
              <rect x="2" y="2" width="10" height="12" rx="1" fill="#b0bec5"/>
              <line x1="15" y1="5" x2="34" y2="5" stroke="#90a0b0" stroke-width="1.2"/>
              <line x1="15" y1="9" x2="28" y2="9" stroke="#90a0b0" stroke-width="1.2"/>
              <line x1="15" y1="13" x2="30" y2="13" stroke="#90a0b0" stroke-width="1.2"/>
              <line x1="2" y1="18" x2="34" y2="18" stroke="#90a0b0" stroke-width="0.8"/>
            </svg>
          </div>
          <div class="cnic-label">Front</div>
        </div>
        <div>
          <div class="cnic-photo">
            <svg width="36" height="24" viewBox="0 0 36 24" fill="none">
              <rect width="36" height="24" rx="3" fill="#dde6f0"/>
              <line x1="2" y1="5" x2="34" y2="5" stroke="#90a0b0" stroke-width="1.2"/>
              <line x1="2" y1="9" x2="26" y2="9" stroke="#90a0b0" stroke-width="1.2"/>
              <line x1="2" y1="13" x2="30" y2="13" stroke="#90a0b0" stroke-width="1.2"/>
              <line x1="2" y1="17" x2="34" y2="17" stroke="#90a0b0" stroke-width="0.8"/>
              <rect x="2" y="19" width="32" height="3" rx="1" fill="#b0bec5"/>
            </svg>
          </div>
          <div class="cnic-label">Back</div>
        </div>
      </div>
    </div>

    <!-- Attachments -->
    <div class="card">
      <div class="section-heading">Attachments</div>

      <div class="attachment-item">
        <div class="att-icon">
          <!-- PDF icon -->
          <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="16" height="16" rx="3" fill="#FEE2E2"/>
            <text x="2" y="12" font-size="7" font-weight="bold" fill="#EF4444" font-family="sans-serif">PDF</text>
          </svg>
        </div>
        <div class="att-info">
          <div class="att-name">File Title.pdf</div>
          <div class="att-meta">312KB · 21 Aug, 2022</div>
        </div>
        <div class="att-actions">
          <button class="att-btn" title="Download">
            <svg viewBox="0 0 13 13" fill="none"><path d="M6.5 2v6M3.5 6l3 3 3-3" stroke="#6b7280" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 10h9" stroke="#6b7280" stroke-width="1.3" stroke-linecap="round"/></svg>
          </button>
          <button class="att-btn" title="Delete">
            <svg viewBox="0 0 13 13" fill="none"><path d="M2 3.5h9M5 3.5V2.5h3v1M5.5 5.5v4M7.5 5.5v4M3.5 3.5l.5 7h5l.5-7" stroke="#EF4444" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
      </div>

      <div class="attachment-item">
        <div class="att-icon">
          <svg viewBox="0 0 16 16" fill="none">
            <rect width="16" height="16" rx="3" fill="#FEE2E2"/>
            <text x="2" y="12" font-size="7" font-weight="bold" fill="#EF4444" font-family="sans-serif">PDF</text>
          </svg>
        </div>
        <div class="att-info">
          <div class="att-name">File Title.pdf</div>
          <div class="att-meta">312KB · 21 Aug, 2022</div>
        </div>
        <div class="att-actions">
          <button class="att-btn" title="Download">
            <svg viewBox="0 0 13 13" fill="none"><path d="M6.5 2v6M3.5 6l3 3 3-3" stroke="#6b7280" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 10h9" stroke="#6b7280" stroke-width="1.3" stroke-linecap="round"/></svg>
          </button>
          <button class="att-btn" title="Delete">
            <svg viewBox="0 0 13 13" fill="none"><path d="M2 3.5h9M5 3.5V2.5h3v1M5.5 5.5v4M7.5 5.5v4M3.5 3.5l.5 7h5l.5-7" stroke="#EF4444" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
      </div>

      <div class="attachment-item">
        <div class="att-icon">
          <svg viewBox="0 0 16 16" fill="none">
            <rect width="16" height="16" rx="3" fill="#FEE2E2"/>
            <text x="2" y="12" font-size="7" font-weight="bold" fill="#EF4444" font-family="sans-serif">PDF</text>
          </svg>
        </div>
        <div class="att-info">
          <div class="att-name">File Title.pdf</div>
          <div class="att-meta">312KB · 21 Aug, 2022</div>
        </div>
        <div class="att-actions">
          <button class="att-btn" title="Download">
            <svg viewBox="0 0 13 13" fill="none"><path d="M6.5 2v6M3.5 6l3 3 3-3" stroke="#6b7280" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 10h9" stroke="#6b7280" stroke-width="1.3" stroke-linecap="round"/></svg>
          </button>
          <button class="att-btn" title="Delete">
            <svg viewBox="0 0 13 13" fill="none"><path d="M2 3.5h9M5 3.5V2.5h3v1M5.5 5.5v4M7.5 5.5v4M3.5 3.5l.5 7h5l.5-7" stroke="#EF4444" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
      </div>

    </div>
  </div><!-- /sidebar -->
</div><!-- /layout -->
</body>
@endsection