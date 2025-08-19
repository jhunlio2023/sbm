

  <!-- Hero Section -->
  <div class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1>FTAD <span class="highlight-text">OneView v1.0</span></h1>
          <p>FTAD OneView is a monitoring and knowledge management initiative of the Field Technical Assistance Division (FTAD) that unifies school data and insights into a single platform. It is a comprehensive tool for tracking progress, ensuring accountability, and delivering evidence-based technical assistance to support continuous school improvement.</p>
          <div class="mt-4 d-flex gap-3 flex-wrap">
            <a href="<?= base_url('log_in'); ?>" class="btn btn-light">
              <i class="bi bi-flag-fill me-2"></i>Login To Get Started
            </a>

            <a href="<?= base_url('signup'); ?>" class="btn btn-outline-light">
              <i class="bi bi-life-preserver me-2"></i>Create an Account
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
  <div class="feature-icons py-5">
    <div class="container">
      <div class="row g-4">

        <!-- Technical Assistance -->
        <div class="col-md-3 text-center">
          <i class="bi bi-tools fs-1 text-primary"></i>
          <p class="mt-2 fw-semibold">Technical Assistance</p>
        </div>

        <!-- Knowledge Management -->
        <div class="col-md-3 text-center">
          <i class="bi bi-journal-bookmark-fill fs-1 text-success"></i>
          <p class="mt-2 fw-semibold">Knowledge Management</p>
        </div>

        <!-- Organization Management -->
        <div class="col-md-3 text-center">
          <i class="bi bi-diagram-3-fill fs-1 text-warning"></i>
          <p class="mt-2 fw-semibold">Organization Management</p>
        </div>

        <!-- Project Management -->
        <div class="col-md-3 text-center">
          <i class="bi bi-kanban-fill fs-1 text-danger"></i>
          <p class="mt-2 fw-semibold">Project Management</p>
        </div>

      </div>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>