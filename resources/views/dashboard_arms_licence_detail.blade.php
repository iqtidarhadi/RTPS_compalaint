@extends('layouts.layout')
@section('content')
  <!-- Bootstrap 5 + Font Awesome + Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f1f5f9;
      color: #0f172a;
      font-size: 13px;
      padding: 16px 12px;
    }

    .dashboard-full {
      max-width: 1600px;
      margin: 0 auto;
      width: 100%;
    }

    /* Header - compact */
    .page-header {
      margin-bottom: 16px;
      border-left: 4px solid #3b7cff;
      padding-left: 12px;
    }
    .page-header h1 {
      font-size: 1.4rem;
      font-weight: 800;
      color: #0a2540;
      margin-bottom: 2px;
      letter-spacing: -0.3px;
    }
    .page-header .app-badge {
      font-size: 0.7rem;
      font-weight: 600;
      color: #3b7cff;
      background: #eef2ff;
      display: inline-block;
      padding: 2px 10px;
      border-radius: 40px;
    }

    /* Cards - zero extra padding */
    .glass-card {
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid #e2edf2;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
      overflow: hidden;
    }

    /* Ultra compact spacing */
    .field-label {
      font-size: 0.6rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      color: #5b6e8c;
      margin-bottom: 1px;
    }
    .field-value {
      font-size: 0.78rem;
      font-weight: 600;
      color: #0f172a;
      word-break: break-word;
      line-height: 1.3;
    }

    /* Licence badge - ultra compact */
    .licence-badge {
      background: linear-gradient(135deg, #1e4a6e 0%, #0f3b5f 100%);
      border-radius: 12px;
      padding: 10px 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      flex-wrap: wrap;
    }
    .licence-badge .badge-title {
      font-size: 0.85rem;
      font-weight: 800;
      color: white;
    }
    .licence-badge .badge-date {
      font-size: 0.6rem;
      opacity: 0.85;
      color: #e2e8f0;
      line-height: 1.2;
    }
    .qr-code-box {
      background: white;
      border-radius: 8px;
      padding: 3px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
    }
    .qr-code-box canvas {
      width: 100%;
      height: auto;
    }

    /* CNIC photos - compact */
    .cnic-grid {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }
    .cnic-card {
      flex: 1;
      background: #fafcff;
      border: 1px solid #e2edf2;
      border-radius: 10px;
      padding: 6px 8px;
      text-align: center;
    }
    .cnic-card .cnic-icon {
      font-size: 1.4rem;
      margin-bottom: 2px;
    }
    .cnic-card .cnic-icon i {
      color: #3b7cff;
    }
    .cnic-card.back .cnic-icon i {
      color: #f5a623;
    }
    .cnic-label-sm {
      font-size: 0.6rem;
      font-weight: 600;
      color: #475569;
    }
    .cnic-status {
      font-size: 0.55rem;
      color: #22c98e;
      margin-top: 2px;
    }

    /* Attachments - compact */
    .att-item {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #fafcff;
      border-radius: 10px;
      padding: 6px 10px;
      margin-bottom: 4px;
      border: 1px solid #eef2f8;
    }
    .att-item:last-child {
      margin-bottom: 0;
    }
    .att-pdf-icon {
      width: 28px;
      height: 28px;
      background: #fee2e2;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ef4444;
      font-weight: 800;
      font-size: 0.6rem;
    }
    .att-details {
      flex: 1;
    }
    .att-name {
      font-weight: 700;
      font-size: 0.7rem;
      line-height: 1.2;
    }
    .att-meta {
      font-size: 0.55rem;
      color: #7c8ba0;
    }
    .att-actions {
      display: flex;
      gap: 4px;
    }
    .icon-btn {
      background: transparent;
      border: none;
      cursor: pointer;
      font-size: 0.7rem;
      color: #7c8ba0;
      transition: 0.15s;
      padding: 2px;
    }
    .icon-btn:hover {
      color: #ef4444;
    }
    .icon-btn.dl:hover {
      color: #3b7cff;
    }

    /* Remarks - compact */
    .remarks-area {
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid #e2edf2;
      padding: 10px 12px;
    }
    .remarks-area textarea {
      width: 100%;
      border: 1px solid #e2edf2;
      border-radius: 10px;
      padding: 6px 10px;
      font-family: 'Inter', monospace;
      font-size: 0.7rem;
      resize: vertical;
      background: #fff;
    }
    .remarks-area textarea:focus {
      outline: none;
      border-color: #3b7cff;
    }

    /* Officer select - compact */
    .officer-select {
      width: 100%;
      padding: 6px 10px;
      border-radius: 10px;
      border: 1px solid #e2edf2;
      font-family: 'Inter', sans-serif;
      font-size: 0.7rem;
      background: white;
      cursor: pointer;
    }

    /* Action buttons - compact */
    .action-group {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
    }
    .action-btn {
      padding: 5px 12px;
      border-radius: 40px;
      font-weight: 700;
      font-size: 0.7rem;
      border: 1px solid transparent;
      transition: 0.2s;
      background: white;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .action-btn.revert {
      border-color: #cbd5e1;
      color: #1e293b;
    }
    .action-btn.approve {
      border-color: #22c98e;
      color: #1e7a4a;
      background: #f0fdf4;
    }
    .action-btn.decline {
      background: #ef4444;
      color: white;
      border: none;
    }
    .action-btn.forward {
      background: #3b7cff;
      color: white;
    }
    .action-btn:hover {
      transform: translateY(-1px);
      filter: brightness(0.96);
    }

    /* Toast */
    .toast-notify {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #0f172a;
      color: white;
      padding: 8px 16px;
      border-radius: 40px;
      font-size: 0.7rem;
      font-weight: 500;
      z-index: 1100;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      opacity: 0;
      transition: opacity 0.25s ease;
      pointer-events: none;
    }

    /* Custom spacing overrides - ZERO extra space */
    .mb-2 {
      margin-bottom: 0.25rem !important;
    }
    .mb-3 {
      margin-bottom: 0.5rem !important;
    }
    .mt-1 {
      margin-top: 0.125rem !important;
    }
    .p-3 {
      padding: 0.6rem 0.75rem !important;
    }
    .gap-2 {
      gap: 0.25rem !important;
    }
    .row.g-2 {
      --bs-gutter-y: 0.35rem;
      --bs-gutter-x: 0.5rem;
    }

    @media (max-width: 768px) {
      body { padding: 12px 10px; }
      .page-header h1 { font-size: 1.2rem; }
      .licence-badge { flex-direction: column; align-items: flex-start; }
      .qr-code-box { align-self: flex-end; }
    }
    @media (max-width: 576px) {
      .cnic-grid { flex-direction: column; }
      .action-group { justify-content: flex-start; }
    }
  </style>
</head>
<body>

<div class="dashboard-full">
  <!-- HEADER -->
  <div class="page-header">
    <h1><i class="fas fa-gavel me-2" style="color:#3b7cff;"></i> Arms License – Service Delivery</h1>
    <div class="app-badge">
      <i class="fas fa-qrcode me-1"></i> Application ID: 123456 · DC Office Malakand
    </div>
  </div>

  <!-- MAIN GRID - ultra compact gaps -->
  <div class="row g-2">
    <!-- LEFT COLUMN -->
    <div class="col-lg-7 col-md-12">
      <!-- Personal Info Card -->
      <div class="glass-card p-3 mb-2">
        <div class="row g-2">
          <div class="col-4">
            <div class="field-label">Applicant Name</div>
            <div class="field-value">Fazal Manan</div>
          </div>
          <div class="col-4">
            <div class="field-label">Father Name</div>
            <div class="field-value">Fazal Rahim</div>
          </div>
          <div class="col-4">
            <div class="field-label">CNIC No</div>
            <div class="field-value">1234-4561898-5</div>
          </div>
          <div class="col-4">
            <div class="field-label">Contact</div>
            <div class="field-value">0345 12345666</div>
          </div>
          <div class="col-4">
            <div class="field-label">Tehsil</div>
            <div class="field-value">Batkhela</div>
          </div>
          <div class="col-4">
            <div class="field-label">District</div>
            <div class="field-value">Malakand</div>
          </div>
          <div class="col-12">
            <div class="field-label">Address</div>
            <div class="field-value">Mohallah Sharifabad, Near Albarka Bank, Main Bazar Batkhela, Distt Malakand</div>
          </div>
        </div>
      </div>

      <!-- License Application Details -->
      <div class="glass-card p-3 mb-2">
        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="fas fa-id-card text-primary" style="font-size:0.8rem;"></i>
          <span style="font-size:0.8rem; font-weight:700;">License Application</span>
        </div>
        <div class="row g-2">
          <div class="col-6">
            <div class="field-label">Type of License</div>
            <div class="field-value">Arms License (Pistol)</div>
          </div>
          <div class="col-6">
            <div class="field-label">License Fee</div>
            <div class="field-value text-success fw-bold">Rs. 5,000</div>
          </div>
          <div class="col-6">
            <div class="field-label">License No</div>
            <div class="field-value text-primary">ARM123-2025</div>
          </div>
          <div class="col-6">
            <div class="field-label">Validity</div>
            <div class="field-value">3 Years</div>
          </div>
          <div class="col-6">
            <div class="field-label">Status</div>
            <div class="field-value text-warning">Under Process</div>
          </div>
          <div class="col-6">
            <div class="field-label">License Document</div>
            <div class="field-value"><span class="badge bg-success bg-opacity-10 text-success" style="font-size:0.65rem;">Attached</span></div>
          </div>
        </div>
      </div>

      <!-- Remarks Card -->
      <div class="remarks-area mb-2">
        <label class="field-label mb-1"><i class="fas fa-comment-dots me-1"></i> Official Remarks</label>
        <textarea rows="2" placeholder="Add internal remarks..."></textarea>
      </div>

      <!-- Select Officer -->
      <div class="glass-card p-3 mb-2">
        <label class="field-label mb-1"><i class="fas fa-user-tie me-1"></i> Select Officer / Forward to</label>
        <select class="officer-select" id="officerSelect">
          <option value="">-- Choose Officer --</option>
          <option>Abdul Ahad (Section Officer)</option>
          <option>Jawad Khan (Assistant Director)</option>
          <option>Fahad Mustafa (Deputy Commissioner)</option>
          <option>Imran Shah (Revenue Officer)</option>
          <option>Sara Bibi (Arms Branch)</option>
        </select>
      </div>

      <!-- Action Buttons -->
      <div class="action-group mb-1">
        <button class="action-btn revert" onclick="showToastMessage('Reverted back to applicant')"><i class="fas fa-undo-alt"></i> Revert</button>
        <button class="action-btn approve" onclick="showToastMessage('Application approved!')"><i class="fas fa-check-circle"></i> Approve</button>
        <button class="action-btn decline" onclick="showToastMessage('Application declined')"><i class="fas fa-times-circle"></i> Decline</button>
        <button class="action-btn forward" onclick="forwardToOfficer()"><i class="fas fa-share-square"></i> Forward</button>
      </div>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="col-lg-5 col-md-12">
      <!-- Licence Badge with QR -->
      <div class="licence-badge mb-2">
        <div>
          <div class="badge-title"><i class="fas fa-address-card me-1"></i> Arms License</div>
          <div class="badge-date">Issue Date: 03 Aug 2025</div>
          <div class="badge-date fw-semibold">KP-2025-00000232</div>
        </div>
        <div class="qr-code-box">
          <canvas id="qrCanvas" width="44" height="44"></canvas>
        </div>
      </div>

      <!-- CNIC Photos - exactly as screenshot -->
      <div class="glass-card p-3 mb-2">
        <div class="field-label mb-2"><i class="fas fa-id-card me-1"></i> CNIC Photos (Verified)</div>
        <div class="cnic-grid">
          <div class="cnic-card">
            <div class="cnic-icon"><i class="fas fa-id-card fa-2x"></i></div>
            <div class="cnic-label-sm">Front Side</div>
            <div class="cnic-status">✓ Verified</div>
          </div>
          <div class="cnic-card back">
            <div class="cnic-icon"><i class="fas fa-address-card fa-2x"></i></div>
            <div class="cnic-label-sm">Back Side</div>
            <div class="cnic-status">✓ Valid copy</div>
          </div>
        </div>
      </div>

      <!-- Attachments -->
      <div class="glass-card p-3 mb-2">
        <div class="field-label mb-2"><i class="fas fa-paperclip me-1"></i> Attachments</div>

        <div class="att-item">
          <div class="att-pdf-icon">PDF</div>
          <div class="att-details">
            <div class="att-name">Arms_License_Form.pdf</div>
            <div class="att-meta">312 KB · 31 Aug 2025</div>
          </div>
          <div class="att-actions">
            <button class="icon-btn dl" onclick="showToastMessage('Download started')"><i class="fas fa-download"></i></button>
            <button class="icon-btn" onclick="showToastMessage('File removed')"><i class="fas fa-trash-alt"></i></button>
          </div>
        </div>

        <div class="att-item">
          <div class="att-pdf-icon">PDF</div>
          <div class="att-details">
            <div class="att-name">CNIC_Front_Back.pdf</div>
            <div class="att-meta">189 KB · 31 Aug 2025</div>
          </div>
          <div class="att-actions">
            <button class="icon-btn dl" onclick="showToastMessage('Download started')"><i class="fas fa-download"></i></button>
            <button class="icon-btn" onclick="showToastMessage('File removed')"><i class="fas fa-trash-alt"></i></button>
          </div>
        </div>

        <div class="att-item">
          <div class="att-pdf-icon">IMG</div>
          <div class="att-details">
            <div class="att-name">Passport_Size_Photo.jpg</div>
            <div class="att-meta">45 KB · 31 Aug 2025</div>
          </div>
          <div class="att-actions">
            <button class="icon-btn dl" onclick="showToastMessage('Download started')"><i class="fas fa-download"></i></button>
            <button class="icon-btn" onclick="showToastMessage('File removed')"><i class="fas fa-trash-alt"></i></button>
          </div>
        </div>

        <div class="att-item">
          <div class="att-pdf-icon">PDF</div>
          <div class="att-details">
            <div class="att-name">Police_Verification.pdf</div>
            <div class="att-meta">568 KB · 01 Sep 2025</div>
          </div>
          <div class="att-actions">
            <button class="icon-btn dl" onclick="showToastMessage('Download started')"><i class="fas fa-download"></i></button>
            <button class="icon-btn" onclick="showToastMessage('File removed')"><i class="fas fa-trash-alt"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Toast notification -->
<div id="globalToast" class="toast-notify">
  <i class="fas fa-bell me-2"></i> <span id="toastText">Action completed</span>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // QR code generator
  (function generateQR() {
    const canvas = document.getElementById('qrCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const size = 44, block = 4;
    const cols = Math.floor(size / block);
    canvas.width = size;
    canvas.height = size;
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, size, size);
    
    let seed = 932745;
    const rand = () => { seed = (seed * 9301 + 49297) % 233280; return seed / 233280; };
    for (let y = 0; y < cols; y++) {
      for (let x = 0; x < cols; x++) {
        if (rand() > 0.55) {
          ctx.fillStyle = '#0f172a';
          ctx.fillRect(x * block, y * block, block - 0.5, block - 0.5);
        }
      }
    }
    const drawFinder = (x, y) => {
      ctx.fillStyle = '#0f172a';
      ctx.fillRect(x, y, 7 * block, 7 * block);
      ctx.fillStyle = '#fff';
      ctx.fillRect(x + block, y + block, 5 * block, 5 * block);
      ctx.fillStyle = '#0f172a';
      ctx.fillRect(x + 2 * block, y + 2 * block, 3 * block, 3 * block);
    };
    drawFinder(0, 0);
    drawFinder((cols - 7) * block, 0);
    drawFinder(0, (cols - 7) * block);
  })();

  let toastTimeout;
  function showToastMessage(msg) {
    const toastEl = document.getElementById('globalToast');
    const textSpan = document.getElementById('toastText');
    if (!toastEl) return;
    textSpan.innerText = msg;
    toastEl.style.opacity = '1';
    if (toastTimeout) clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
      toastEl.style.opacity = '0';
    }, 2500);
  }

  function forwardToOfficer() {
    const selectEl = document.getElementById('officerSelect');
    const selected = selectEl.options[selectEl.selectedIndex]?.text || 'Officer';
    if (!selected || selectEl.value === '') {
      showToastMessage('Please select an officer before forwarding');
      return;
    }
    showToastMessage(`Forwarded to ${selected} successfully`);
  }
</script>
@endsection