<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="p-4 mb-4 rounded-3 text-white"
     style="background: linear-gradient(135deg, #1a1a2e, #e94560);
            box-shadow: 0 4px 20px rgba(233,69,96,0.3);">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h3 class="fw-bold mb-1">👤 My Profile</h3>
      <p class="mb-0 opacity-75">View your personal information</p>
    </div>
    <a href="<?= base_url('profile/edit') ?>"
       class="btn btn-light fw-bold">
      ✏️ Edit Profile
    </a>
  </div>
</div>

<div class="row">

  <!-- Left Column — Avatar -->
  <div class="col-md-3 mb-4">
    <div class="card border-0 text-center p-4">

      <!-- Profile Image or Placeholder -->
      <?php if(! empty($user['profile_image'])): ?>

         <p class="small text-muted"><?= base_url('uploads/profiles/' . $user['profile_image']) ?></p>

        <img src="/uploads/profiles/<?= esc($user['profile_image']) ?>"
             alt="Profile Photo"
             class="rounded-circle mx-auto mb-3"
             style="width:150px; height:150px; object-fit:cover;
                    border: 4px solid #e94560;
                    box-shadow: 0 4px 15px rgba(233,69,96,0.3);">
      <?php else: ?>
        
        <!-- Placeholder if no image uploaded -->
        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
             style="width:150px; height:150px;
                    background: linear-gradient(135deg, #1a1a2e, #e94560);
                    font-size:4rem;">
          👤
        </div>
      <?php endif; ?>

      <h5 class="fw-bold mb-1"><?= esc($user['name']) ?></h5>
      <p class="text-muted small mb-0"><?= esc($user['email']) ?></p>
      <span class="badge mt-2"
            style="background:#e94560;">
        <?= esc($user['course'] ?? 'No Course Set') ?>
      </span>
    </div>
  </div>

  <!-- Right Column — Details -->
  <div class="col-md-9 mb-4">
    <div class="card border-0">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-4 pb-2 border-bottom">📋 Student Information</h5>

        <dl class="row">
          <dt class="col-sm-3 text-muted">Student ID</dt>
          <dd class="col-sm-9 fw-semibold">
            <?= esc($user['student_id'] ?? '—') ?>
          </dd>

          <dt class="col-sm-3 text-muted">Full Name</dt>
          <dd class="col-sm-9"><?= esc($user['name']) ?></dd>

          <dt class="col-sm-3 text-muted">Email</dt>
          <dd class="col-sm-9"><?= esc($user['email']) ?></dd>

          <dt class="col-sm-3 text-muted">Course</dt>
          <dd class="col-sm-9"><?= esc($user['course'] ?? '—') ?></dd>

          <dt class="col-sm-3 text-muted">Year Level</dt>
          <dd class="col-sm-9">
            <?= ! empty($user['year_level'])
                ? 'Year ' . esc($user['year_level'])
                : '—' ?>
          </dd>

          <dt class="col-sm-3 text-muted">Section</dt>
          <dd class="col-sm-9"><?= esc($user['section'] ?? '—') ?></dd>

          <dt class="col-sm-3 text-muted">Phone</dt>
          <dd class="col-sm-9"><?= esc($user['phone'] ?? '—') ?></dd>

          <dt class="col-sm-3 text-muted">Address</dt>
          <dd class="col-sm-9"><?= esc($user['address'] ?? '—') ?></dd>
        </dl>

        <hr>

        <dl class="row mb-0">
          <dt class="col-sm-3 text-muted">Account Created</dt>
          <dd class="col-sm-9"><?= $user['created_at'] ?? '—' ?></dd>
        </dl>

      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>