    <!DOCTYPE html>
    <html lang="en">
    <head>
        <style>
  /* Custom Color Variables */
  :root {
    --primary: #1a1a2e;
    --accent: #e94560;
    --secondary: #16213e;
    --light-bg: #f0f2f5;
  }

  body {
    color: #ffffff;
    background-color: #eef2f7;
    background: fixed #979090
    min-height: 100vh;
    background-color: var(--light-bg);
    font-family: 'Poppins', sans-serif;
  }
  .text-muted {
    color: rgba(255,255,255,0.6) !important;
  }
  p, h1, h2, h3, h4, h5,  {
    color: #4d4c4c;
  }


  .navbar {
    background: linear-gradient(135deg, #1a1a2e, #16213e) !important;
    box-shadow: 0 2px 15px rgba(0,0,0,0.2);
  }

  .btn-primary {
    background: var(--accent) !important;
    border-color: var(--accent) !important;
  }

  .btn-primary:hover {
    background: #c73652 !important;
    transform: translateY(-2px);
    transition: all 0.2s;
  }

  .card {
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    background: rgba(255, 255, 255, 0.05) !important;
    color: #000000 !important;
    backdrop-filter: blur(10px);
    border-radius: 12px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15) !important;
  }
  .table {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.table thead tr {
    background: linear-gradient(135deg, #1a1a2e, #16213e) !important;
    color: white !important;
}

.table thead th {
    border: none !important;
    padding: 15px !important;
    font-weight: 600;
    letter-spacing: 0.5px;
    color: white !important;
}

.table tbody tr {
    transition: all 0.2s;
    border-bottom: 1px solid #f0f2f5;
}

.table tbody tr:hover {
    background: #fff5f7 !important;
    transform: scale(1.01);
}

.table tbody td {
    padding: 12px 15px !important;
    vertical-align: middle !important;
}

.card {
    border: none !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    transition: all 0.3s ease !important;
    overflow: hidden;
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #e94560, #1a1a2e);
}

.card {
    position: relative;
}

.card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 12px 35px rgba(0,0,0,0.15) !important;
}
  .navbar-brand {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 1px;
  }

  /* Page fade-in animation */
  .container {
    animation: fadeIn 0.4s ease-in;
  }
  .form-control {
    background: rgba(255,255,255,0.1) !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
    color: #000000 !important;
  }
  

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }
</style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CI4 CRUD App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">

    <a class="navbar-brand fw-bold" href="<?= base_url('dashboard') ?>">
      <img src="<?= base_url('images/kitty.png') ?>" 
           height="35" 
           alt="Logo"
           class="rounded me-2"
           style="filter: brightness(0) invert(1);">
      CI4 App
    </a>
    
    <?php if(session()->get('isLoggedIn')): ?>
    <div class="ms-auto d-flex align-items-center gap-3">
      <a href="<?= base_url('profile') ?>" 
     class="text-white text-decoration-none fw-semibold">
    👤 <?= esc(session()->get('userName')) ?>
  </a>

  <a href="<?= base_url('records') ?>" class="btn btn-outline-light btn-sm">Records</a>
  <a href="<?= base_url('logout') ?>"  class="btn btn-danger btn-sm">Logout</a>
</div>
<?php endif; ?>
  
  </div>
</nav>

    <div class="container mt-4">

    <!-- Success Flash Message -->
<?php if(session()->getFlashdata('success')): ?>
  <div class="alert border-0 text-white mb-4"
       style="background: linear-gradient(135deg, #28a745, #20c997);
              border-radius: 12px;
              box-shadow: 0 4px 15px rgba(40,167,69,0.3);">
    ✅ <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<!-- Error Flash Message -->
<?php if(session()->getFlashdata('error')): ?>
  <div class="alert border-0 text-white mb-4"
       style="background: linear-gradient(135deg, #e94560, #c73652);
              border-radius: 12px;
              box-shadow: 0 4px 15px rgba(233,69,96,0.3);">
    ❌ <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<!-- Validation Errors -->
<?php if(session()->getFlashdata('errors')): ?>
  <div class="alert border-0 text-white mb-4"
       style="background: linear-gradient(135deg, #e94560, #c73652);
              border-radius: 12px;
              box-shadow: 0 4px 15px rgba(233,69,96,0.3);">
    <strong>⚠️ Please fix the following:</strong>
    <ul class="mb-0 mt-1">
      <?php foreach(session()->getFlashdata('errors') as $err): ?>
        <li><?= esc($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

    <!-- Page Content Injected Here -->
    <?= $this->renderSection('content') ?>

    </div>

    <!-- Footer -->

    
   <footer class="text-center text-muted py-4 mt-5 border-top" 
        style="margin-top: 100px !important;">
    
    <div>
        <img src="<?= base_url('images/cat hands.gif') ?>" 
             alt="LOGO"
             height="60"
             class="rounded mb-2">
    </div>

    <div>
        <small>CI4 CRUD Exam &mdash; Clarence Izaac E. Combes</small>
    </div>

    <div>
        <small> National Teachers College</small>
    </div>

    <div>
        <small>&copy; 2026 CC. | Advanced Web Development | BSIT 3.7</small>
    </div>
    <div>
        <img src="<?= base_url('images/cat hands.gif') ?>" 
             alt="LOGO"
             height="60"
             class="rounded mb-2">
    </div>

</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>