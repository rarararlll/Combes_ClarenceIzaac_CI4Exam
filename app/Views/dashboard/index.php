<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Hero Banner -->
<div class="p-4 mb-4 rounded-3 text-white position-relative overflow-hidden"
     style="background: <?= $role === 'admin' ? 'linear-gradient(135deg, #7b0000, #dc3545)' : 'linear-gradient(135deg, #003d1a, #28a745)' ?>;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
  <div class="position-relative">
    <h2 class="fw-bold mb-1">Hello, <?= esc(session()->get('userName')) ?>! 👋</h2>
    <p class="mb-0 opacity-75">
      <?= $role === 'admin' ? 'Administrator Panel — Full system access.' : 'Teacher Panel — Manage records and students.' ?>
    </p>
    <span class="badge mt-2 <?= $role === 'admin' ? 'bg-danger' : 'bg-success' ?>" style="font-size:.85rem">
      <?= strtoupper($role) ?>
    </span>
  </div>
</div>

<!-- Admin-only cards -->
<?php if ($role === 'admin'): ?>
<div class="row mb-4">
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3" style="border-top: 4px solid #dc3545 !important;">
      <div style="font-size:2.5rem">🛡️</div>
      <h5 class="fw-bold mt-2">Manage Roles</h5>
      <p class="text-muted small">Create, edit, delete roles</p>
      <a href="<?= base_url('admin/roles') ?>" class="btn btn-danger mt-auto">Go to Roles →</a>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3" style="border-top: 4px solid #dc3545 !important;">
      <div style="font-size:2.5rem">👥</div>
      <h5 class="fw-bold mt-2">Manage Users</h5>
      <p class="text-muted small">Assign roles to users</p>
      <a href="<?= base_url('admin/users') ?>" class="btn btn-danger mt-auto">Go to Users →</a>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3" style="border-top: 4px solid #6c757d !important;">
      <div style="font-size:2.5rem">📋</div>
      <h5 class="fw-bold mt-2">All Records</h5>
      <p class="text-muted small">View and manage records</p>
      <a href="<?= base_url('records') ?>" class="btn btn-secondary mt-auto">View Records →</a>
    </div>
  </div>
</div>

<!-- Teacher-only cards -->
<?php else: ?>
<div class="row mb-4">
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3" style="border-top: 4px solid #28a745 !important;">
      <div style="font-size:2.5rem">📋</div>
      <h5 class="fw-bold mt-2">All Records</h5>
      <p class="text-muted small">View and manage everything</p>
      <a href="<?= base_url('records') ?>" class="btn btn-success mt-auto">View Records →</a>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3" style="border-top: 4px solid #28a745 !important;">
      <div style="font-size:2.5rem">➕</div>
      <h5 class="fw-bold mt-2">New Record</h5>
      <p class="text-muted small">Add a brand new entry</p>
      <a href="<?= base_url('records/new') ?>" class="btn btn-success mt-auto">Create Now →</a>
    </div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card h-100 text-center p-3" style="border-top: 4px solid #17a2b8 !important;">
      <div style="font-size:2.5rem">🎓</div>
      <h5 class="fw-bold mt-2">Students</h5>
      <p class="text-muted small">View student list</p>
      <a href="<?= base_url('students') ?>" class="btn btn-info mt-auto">View Students →</a>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Live Date & Time Card -->
<div class="card border-0 mb-4"
     style="background: linear-gradient(135deg, #1a1a2e, #16213e); color:white;">
  <div class="card-body d-flex justify-content-between align-items-center">
    <div>
      <div class="fw-bold small fs-5">Current Date & Time</div>
      <div class="fs-6" id="live-date">📅 Loading...</div>
      <div class="fs-6" id="live-time">⏰ Loading...</div>
    </div>
    <div class="text-end">
      <div class="small opacity-75">Logged in as</div>
      <div class="fw-bold">👤 <?= esc(session()->get('userName')) ?></div>
      <span class="badge <?= $role === 'admin' ? 'bg-danger' : 'bg-success' ?>">
        <?= strtoupper($role) ?>
      </span>
    </div>
  </div>
</div>

<script>
function updateClock() {
    const now = new Date();
    const dateOptions = { year: 'numeric', month: 'long', day: '2-digit' };
    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
    document.getElementById('live-date').innerHTML = '📅 ' + now.toLocaleDateString('en-US', dateOptions);
    document.getElementById('live-time').innerHTML = '⏰ ' + now.toLocaleTimeString('en-US', timeOptions);
}
updateClock();
setInterval(updateClock, 1000);
</script>

<?= $this->endSection() ?>