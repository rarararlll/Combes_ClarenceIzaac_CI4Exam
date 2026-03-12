<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">📄 Record Details</h5>
      </div>
      <div class="card-body">
        <dl class="row">
          <dt class="col-sm-3">ID</dt>
          <dd class="col-sm-9"><?= $record['id'] ?></dd>

          <dt class="col-sm-3">Title</dt>
          <dd class="col-sm-9"><?= esc($record['title']) ?></dd>

          <dt class="col-sm-3">Description</dt>
          <dd class="col-sm-9"><?= esc($record['description']) ?></dd>

          <dt class="col-sm-3">Category</dt>
          <dd class="col-sm-9"><?= esc($record['category']) ?></dd>

          <dt class="col-sm-3">Status</dt>
          <dd class="col-sm-9">
            <span class="badge bg-<?= $record['status'] === 'active' ? 'success' : 'secondary' ?>">
              <?= $record['status'] ?>
            </span>
          </dd>

          <dt class="col-sm-3">Created</dt>
          <dd class="col-sm-9"><?= $record['created_at'] ?></dd>

          <dt class="col-sm-3">Updated</dt>
          <dd class="col-sm-9"><?= $record['updated_at'] ?></dd>
        </dl>
      </div>
      <div class="card-footer d-flex gap-2">
        <a href="/records/edit/<?= $record['id'] ?>" class="btn btn-warning">✏️ Edit</a>
        <a href="/records" class="btn btn-secondary">← Back to List</a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>