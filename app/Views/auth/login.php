<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row min-vh-75 align-items-center justify-content-center">

  <!-- Left Side — Branding Panel -->
  <div class="col-md-5 d-none d-md-block">
    <div class="p-5 rounded-3 text-white text-center"
         style="background: linear-gradient(135deg, #1a1a2e, #e94560);
                min-height: 400px;
                display:flex !important;
                flex-direction:column;
                justify-content:center;
                align-items:center;">
      <div style="font-size:4rem"><img src="<?= base_url('images/codeig.webp') ?>" 
             alt="LOGO"
             height="60"
             class="rounded mb-2"></div>
      <h2 class="fw-bold mt-3">CI4 CRUD App</h2>
      <p class="opacity-75 mt-2">
        A powerful web application built with CodeIgniter 4
      </p>
      <hr style="border-color:rgba(255,255,255,0.3); width:60%;">
      <p class="small opacity-60">
        Advanced Web Development &mdash; BSIT 3.7
      </p>
    </div>
  </div>

  <!-- Right Side — Login Form -->
  <div class="col-md-4">
    <div class="card shadow-lg border-0" style="border-radius:16px;">
      <div class="card-body p-5">
        <h4 class="fw-bold mb-1">Welcome Back </h4>
        <p class="text-muted small mb-4">Sign in to your account to continue</p>

        <form action="<?= base_url('login') ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label fw-semibold"> Email</label>
            <input type="email" name="email"
                   class="form-control form-control-lg"
                   value="<?= old('email') ?>"
                   placeholder="you@example.com">
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold"> Password</label>
            <input type="password" name="password"
                   class="form-control form-control-lg"
                   placeholder="Enter your password">
          </div>

          <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
            LOGIN →
          </button>
        </form>

        <hr class="my-4">
        <p class="text-center mb-0 small">
          No account yet?
          <a href="<?= base_url('register') ?>" class="fw-bold text-decoration-none">
            Register here
          </a>
        </p>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>