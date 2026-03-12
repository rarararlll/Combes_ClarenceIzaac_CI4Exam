<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow">
      <div class="card-body p-4">
        <h4 class="card-title text-center mb-4">📝 Register</h4>

        <form action="<?= base_url('register') ?>" method="post">
          <?= csrf_field() ?>

          <!-- Full Name -->
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name"
                   class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                   value="<?= old('name') ?>"
                   placeholder="Enter your full name">
            <?php if(isset($errors['name'])): ?>
              <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
            <?php endif; ?>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email"
                   class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                   value="<?= old('email') ?>"
                   placeholder="Enter your email">
            <?php if(isset($errors['email'])): ?>
              <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
            <?php endif; ?>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password"
                   class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                   placeholder="Minimum 6 characters">
            <?php if(isset($errors['password'])): ?>
              <div class="invalid-feedback"><?= esc($errors['password']) ?></div>
            <?php endif; ?>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password"
                   class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>"
                   placeholder="Re-enter your password">
            <?php if(isset($errors['confirm_password'])): ?>
              <div class="invalid-feedback"><?= esc($errors['confirm_password']) ?></div>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-3 mb-0">
          Already have an account? <a href="/login">Login here</a>
        </p>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>