<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h4 class="mb-4">✏️ Edit Record</h4>

        <form action="/records/update/<?= $record['id'] ?>" method="post">
          <?= csrf_field() ?>

          <!-- Title -->
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title"
                   class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                   value="<?= old('title', $record['title']) ?>">
            <?php if(isset($errors['title'])): ?>
              <div class="invalid-feedback"><?= esc($errors['title']) ?></div>
            <?php endif; ?>
          </div>

          <!-- Description -->
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4"
                      class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                      ><?= old('description', $record['description']) ?></textarea>
            <?php if(isset($errors['description'])): ?>
              <div class="invalid-feedback"><?= esc($errors['description']) ?></div>
            <?php endif; ?>
          </div>

          <!-- Category -->
          <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category"
                   class="form-control <?= isset($errors['category']) ? 'is-invalid' : '' ?>"
                   value="<?= old('category', $record['category']) ?>">
            <?php if(isset($errors['category'])): ?>
              <div class="invalid-feedback"><?= esc($errors['category']) ?></div>
            <?php endif; ?>
          </div>

          <!-- Status -->
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status"
                    class="form-control <?= isset($errors['status']) ? 'is-invalid' : '' ?>">
              <option value="active"
                <?= old('status', $record['status']) === 'active' ? 'selected' : '' ?>>
                Active
              </option>
              <option value="inactive"
                <?= old('status', $record['status']) === 'inactive' ? 'selected' : '' ?>>
                Inactive
              </option>
            </select>
            <?php if(isset($errors['status'])): ?>
              <div class="invalid-feedback"><?= esc($errors['status']) ?></div>
            <?php endif; ?>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Record</button>
            <a href="/records" class="btn btn-secondary">Cancel</a>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>