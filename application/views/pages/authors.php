<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Meet the Authors</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .navbar {
      background-color: #fff;
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

    .author-section {
      padding: 60px 20px;
      background: linear-gradient(to right, #800000, #b22222);
      color: #fff;
      text-align: center;
    }

    .author-section h2 {
      font-weight: 700;
      margin-bottom: 8px;
      font-size: 2.5rem;
      position: relative;
      display: inline-block;
    }

    .author-section h2::after {
      content: '';
      display: block;
      height: 3px;
      width: 50px;
      background: #fff;
      margin: 10px auto 0;
      border-radius: 20px;
    }

    .author-section p {
      font-size: 1.1rem;
      margin-top: 10px;
    }

    .profile-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
      overflow: hidden;
      text-align: center;
      padding: 30px 20px;
      transition: transform 0.4s ease, box-shadow 0.3s ease;
      position: relative;
    }

    .profile-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 14px 50px rgba(218, 165, 32, 0.3);
    }

    .profile-card img {
      width: 130px;
      height: 130px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 18px;
      border: 4px solid #800000;
      transition: transform 0.3s ease;
    }

    .profile-card:hover img {
      transform: scale(1.05);
    }

    .profile-card h5 {
      font-weight: 600;
      margin-bottom: 5px;
      color: #800000;
    }

    .profile-card span {
      display: block;
      color: #555;
      font-size: 0.95rem;
      margin-bottom: 12px;
    }

    .profile-card .social-icons a {
      margin: 0 8px;
      font-size: 1.25rem;
      color: #800000;
      transition: color 0.3s ease;
    }

    .profile-card .social-icons a:hover {
      color: #b22222;
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
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('pages/authors'); ?>">Authors</a></li>
          <li class="nav-item"><a class="nav-link btn ms-2" href="<?= base_url('log_in'); ?>">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Author Section Header -->
  <section class="author-section">
    <div class="container">
      <h2><i class="bi bi-people-fill me-2"></i>Meet the Authors</h2>
      <p>The dedicated minds behind FTAD OneView</p>
    </div>
  </section>

  <!-- Co-Authors -->
  <!-- Co-Authors -->
  <div class="container py-5">
    <div class="row g-4 justify-content-center">

      <!-- Main Author -->
      <h4 class="text-center mt-5" style="color:#800000;">
        <i class="bi bi-star-fill me-2"></i>Main Authors
      </h4>

      <div class="row justify-content-center mt-3 mb-4">
        <div class="col-md-5 col-lg-4" data-aos="fade-up">
          <div class="profile-card shadow-lg position-relative"
            style="border: 3px solid gold; background: linear-gradient(to right, #fffbe6, #fffce0);">

            <img src="<?= base_url(); ?>assets/images/avatar.png" alt="Main Author"
              style="width: 130px; height: 130px; border: 4px solid #b8860b;">
            <h5 style="font-size: 1.4rem; color: #b8860b; margin-top: 15px;">Aris B. Juanillo</h5>
            <span style="font-weight: 500; color: #6a4a00;">Chief Education Supervisor <br>Field Technical Assistance Division</span>
            <div class="social-icons mt-3">
              <a href="#"><i class="bi bi-instagram"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- FTAD Regional Team -->
      <h4 class="text-center mt-5" style="color:#800000;">
        <i class="bi bi-shield-check me-2"></i>FTAD Regional Team
      </h4>
      <div class="row justify-content-center mt-3 mb-4">
        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/avatar.png" alt="QA 1">
            <h5>Ronnie S. Mercado</h5>
            <span>Education Program Supervisor <br>Field Technical Assistance Division</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-linkedin"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/avatar.png" alt="QA 2">
            <h5>Aida P. Placencia</h5>
            <span>Education Program Supervisor <br>Field Technical Assistance Division</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/avatar.png" alt="QA 2">
            <h5>Julieta S. Nicolas</h5>
            <span>Secretariat <br>Field Technical Assistance Division</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

      </div>

      <!-- Quality Assurance Team -->
      <h4 class="text-center mt-5" style="color:#800000;">
        <i class="bi bi-shield-check me-2"></i>Quality Assurance Team
      </h4>
      <div class="row justify-content-center mt-3 mb-4">
        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/authors/cristopher.jpg" alt="QA 1">
            <h5>Cristopher B. Gonzales</h5>
            <span>Education Program Supervisor<br />
              Division of Davao del Norte</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-linkedin"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/authors/cherrie.png" alt="QA 2">
            <h5>Cherrie Anne B. Bohol</h5>
            <span>Education Program Supervisor <br />Division of Digos City</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/avatar.png" alt="QA 2">
            <h5>Elenita L. Bernales</h5>
            <span>Education Program Supervisor <br />Division of Digos City</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

      </div>

      <!-- Developers Team -->
      <h4 class="text-center mt-5" style="color:#800000;">
        <i class="bi bi-code-slash me-2"></i>Developers Team
      </h4>
      <div class="row justify-content-center mt-3">

        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/authors/alan.jpg" alt="Dev 4">
            <h5>Alan D. Limbadan</h5>
            <span>Senior Education Program Specialist <br />Division of Davao Oriental</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-linkedin"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

        <!-- Developer 2 -->
        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/authors/dev1.jpg" alt="Dev 2">
            <h5>Joselito Q. Edong</h5>
            <span>Senior Education Program Specialist <br />Division of Davao Oriental</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

        <!-- Developer 3 -->
        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/authors/ren.jpeg" alt="Dev 3">
            <h5>Ireneo O. Crodua Jr.</h5>
            <span>Programmer <br />Division of Davao Oriental</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-instagram"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>


      </div>

      <!-- Graphic Designer Team -->
      <h4 class="text-center mt-5" style="color:#800000;">
        <i class="bi bi-palette-fill me-2"></i>Graphic Designer
      </h4>
      <div class="row justify-content-center mt-3 mb-4">

        <!-- Designer 1 -->
        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="profile-card">
            <img src="<?= base_url(); ?>assets/images/authors/jann.jpg" alt="Designer 1">
            <h5>Janndale P. Buot</h5>
            <span>Graphic Designer</span>
            <div class="social-icons">
              <a href="#"><i class="bi bi-dribbble"></i></a>
              <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true
    });
  </script>

</body>

</html>