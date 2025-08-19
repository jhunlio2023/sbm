<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About • FTAD OneView</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

  <style>
    :root {
      --ftad-maroon: #800000;
      --ftad-maroon-dark: #6b0000;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .navbar {
      background-color: #fff;
      transition: background-color 0.3s ease;
    }

    .navbar-toggler {
      border-color: var(--ftad-maroon);
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(128,0,0, 1)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .navbar .nav-link {
      position: relative;
      color: var(--ftad-maroon) !important;
      font-weight: 500;
      padding: 8px 12px;
      transition: color 0.3s ease;
    }

    .navbar .nav-link::after {
      content: '';
      position: absolute;
      width: 0%;
      height: 2px;
      left: 0;
      bottom: 0;
      background-color: var(--ftad-maroon);
      transition: width 0.3s;
    }

    .navbar .nav-link:hover::after {
      width: 100%;
    }

    .navbar .nav-link:hover {
      color: #a00000 !important;
    }

    .navbar .nav-link.btn {
      border: 2px solid var(--ftad-maroon);
      color: var(--ftad-maroon) !important;
      border-radius: 20px;
      transition: all 0.3s ease;
    }

    .navbar .nav-link.btn:hover {
      background-color: var(--ftad-maroon);
      color: #fff !important;
    }

    .hero {
      background: linear-gradient(135deg, var(--ftad-maroon), #b22222);
      color: #fff;
      padding: 80px 0 70px;
    }

    .hero h1 {
      font-weight: 700;
    }

    .hero .lead {
      opacity: 0.95;
    }

    .section-title {
      color: var(--ftad-maroon);
      font-weight: 700;
      margin-bottom: 1rem;
      text-align: center;
    }

    .section-underline {
      width: 60px;
      height: 4px;
      background: var(--ftad-maroon);
      border-radius: 10px;
      margin: 0.5rem auto 2rem;
    }

    .card-soft {
      border: 0;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
      background: #fff;
    }

    .icon-badge {
      width: 56px;
      height: 56px;
      display: grid;
      place-items: center;
      border-radius: 50%;
      background: #fff;
      box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
      color: var(--ftad-maroon);
    }

    .feature-icons i {
      transition: transform .2s ease;
    }

    .feature-icons .col-md-3:hover i {
      transform: translateY(-4px);
    }

    .timeline {
      position: relative;
      padding-left: 24px;
    }

    .timeline::before {
      content: '';
      position: absolute;
      left: 10px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: #e3e6ea;
    }

    .tl-item {
      position: relative;
      margin-bottom: 1.25rem;
    }

    .tl-item::before {
      content: '';
      position: absolute;
      left: -2px;
      top: 6px;
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background: var(--ftad-maroon);
    }

    .footer-cta {
      background: linear-gradient(135deg, #b22222, var(--ftad-maroon));
      color: #fff;
      border-radius: 20px;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url(); ?>">
        <img src="<?= base_url(); ?>assets/images/ftad-logo.jpg" alt="Logo" height="80" width="200">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="OneView/about">About</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="manualsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Manuals
            </a>
            <ul class="dropdown-menu" aria-labelledby="manualsDropdown">
              <li><a class="dropdown-item" href="<?= base_url('resources/FTAD_Manual-for-Dissemination.pdf'); ?>" target="_blank">FTAD Manual</a></li>
              <li><a class="dropdown-item" href="<?= base_url('resources/GAD_Manual_FTAD-for-Dissemination-1.pdf'); ?>" target="_blank">GAD Manual</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('OneView/authors'); ?>">Authors</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <header class="hero">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-7" data-aos="fade-right">
          <h1>About FTAD OneView</h1>
          <p class="lead mb-3">A unified window for Technical Assistance, Knowledge Management, Organization Management, and Project Management across DepEd Region XI.</p>
          <div class="d-flex gap-3 flex-wrap">


          </div>
        </div>
        <div class="col-lg-5" data-aos="fade-left">
          <div class="card card-soft p-4">
            <div class="d-flex align-items-center gap-3">
              <div class="icon-badge"><i class="bi bi-window-sidebar fs-3"></i></div>
              <div>
                <h5 class="mb-1">Why OneView?</h5>
                <p class="mb-0 small text-muted">Streamlines TA workflows, centralizes knowledge, and tracks initiatives—on one cohesive platform.</p>
              </div>
            </div>
            <hr class="my-3">
            <div class="d-flex align-items-center gap-3">
              <div class="icon-badge"><i class="bi bi-speedometer2 fs-3"></i></div>
              <div>
                <h6 class="mb-1">Faster Coordination</h6>
                <p class="mb-0 small text-muted">Reduce back‑and‑forth by giving stakeholders a single source of truth.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>



  <!-- What OneView Covers -->
  <section class="py-4">
    <div class="container">
      <h2 class="section-title" data-aos="fade-up">What OneView Covers</h2>
      <div class="section-underline" data-aos="fade-up"></div>

      <!-- Feature Icons (improved mappings) -->
      <div class="feature-icons py-3">
        <div class="row g-4">
          <!-- Technical Assistance -->
          <div class="col-6 col-md-3 text-center" data-aos="zoom-in">
            <i class="bi bi-tools fs-1 text-primary"></i>
            <p class="mt-2 fw-semibold mb-0">Technical Assistance</p>
            <small class="text-muted">Requests, assignments & tracking</small>
          </div>
          <!-- Knowledge Management -->
          <div class="col-6 col-md-3 text-center" data-aos="zoom-in" data-aos-delay="50">
            <i class="bi bi-journal-bookmark-fill fs-1 text-success"></i>
            <p class="mt-2 fw-semibold mb-0">Knowledge Management</p>
            <small class="text-muted">Guides, templates & resources</small>
          </div>
          <!-- Organization Management -->
          <div class="col-6 col-md-3 text-center" data-aos="zoom-in" data-aos-delay="100">
            <i class="bi bi-diagram-3-fill fs-1 text-warning"></i>
            <p class="mt-2 fw-semibold mb-0">Organization Management</p>
            <small class="text-muted">Structure, roles & workflows</small>
          </div>
          <!-- Project Management -->
          <div class="col-6 col-md-3 text-center" data-aos="zoom-in" data-aos-delay="150">
            <i class="bi bi-kanban-fill fs-1 text-danger"></i>
            <p class="mt-2 fw-semibold mb-0">Project Management</p>
            <small class="text-muted">Milestones, KPIs & reports</small>
          </div>
        </div>
      </div>



    </div>
  </section>

  <!-- Timeline -->
  <!-- References -->
  <section class="py-5">
    <div class="container">
      <h2 class="section-title" data-aos="fade-up">References</h2>
      <div class="section-underline" data-aos="fade-up"></div>
      <div class="row g-4">
        <div class="col-lg-8 mx-auto">
          <div class="card card-soft p-4" data-aos="fade-up">
            <h5 class="mb-3">DepEd Orders Related to School-Based Management (SBM)</h5>
            <ul class="list-group list-group-flush">

              <!-- SBM References -->
              <li class="list-group-item">
                <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                <strong>DepEd Order No. 83, s. 2012</strong> – Implementing Guidelines on the Revised School-Based Management (SBM) Framework, Assessment Process and Tool (APAT).
              </li>
              <li class="list-group-item">
                <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                <strong>DepEd Order No. 44, s. 2015</strong> – Guidelines on the Enhanced School Improvement Planning (SIP) Process and the School Report Card (SRC).
              </li>
              <li class="list-group-item">
                <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                <strong>DepEd Order No. 42, s. 2016</strong> – Policy Guidelines on Daily Lesson Preparation for the K to 12 Basic Education Program (supporting SBM in instructional planning).
              </li>
              <li class="list-group-item">
                <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                <strong>DepEd Order No. 24, s. 2022</strong> – Adoption of the Basic Education Monitoring and Evaluation Framework (BEMEF) aligned with SBM implementation.
              </li>

            </ul>


          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Contact / CTA -->
  <section class="py-5">
    <div class="container">
      <div class="footer-cta p-5" data-aos="zoom-in">
        <div class="row align-items-center g-4">
          <div class="col-lg-8">
            <h3 class="mb-2">Partner with FTAD OneView</h3>
            <p class="mb-0">Have suggestions or need assistance? Reach out for collaboration, training, or support.</p>
          </div>
          <div class="col-lg-4 text-lg-end">
            <a href="mailto:ftad.region11@deped.gov.ph" class="btn btn-light btn-lg">
              <i class="bi bi-envelope me-2"></i>Email FTAD Region XI
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer mini -->
  <footer class="py-4">
    <div class="container text-center small text-muted">
      <div>© <span id="y"></span> FTAD OneView • DepEd Region XI</div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true
    });
    document.getElementById('y').textContent = new Date().getFullYear();
  </script>
</body>

</html>