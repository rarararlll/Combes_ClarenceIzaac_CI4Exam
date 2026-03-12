<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<!-- Page Header -->
<div class="p-4 mb-4 rounded-3 text-white"
     style="background: linear-gradient(135deg, #1a1a2e, #e94560);">
  <h3 class="fw-bold mb-1">✏️ Edit Profile</h3>
  <p class="mb-0 opacity-75">Update your personal information</p>
</div>

<div class="row">

  <!-- Left Column — Image Preview -->
  <div class="col-md-3 mb-4">
    <div class="card border-0 text-center p-4">
      <p class="text-muted small mb-3">Profile Photo</p>

      <!-- Image Preview — shows current or newly selected image -->
      <?php if(! empty($user['profile_image'])): ?>
        <img id="preview"
             src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>"
             alt="Preview"
             class="rounded-circle mx-auto mb-3"
             style="width:150px; height:150px; object-fit:cover;
                    border: 4px solid #e94560;">
      <?php else: ?>
        <div id="preview-placeholder"
             class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
             style="width:150px; height:150px;
                    background: linear-gradient(135deg, #1a1a2e, #e94560);
                    font-size:4rem;">
          👤
        </div>
        <img id="preview"
             src=""
             alt="Preview"
             class="rounded-circle mx-auto mb-3 d-none"
             style="width:150px; height:150px; object-fit:cover;
                    border: 4px solid #e94560;">
      <?php endif; ?>

      <p class="text-muted small">JPG, PNG or WEBP<br>Max 2MB</p>
    </div>
  </div>

  <!-- Right Column — Edit Form -->
  <div class="col-md-9 mb-4">
    <div class="card border-0">
      <div class="card-body p-4">

        <!-- IMPORTANT: enctype required for file upload -->
        <form action="<?= base_url('profile/update') ?>"
              method="post"
              enctype="multipart/form-data">
          <?= csrf_field() ?>

          <h5 class="fw-bold mb-4 pb-2 border-bottom">Personal Information</h5>

          <div class="row">
            <!-- Full Name -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Full Name</label>
              <input type="text" name="name"
                     class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                     value="<?= old('name', esc($user['name'])) ?>">
              <?php if(isset($errors['name'])): ?>
                <div class="invalid-feedback"><?= $errors['name'] ?></div>
              <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Email Address</label>
              <input type="email" name="email"
                     class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                     value="<?= old('email', esc($user['email'])) ?>">
              <?php if(isset($errors['email'])): ?>
                <div class="invalid-feedback"><?= $errors['email'] ?></div>
              <?php endif; ?>
            </div>

            <!-- Student ID -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Student ID</label>
              <input type="text" name="student_id"
                     class="form-control <?= isset($errors['student_id']) ? 'is-invalid' : '' ?>"
                     value="<?= old('student_id', esc($user['student_id'] ?? '')) ?>"
                     placeholder="e.g. 2021-00123">
              <?php if(isset($errors['student_id'])): ?>
                <div class="invalid-feedback"><?= $errors['student_id'] ?></div>
              <?php endif; ?>
            </div>

            <!-- Course -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Course</label>
              <input type="text" name="course"
                     class="form-control <?= isset($errors['course']) ? 'is-invalid' : '' ?>"
                     value="<?= old('course', esc($user['course'] ?? '')) ?>"
                     placeholder="e.g. BSIT">
              <?php if(isset($errors['course'])): ?>
                <div class="invalid-feedback"><?= $errors['course'] ?></div>
              <?php endif; ?>
            </div>

            <!-- Year Level -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Year Level</label>
              <select name="year_level"
                      class="form-control <?= isset($errors['year_level']) ? 'is-invalid' : '' ?>">
                <option value="">-- Select Year --</option>
                <?php for($y = 1; $y <= 5; $y++): ?>
                  <option value="<?= $y ?>"
                    <?= old('year_level', $user['year_level'] ?? '') == $y ? 'selected' : '' ?>>
                    Year <?= $y ?>
                  </option>
                <?php endfor; ?>
              </select>
              <?php if(isset($errors['year_level'])): ?>
                <div class="invalid-feedback"><?= $errors['year_level'] ?></div>
              <?php endif; ?>
            </div>

            <!-- Section -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Section</label>
              <input type="text" name="section"
                     class="form-control <?= isset($errors['section']) ? 'is-invalid' : '' ?>"
                     value="<?= old('section', esc($user['section'] ?? '')) ?>"
                     placeholder="e.g. IT3A">
              <?php if(isset($errors['section'])): ?>
                <div class="invalid-feedback"><?= $errors['section'] ?></div>
              <?php endif; ?>
            </div>

            <!-- Phone -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Phone Number</label>
              <input type="text" name="phone"
                     class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                     value="<?= old('phone', esc($user['phone'] ?? '')) ?>"
                     placeholder="e.g. 09XX-XXX-XXXX">
              <?php if(isset($errors['phone'])): ?>
                <div class="invalid-feedback"><?= $errors['phone'] ?></div>
              <?php endif; ?>
            </div>

            <!-- Address -->
            <div class="col-md-12 mb-3">
              <label class="form-label fw-semibold">Address</label>
              <textarea name="address" rows="3"
                        class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                        placeholder="Enter your home address"
                        ><?= old('address', esc($user['address'] ?? '')) ?></textarea>
              <?php if(isset($errors['address'])): ?>
                <div class="invalid-feedback"><?= $errors['address'] ?></div>
              <?php endif; ?>
            </div>

            <!-- Profile Image Upload -->
            <div class="col-md-12 mb-4">
              <label class="form-label fw-semibold">Profile Photo</label>
              <input type="file"
                     name="profile_image"
                     id="imageInput"
                     accept="image/*"
                     class="form-control <?= isset($errors['profile_image']) ? 'is-invalid' : '' ?>">
              <?php if(isset($errors['profile_image'])): ?>
                <div class="invalid-feedback"><?= $errors['profile_image'] ?></div>
              <?php endif; ?>
              <div class="form-text">JPG, PNG or WEBP only. Max 2MB.</div>
            </div>

          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4 fw-bold">
              💾 Save Changes
            </button>
            <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
              Cancel
            </a>
          </div>

        </form>
      </div>
    </div>
  </div>

</div>

<!-- Live Image Preview JavaScript -->
<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Show preview image
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.classList.remove('d-none');

            // Hide placeholder if it exists
            const placeholder = document.getElementById('preview-placeholder');
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?= $this->endSection() ?>