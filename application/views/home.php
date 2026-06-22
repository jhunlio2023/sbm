

  <!-- Hero Section -->
  <div class="hero-section">

   <div class="left">
    
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1>FTAD <span class="highlight-text">OneView v1.0</span></h1>
          <p>FTAD OneView is a monitoring and knowledge management initiative of the Field Technical Assistance Division (FTAD) that unifies school data and insights into a single platform. It is a comprehensive tool for tracking progress, ensuring accountability, and delivering evidence-based technical assistance to support continuous school improvement.</p>
          
          <div class="mt-4 d-flex gap-3 flex-wrap">
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="bi bi-flag-fill me-2"></i>Login To Get Started
            </button>

              <button type="button" class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-life-preserver me-2"></i>Create Account
              </button>
              <ul class="dropdown-menu dropdown-menu-light">
                <li>
                  <a class="dropdown-item" href="<?= base_url('signup'); ?>">
                    School Account
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?= base_url('signup_district'); ?>">
                    District Account
                  </a>
                </li>
              </ul>


          </div>

        

          
        </div>
        <div class="col-lg-6 text-center">
          <!-- <img src="<?= base_url(); ?>assets/images/wel.png" alt="Students working" class="img-fluid rounded"> -->
        </div>
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

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background:#a00000; border:none;">
          <h5 class="modal-title text-white" id="loginModalLabel">
            <img src="<?= base_url(); ?>assets/images/ftad.png" width="30%" alt="">
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="loginAlert"></div>
          <form id="loginForm">
            <div class="form-group mb-3">
              <label for="username">Username or Email:</label>
              <input class="form-control" type="text" id="username" name="username" autocomplete="off" required>
            </div>

            <div class="form-group mb-3">
              <label for="password">Password:</label>
              <div class="password-wrapper" style="position: relative;">
                <input 
                  id="password"
                  class="form-control password-input" 
                  type="password" 
                  required 
                  name="password" 
                  autocomplete="off"
                  style="padding-right: 45px;"
                >
                <button type="button" class="toggle-password" onclick="togglePassword()" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); border: none; background: transparent; padding: 0; margin: 0; color: #6c757d; cursor: pointer; outline: none;">
                  <i class="fa fa-eye" id="toggleIcon"></i>
                </button>
              </div>
            </div>

            <div class="form-group mb-3">
              <a href="#" class="text-muted" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
            </div>

            <div class="form-group text-center mb-3">
              <button class="btn btn-md btn-block waves-effect waves-light" style="background:#a00000; color:#ffc107; width: 100%;" type="submit" name="submit">Sign In</button>
            </div>

            <p class="text-center">Don't have an account yet? <a href="<?= base_url('signup'); ?>"><span class="badge" style="background:#ffc107; color:#000">Sign up</span></a> to get started.</p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" style="background:#a00000; border:none;">
          <h5 class="modal-title text-white" id="forgotPasswordModalLabel">
            <img src="<?= base_url(); ?>assets/images/ftad.png" width="30%" alt="">
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="forgotPasswordAlert"></div>
          <form id="forgotPasswordForm">
            <div class="form-group mb-3">
              <label for="email">Email Address:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group text-center mb-3">
              <button class="btn btn-md btn-block waves-effect waves-light" style="background:#a00000; color:#ffc107; width: 100%;" type="submit" name="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <script>
    function togglePassword() {
      const password = document.getElementById("password");
      const icon = document.getElementById("toggleIcon");

      if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }

    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const alertDiv = document.getElementById('loginAlert');
      const submitBtn = this.querySelector('button[type="submit"]');
      
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Signing in...';
      
      fetch('<?= base_url('log_in'); ?>', {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = '<?= base_url(); ?>';
        } else {
          alertDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + (data.message || 'Invalid username or password.') + '</div>';
          submitBtn.disabled = false;
          submitBtn.innerHTML = 'Sign In';
        }
      })
      .catch(error => {
        alertDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>An error occurred. Please try again.</div>';
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Sign In';
      });
    });

    document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const alertDiv = document.getElementById('forgotPasswordAlert');
      const submitBtn = this.querySelector('button[type="submit"]');
      
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Submitting...';
      
      fetch('<?= base_url('Pages/forgot_password'); ?>', {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alertDiv.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + (data.message || 'Password reset link has been sent to your email.') + '</div>';
          this.reset();
        } else {
          alertDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + (data.message || 'Email not found.') + '</div>';
        }
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Submit';
      })
      .catch(error => {
        alertDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>An error occurred. Please try again.</div>';
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Submit';
      });
    });
  </script>
</body>

</html>