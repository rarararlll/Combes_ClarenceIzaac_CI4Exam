<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="p-4 mb-4 rounded-3 text-white"
     style="background: linear-gradient(135deg, #1a1a2e, #e94560);
            box-shadow: 0 4px 20px rgba(233,69,96,0.3);">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h3 class="fw-bold mb-1">📋 All Records</h3>
      <p class="mb-0 opacity-75">Manage all your records here</p>
    </div>
    <a href="<?= base_url('records/new') ?>" 
       class="btn btn-light fw-bold">
      + New Record
    </a>
  </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>📋 All Records</h3>
  <a href="/records/new" class="btn btn-success">+ New Record</a>
</div>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <table class="table table-striped table-bordered mb-0">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Category</th>
          <th>Status</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($records)): ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-4">
              No records found. <a href="/records/new">Create one?</a>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach($records as $r): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td>
              <a href="/records/<?= $r['id'] ?>">
                <?= esc($r['title']) ?>
              </a>
            </td>
            <td><?= esc($r['category']) ?></td>
            <td>
              <span class="badge bg-<?= $r['status'] === 'active' ? 'success' : 'secondary' ?>">
                <?= $r['status'] ?>
              </span>
            </td>
            <td><?= $r['created_at'] ?></td>
            <td>
              <a href="/records/edit/<?= $r['id'] ?>"
                 class="btn btn-warning btn-sm">Edit</a>
              <a href="/records/delete/<?= $r['id'] ?>"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Are you sure you want to delete this record?')">
                 Delete
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>