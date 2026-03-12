<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Hero Banner -->
<div class="p-4 mb-4 rounded-3 text-white position-relative overflow-hidden"
     style="background: linear-gradient(135deg, #1a1a2e, #e94560);
            box-shadow: 0 4px 20px rgba(233,69,96,0.3);">
  <div class="position-relative">
    <h2 class="fw-bold mb-1">Hello, <?= esc(session()->get('userName')) ?>! 👋</h2>
    <p class="mb-0 opacity-75">Welcome back! Here's what's happening today.</p>
  </div>
  <!-- Decorative circles -->
  <div style="position:absolute; top:-20px; right:-20px; width:120px; height:120px;
              border-radius:50%; background:rgba(255,255,255,0.05);"></div>
  <div style="position:absolute; bottom:-30px; right:80px; width:80px; height:80px;
              border-radius:50%; background:rgba(255,255,255,0.05);"></div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3"
         style="border-top: 4px solid #e94560 !important;">
      <div style="font-size:2.5rem">📋</div>
      <h5 class="fw-bold mt-2">All Records</h5>
      <p class="text-muted small">View and manage everything</p>
      <a href="<?= base_url('records') ?>" class="btn btn-primary mt-auto">View Records →</a>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3"
         style="border-top: 4px solid #28a745 !important;">
      <div style="font-size:2.5rem">➕</div>
      <h5 class="fw-bold mt-2">New Record</h5>
      <p class="text-muted small">Add a brand new entry</p>
      <a href="<?= base_url('records/new') ?>" class="btn btn-success mt-auto">Create Now →</a>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3"
         style="border-top: 4px solid #dc3545 !important;">
      <div style="font-size:2.5rem">🚪</div>
      <h5 class="fw-bold mt-2">Logout</h5>
      <p class="text-muted small">End your current session</p>
      <a href="<?= base_url('logout') ?>" class="btn btn-danger mt-auto">Sign Out →</a>
    </div>
  </div>
</div>



<!-- Quick Tips Section -->
<div class="row mb-4">
  <div class="col-12">
    <h5 class="fw-bold mb-3">🚀 Quick Guide</h5>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card h-100 border-0 text-center p-3"
         style="background:#fff5f7;">
      <div style="font-size:1.8rem">1️⃣</div>
      <p class="small fw-bold mt-2 mb-0">Create a Record</p>
      <p class="small text-muted">Click "New Record" to add data</p>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card h-100 border-0 text-center p-3"
         style="background:#f0fff4;">
      <div style="font-size:1.8rem">2️⃣</div>
      <p class="small fw-bold mt-2 mb-0">View Records</p>
      <p class="small text-muted">See all entries in a table</p>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card h-100 border-0 text-center p-3"
         style="background:#fff8f0;">
      <div style="font-size:1.8rem">3️⃣</div>
      <p class="small fw-bold mt-2 mb-0">Edit a Record</p>
      <p class="small text-muted">Click Edit to update details</p>
    </div>
  </div>
  <div class="col-md-3 mb-3">
    <div class="card h-100 border-0 text-center p-3"
         style="background:#f5f0ff;">
      <div style="font-size:1.8rem">4️⃣</div>
      <p class="small fw-bold mt-2 mb-0">Delete a Record</p>
      <p class="small text-muted">Click Delete to remove it</p>
    </div>
  </div>
</div>

<!-- Live Date & Time Card -->
<div class="card border-0 mb-4"
     style="background: linear-gradient(135deg, #1a1a2e, #16213e); color:white;">
  <div class="card-body d-flex justify-content-between align-items-center">
    <div>
      <div class="fw-bold small fs-5">Current Date & Time</div>
      <div class=" fs-6" id="live-date">📅 Loading...</div>
      <div class="fs-6" id="live-time">⏰ Loading...</div>
    </div>
    <div class="text-end">
      <div class="small opacity-75">Logged in as</div>
      <div class="fw-bold">👤 <?= esc(session()->get('userName')) ?></div>
    </div>
  </div>
</div>

<!-- Real-Time Clock Script -->
<script>
function updateClock() {
    const now = new Date();

    // Format Date: "March 06, 2026"
    const dateOptions = { year: 'numeric', month: 'long', day: '2-digit' };
    const dateStr = now.toLocaleDateString('en-US', dateOptions);

    // Format Time: "07:45:30 PM"
    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
    const timeStr = now.toLocaleTimeString('en-US', timeOptions);

    document.getElementById('live-date').innerHTML = '📅 ' + dateStr;
    document.getElementById('live-time').innerHTML = '⏰ ' + timeStr;
}

// Run immediately then update every second
updateClock();
setInterval(updateClock, 1000);
</script>

<?= $this->endSection() ?>