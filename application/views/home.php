<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduAlert - Empowering and Defending Underage learners through Active Logging of Events, Reports, and Threats</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    :root {
      --primary-color: #800000;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }

  .navbar {
  background-color: #fff; /* Light on desktop */
  transition: background-color 0.3s ease;
}

.navbar-toggler {
  border-color: #800000;
}

.navbar-toggler-icon {
  background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(128,0,0, 1)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}


.navbar .nav-link {
  position: relative;
  color: #800000 !important;
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
  background-color: #800000;
  transition: width 0.3s;
}

.navbar .nav-link:hover::after {
  width: 100%;
}

.navbar .nav-link:hover {
  color: #a00000 !important;
}

.navbar .nav-link.btn {
  border: 2px solid #800000;
  color: #800000 !important;
  border-radius: 20px;
  transition: all 0.3s ease;
}

.navbar .nav-link.btn:hover {
  background-color: #800000;
  color: #fff !important;
}


  .hero-section {
  background: url("<?= base_url(); ?>assets/images/bgwel.jpg") no-repeat center left;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  color: #fff;
  height: 600px; /* ✅ Fixed height */
  position: relative;
  display: flex;
  align-items: center;
}

    .hero-section .left {
      padding: 0 40px;
    }

    .hero-section h1 {
      font-size: 3rem;
      font-weight: 700;
    }

    .hero-section p {
      font-size: 1.1rem;
      margin-top: 20px;
      color: #f0f0f0;
    }

    .hero-section .btn {
      font-size: 1rem;
      padding: 12px 30px;
    }

    .hero-section .btn-outline-light {
      color: #fff;
      border-color: #fff;
    }

    .hero-section .btn-light {
      background-color: #fff;
      color: var(--primary-color);
    }

    .feature-icons {
      background-color: #fff;
      padding: 40px 20px;
      text-align: center;
    }

    .feature-icons i {
      font-size: 2rem;
      color: var(--primary-color);
    }

    .feature-icons p {
      margin-top: 10px;
    }

    .highlight-text {
    color: #ffc107; /* Example: Bootstrap warning yellow */
    font-weight: bold;
    }

    @media (max-width: 768px) {
      .hero-section {
        text-align: center;
      }
      .hero-section .left,
      .hero-section .right {
        padding: 20px;
      }

       .navbar .nav-link {
    color: #800000 !important;
  }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url(); ?>">
        <img src="<?= base_url(); ?>assets/images/drkedu.png" alt="Logo" height="40">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
              <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="#">About</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
              <li class="nav-item"><a class="nav-link" href="<?= base_url('pages/authors'); ?>">Authors</a></li>
             <li class="nav-item"><a class="nav-link" href="<?= base_url('pages/tracking'); ?>">Tracking</a></li>
              <li class="nav-item"><a class="nav-link btn ms-2" href="log_in">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <h1>Welcome to Edu<span class="highlight-text">Alert</span></h1>
        <p>EduAlert is a School Incident Reporting System designed to empower students, faculty, and staff in reporting and tracking school-related incidents securely—identified or anonymously.</p>
        <div class="mt-4 d-flex gap-3 flex-wrap">
          <a href="<?= base_url('incident_report'); ?>" class="btn btn-light">
            <i class="bi bi-flag-fill me-2"></i>Submit Incident Report
          </a>
          <a href="<?= base_url('help'); ?>" class="btn btn-outline-light">
            <i class="bi bi-life-preserver me-2"></i>Seek Help
          </a>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <!-- <img src="<?= base_url(); ?>assets/images/wel.png" alt="Students working" class="img-fluid rounded"> -->
      </div>
    </div>
  </div>
</div>

  <!-- Features -->
  <div class="feature-icons">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-3 text-center">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <p>Report incidents easily and accurately</p>
      </div>
      <div class="col-md-3 text-center">
        <i class="bi bi-shield-lock-fill"></i>
        <p>Submit reports anonymously and securely</p>
      </div>
      <div class="col-md-3 text-center">
        <i class="bi bi-clock-history"></i>
        <p>Track updates and responses in real time</p>
      </div>
      <div class="col-md-3 text-center">
        <i class="bi bi-people-fill"></i>
        <p>Engage students, teachers, and staff in safe learning</p>
      </div>
    </div>
  </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
