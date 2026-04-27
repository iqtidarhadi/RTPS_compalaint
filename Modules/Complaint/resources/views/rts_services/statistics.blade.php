@extends('complaint::layouts.layout')

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Services Statistics</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'DM Sans', sans-serif;
    background: #F4F6FA;
    color: #1e2a3a;
    font-size: 13px;
  }
  .container { max-width: 1300px; margin: 0 auto; padding: 24px; }

  /* Header */
  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  .page-header h3 { font-size: 18px; font-weight: 700; color: #1e2a3a; }
  .form-select {
    padding: 6px 28px 6px 10px;
    border: 1px solid #dce1ea;
    border-radius: 6px;
    background: white;
    font-size: 12px;
    font-family: 'DM Sans', sans-serif;
    color: #444;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23666' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 8px center;
    cursor: pointer;
  }
  .form-select:focus { outline: none; border-color: #3B82F6; }

  /* Cards */
  .card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    padding: 20px;
  }

  /* Legend */
  .legend {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-top: 12px;
  }
  .legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: #555;
  }
  .dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
  }
  .sq {
    width: 10px; height: 10px;
    border-radius: 2px;
    flex-shrink: 0;
  }

  /* Grid */
  .row { display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 20px; }
  .col-12 { width: 100%; }
  .col-6 { flex: 1 1 calc(50% - 8px); min-width: 280px; }
  .col-4 { flex: 1 1 calc(33.33% - 12px); min-width: 200px; }
  .col-5th { flex: 1 1 calc(20% - 14px); min-width: 160px; }

  /* Section title */
  .section-title {
    font-size: 13px;
    font-weight: 600;
    color: #1e2a3a;
    margin-bottom: 14px;
  }

  /* Card header row */
  .card-header-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 14px;
  }
  .card-title { font-size: 13px; font-weight: 600; color: #1e2a3a; margin-bottom: 2px; }
  .card-number { font-size: 22px; font-weight: 700; color: #1e2a3a; }
  .card-sub { font-size: 11px; color: #888; }
  .section-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #999;
    font-weight: 600;
    margin-bottom: 10px;
  }

  /* Donut card */
  .donut-card {
    text-align: center;
  }
  .donut-wrap {
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
  }
  .donut-legend {
    display: flex;
    flex-direction: column;
    gap: 3px;
    font-size: 10.5px;
    color: #555;
    text-align: left;
    width: fit-content;
    margin: 0 auto;
  }
  .donut-legend-row {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .donut-legend-val {
    margin-left: auto;
    font-weight: 600;
    color: #333;
  }
  .donut-inner {
    display: flex;
    gap: 16px;
    justify-content: center;
    align-items: flex-start;
    padding: 0 8px;
  }

  /* Officer card */
  .officer-card {
    text-align: center;
    padding: 16px 12px;
  }
  .avatar {
    width: 52px; height: 52px;
    border-radius: 50%;
    margin: 0 auto 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 18px;
    overflow: hidden;
  }
  .officer-name { font-size: 12px; font-weight: 600; margin-bottom: 2px; }
  .officer-role { font-size: 10px; color: #888; margin-bottom: 1px; }
  .officer-dept { font-size: 10px; color: #888; margin-bottom: 4px; }
  .officer-perf { font-size: 10px; color: #555; }

  /* Employee of the Month */
  .emp-card {
    background: #1e2a4a;
    border-radius: 12px;
    padding: 20px;
    color: white;
    display: flex;
    gap: 20px;
    align-items: flex-start;
  }
  .emp-avatar {
    width: 70px; height: 70px;
    border-radius: 50%;
    background: #3B82F6;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 700;
    color: white;
  }
  .emp-info { flex: 1; }
  .emp-name { font-size: 16px; font-weight: 700; margin-bottom: 2px; }
  .emp-role { font-size: 11px; color: #a0aec0; margin-bottom: 2px; }
  .emp-dept { font-size: 11px; color: #a0aec0; }
  .emp-legend { flex: 1; }
  .emp-stats-row { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #c0cfe0; margin-bottom: 3px; }
  .emp-donut { width: 120px; height: 120px; flex-shrink: 0; }
  .emp-bullets { flex: 2; }
  .emp-bullets ul { list-style: none; padding: 0; }
  .emp-bullets ul li { font-size: 10.5px; color: #c0cfe0; margin-bottom: 5px; padding-left: 12px; position: relative; }
  .emp-bullets ul li::before { content: '•'; position: absolute; left: 0; color: #60a5fa; }
</style>
</head>
<body>
<div class="container">

  <!-- Header -->
  <div class="page-header">
    <h3>Services Statistics</h3>
    <select class="form-select">
      <option>Select Service</option>
      <option>Arms License</option>
      <option>Domicile</option>
      <option>Motor Vehicle Registration</option>
      <option>Driving License</option>
    </select>
  </div>

  <!-- Main Services Statistics Chart -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="section-label">Services Statistics</div>
        <div style="height:280px;"><canvas id="servicesChart"></canvas></div>
        <div class="legend">
          <div class="legend-item"><span class="sq" style="background:#3B82F6"></span>Total</div>
          <div class="legend-item"><span class="sq" style="background:#10B981"></span>Delivered</div>
          <div class="legend-item"><span class="sq" style="background:#F59E0B"></span>Delayed</div>
          <div class="legend-item"><span class="sq" style="background:#EF4444"></span>Critically Delayed</div>
          <div class="legend-item"><span class="sq" style="background:#8B5CF6"></span>Performance</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Department & District Wise -->
  <div class="row">
    <div class="col-6">
      <div class="card">
        <div class="card-header-row">
          <div>
            <div class="card-title">Department Wise</div>
            <div class="card-number">5,987,34</div>
            <div class="card-sub">Total Applications</div>
          </div>
          <select class="form-select">
            <option>Home Department</option>
            <option>Police</option>
            <option>Transport</option>
          </select>
        </div>
        <div style="height:230px;"><canvas id="departmentChart"></canvas></div>
        <div class="legend">
          <div class="legend-item"><span class="dot" style="background:#3B82F6"></span>Total</div>
          <div class="legend-item"><span class="dot" style="background:#10B981"></span>Delivered</div>
          <div class="legend-item"><span class="dot" style="background:#F59E0B"></span>Delayed</div>
          <div class="legend-item"><span class="dot" style="background:#EF4444"></span>Critically Delayed</div>
          <div class="legend-item"><span class="dot" style="background:#8B5CF6"></span>Performance</div>
        </div>
      </div>
    </div>
    <div class="col-6">
      <div class="card">
        <div class="card-header-row">
          <div>
            <div class="card-title">District Wise</div>
            <div class="card-number">5,987,34</div>
            <div class="card-sub">Total Applications</div>
          </div>
          <select class="form-select">
            <option>Peshawar</option>
            <option>Malakand</option>
            <option>Charsadda</option>
          </select>
        </div>
        <div style="height:230px;"><canvas id="districtChart"></canvas></div>
        <div class="legend">
          <div class="legend-item"><span class="dot" style="background:#3B82F6"></span>Total</div>
          <div class="legend-item"><span class="dot" style="background:#10B981"></span>Delivered</div>
          <div class="legend-item"><span class="dot" style="background:#F59E0B"></span>Delayed</div>
          <div class="legend-item"><span class="dot" style="background:#EF4444"></span>Critically Delayed</div>
          <div class="legend-item"><span class="dot" style="background:#8B5CF6"></span>Performance</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Top 3 Performing Departments -->
  <div class="section-title">Top 3 Performing Department</div>
  <div class="row">
    <div class="col-4"><div class="card donut-card" id="top1card"></div></div>
    <div class="col-4"><div class="card donut-card" id="top2card"></div></div>
    <div class="col-4"><div class="card donut-card" id="top3card"></div></div>
  </div>

  <!-- Lowest 3 Performing Departments -->
  <div class="section-title">Lowest 3 Performing Department</div>
  <div class="row">
    <div class="col-4"><div class="card donut-card" id="low1card"></div></div>
    <div class="col-4"><div class="card donut-card" id="low2card"></div></div>
    <div class="col-4"><div class="card donut-card" id="low3card"></div></div>
  </div>

  <!-- Top 5 Performing Officers -->
  <div class="section-title">Top 5 Performing Officers</div>
  <div class="row" id="top5officers"></div>

  <!-- Lowest 5 Performing Officers -->
  <div class="section-title">Lowest 5 Performing Officers</div>
  <div class="row" id="low5officers"></div>

  <!-- Employee of the Month -->
  <div class="section-title" style="margin-top:4px;">Employee of the Month</div>
  <div class="emp-card">
    <div class="emp-avatar">F</div>
    <div class="emp-info">
      <div class="emp-name">Fazal Manan</div>
      <div class="emp-role">Field Officer</div>
      <div class="emp-dept">Home Department</div>
      <div style="margin-top:12px;" class="emp-legend" id="empLegend"></div>
    </div>
    <div class="emp-donut"><canvas id="empChart"></canvas></div>
    <div class="emp-bullets">
      <ul>
        <li>Leads a highly engaged team that works well together and consistently meets deadlines</li>
        <li>Offers assistance to colleagues and collaborators</li>
        <li>Has taken the time to build strong relationships with all members of the team</li>
        <li>Encourages team members to provide support to each other when needed</li>
      </ul>
    </div>
  </div>

</div>

<script>
// ── helpers ────────────────────────────────────────────────
const COLORS = {
  total:    '#3B82F6',
  deliv:    '#10B981',
  delayed:  '#F59E0B',
  crit:     '#EF4444',
  perf:     '#8B5CF6'
};
const barDatasets = (t,d,del,c,p) => [
  { label:'Total',            data:t,   backgroundColor:COLORS.total,   barPercentage:0.7 },
  { label:'Delivered',        data:d,   backgroundColor:COLORS.deliv,   barPercentage:0.7 },
  { label:'Delayed',          data:del, backgroundColor:COLORS.delayed, barPercentage:0.7 },
  { label:'Critically Delayed',data:c,  backgroundColor:COLORS.crit,    barPercentage:0.7 },
  { label:'Performance',      data:p,   backgroundColor:COLORS.perf,    barPercentage:0.7 },
];
const barOptions = (max) => ({
  responsive:true, maintainAspectRatio:false,
  plugins:{ legend:{display:false} },
  scales:{ y:{ beginAtZero:true, max:max||undefined, ticks:{font:{size:10}}, grid:{color:'#f0f0f0'} },
           x:{ ticks:{font:{size:10}}, grid:{display:false} } }
});

// ── Services Chart ──────────────────────────────────────────
new Chart(document.getElementById('servicesChart'), {
  type:'bar',
  data:{
    labels:['Arms License','Domicile','Motor Vehicle','Driving License','Trade License','Inheritance','Property Transfer','Utilities Issuance'],
    datasets: barDatasets(
      [54,65,23,42,40,35,28,32],
      [5,65,4,6,15,20,10,14],
      [25,25,25,25,18,10,12,15],
      [24,24,24,24,7,5,6,3],
      [65,78,85,92,88,75,80,85]
    )
  },
  options: barOptions(100)
});

// ── Department Chart ────────────────────────────────────────
new Chart(document.getElementById('departmentChart'), {
  type:'bar',
  data:{
    labels:['Arms License','Domicile','Motor Vehicle','Driving License'],
    datasets: barDatasets(
      [300,350,280,320],[150,200,180,200],[100,80,60,80],[50,70,40,40],[80,85,90,88]
    )
  },
  options: barOptions()
});

// ── District Chart ──────────────────────────────────────────
new Chart(document.getElementById('districtChart'), {
  type:'bar',
  data:{
    labels:['Arms License','Domicile','Motor Vehicle','Driving License'],
    datasets: barDatasets(
      [320,380,290,340],[160,220,190,210],[110,90,70,90],[50,70,30,40],[82,87,92,90]
    )
  },
  options: barOptions()
});

// ── Donut helper ────────────────────────────────────────────
function makeDonutCard(containerId, title, topPerf) {
  const el = document.getElementById(containerId);
  // left: legend text, right: donut
  const legendItems = [
    { label:'Total',            val:'12,340', color:COLORS.total  },
    { label:'Delivered',        val:'8,201',  color:COLORS.deliv  },
    { label:'Delayed',          val:'2,534',  color:COLORS.delayed},
    { label:'Critically Delayed',val:'892',   color:COLORS.crit   },
    { label:'Performance',      val:'92%',    color:COLORS.perf   },
  ];
  const canvasId = containerId + '_canvas';

  el.innerHTML = `
    <h6 style="font-size:12px;font-weight:600;margin-bottom:12px;text-align:left;">${title}</h6>
    <div class="donut-inner">
      <div class="donut-legend">
        ${legendItems.map(i=>`
          <div class="donut-legend-row">
            <span class="dot" style="background:${i.color}"></span>
            <span>${i.label}</span>
            <span class="donut-legend-val" style="margin-left:8px;">${i.val}</span>
          </div>`).join('')}
      </div>
      <div style="width:130px;height:130px;flex-shrink:0;">
        <canvas id="${canvasId}"></canvas>
      </div>
    </div>
  `;

  const data = topPerf
    ? [20,30,15,10,25]
    : [15,20,30,25,10];

  new Chart(document.getElementById(canvasId), {
    type:'doughnut',
    data:{
      labels:['Total','Delivered','Delayed','Critically','Performance'],
      datasets:[{ data, backgroundColor:[COLORS.total,COLORS.deliv,COLORS.delayed,COLORS.crit,COLORS.perf], borderWidth:2 }]
    },
    options:{
      responsive:true, maintainAspectRatio:false,
      plugins:{ legend:{display:false}, tooltip:{enabled:true} },
      cutout:'60%'
    }
  });
}

makeDonutCard('top1card','Home Department',true);
makeDonutCard('top2card','Education Department',true);
makeDonutCard('top3card','Health Department',true);
makeDonutCard('low1card','Revenue Department',false);
makeDonutCard('low2card','Social Welfare',false);
makeDonutCard('low3card','Water & Sanitation',false);

// ── Officer Cards ───────────────────────────────────────────
const topOfficers = [
  {name:'Fazal Manan',  color:'#3B82F6', perf:'92%'},
  {name:'Jawad Khan',   color:'#10B981', perf:'89%'},
  {name:'Mustafa Jan',  color:'#F59E0B', perf:'87%'},
  {name:'Rafiullah Khan',color:'#EF4444',perf:'85%'},
  {name:'Kashif Khan',  color:'#8B5CF6', perf:'84%'},
];
const lowOfficers = [
  {name:'Fazal Manan',  color:'#3B82F6', perf:'62%'},
  {name:'Jawad Khan',   color:'#10B981', perf:'58%'},
  {name:'Mustafa Jan',  color:'#F59E0B', perf:'55%'},
  {name:'Rafiullah Khan',color:'#EF4444',perf:'51%'},
  {name:'Kashif Khan',  color:'#8B5CF6', perf:'48%'},
];

function renderOfficers(officers, containerId) {
  const el = document.getElementById(containerId);
  el.innerHTML = officers.map(o=>`
    <div class="col-5th">
      <div class="card officer-card">
        <div class="avatar" style="background:${o.color};">${o.name[0]}</div>
        <div class="officer-name">${o.name}</div>
        <div class="officer-role">RTS Officer</div>
        <div class="officer-dept">Home Department</div>
        <div class="officer-perf">Performance: ${o.perf}</div>
      </div>
    </div>
  `).join('');
}
renderOfficers(topOfficers, 'top5officers');
renderOfficers(lowOfficers, 'low5officers');

// ── Employee of Month ───────────────────────────────────────
const empLegendItems = [
  {label:'Total',  color:COLORS.total,  val:'12,340'},
  {label:'Delivered',color:COLORS.deliv,val:'8,201'},
  {label:'Delayed',color:COLORS.delayed,val:'2,534'},
  {label:'Critically Delayed',color:COLORS.crit,val:'892'},
  {label:'Performance',color:COLORS.perf,val:'92%'},
];
document.getElementById('empLegend').innerHTML = empLegendItems.map(i=>`
  <div class="emp-stats-row">
    <span class="dot" style="background:${i.color}"></span>
    <span>${i.label}</span>
    <span style="margin-left:6px;font-weight:600;color:white;">${i.val}</span>
  </div>`).join('');

new Chart(document.getElementById('empChart'), {
  type:'doughnut',
  data:{
    labels:['Total','Delivered','Delayed','Critically','Performance'],
    datasets:[{
      data:[20,30,15,10,25],
      backgroundColor:[COLORS.total,COLORS.deliv,COLORS.delayed,COLORS.crit,COLORS.perf],
      borderWidth:2,
      borderColor:'#1e2a4a'
    }]
  },
  options:{
    responsive:true, maintainAspectRatio:false,
    plugins:{ legend:{display:false} },
    cutout:'55%'
  }
});
</script>
@endsection