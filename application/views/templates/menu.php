<body>

    <!-- Begin page -->
    <div id="wrapper">


        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">


                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <?php $image = $this->Common->one_cond_row_select('users','username,image','username',$this->session->username); if (empty($image->image ?? null)) {?>
                            <img src="<?= base_url(); ?>assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                        <?php }else{ ?>
                            <img src="<?= base_url(); ?>uploads/<?= $image->image; ?>" alt="user-image" class="rounded-circle">
                        <?php } ?>
                        <span class="pro-user-name ml-1">
                            <?= $this->session->user; ?> <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <?php if($this->session->position == 'school'){?>
                            <a href="<?= base_url(); ?>school/<?= $this->session->username; ?>" class="dropdown-item notify-item">
                        <?php }else{ ?>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <?php } ?>
                            <i class="mdi mdi-account-outline"></i>
                            <span>Profile</span>
                        </a>

                        <!-- item-->
                        <a href="<?= base_url(); ?>lock" class="dropdown-item notify-item" data-toggle="modal" data-target="#ivankylecrodua">
                            <i class="mdi mdi-lock-outline"></i>
                            <span>Change Profile Image</span>
                        </a>



                        <!-- item-->
                        <a href="<?= base_url(); ?>lock" class="dropdown-item notify-item">
                            <i class="mdi mdi-lock-outline"></i>
                            <span>Lock Screen</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="<?= base_url(); ?>logout" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout-variant"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>




            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="<?= base_url(); ?>" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="<?= base_url(); ?>assets/images/ftad.png" alt="" height="50">
                        <!-- <span class="logo-lg-text-dark">Velonic</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-lg-text-dark">V</span> -->
                        <img src="<?= base_url(); ?>assets/images/logo-sm.png" alt="" height="22">
                    </span>
                </a>

                <a href="<?= base_url(); ?>" class="logo text-center logo-light">
                    <span class="logo-lg">
                        <img src="<?= base_url(); ?>assets/images/ftad.png" alt="" height="50">
                        <!-- <span class="logo-lg-text-dark">Velonic</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-lg-text-dark">V</span> -->
                        <img src="<?= base_url(); ?>assets/images/logo-sm.png" alt="" height="22">
                    </span>
                </a>
            </div>

            <!-- LOGO -->


            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>


            </ul>
        </div>
        <!-- end Topbar --> <!-- ========== Left Sidebar Start ========== -->

        <div class="left-side-menu">

            <div class="slimscroll-menu">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <ul class="metismenu" id="side-menu">

                        <li class="menu-title">Navigation</li>

                        <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span> Dashboard </span></a></li>
                        <?php if ($this->session->position == 'district') { ?>
                            <li><a href="<?= base_url(); ?>pages/schools_district/<?= $this->session->district; ?>" class="waves-effect"><i class="fas fa-school"></i><span>Schools</span></a></li>
                            <li>
                                <a href="<?= base_url(); ?>Pages/school_list" class="waves-effect">
                                    <i class="fas fa-book-reader"></i>
                                    <span> SBM </span>
                                </a>

                            </li>
                            <li>
                                <a href="<?= base_url(); ?>Pages/sbm_district_tech" class="waves-effect">
                                    <i class="fas fa-wrench"></i>
                                    <span> Technical Assisstance </span>
                                </a>

                            </li>
                            <li><a href="#" class="waves-effect" data-toggle="modal" data-target="#renren"><i class="fas fa-lock"></i><span>Change Password</span></a></li>
                        <?php } ?>

                        <?php if ($this->session->position == 'school') { ?>

                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="mdi mdi-format-list-checks"></i>
                                    <span> SBM</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>Pages/sbm_action_plan">Action Plan</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/sbm_checklist">Self-Assessment</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/tapr_form">TA Form</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/tana_form">TANA Form</a></li>
                                </ul>
                            </li>
                            <li><a href="#" class="waves-effect" data-toggle="modal" data-target="#renren"><i class="fas fa-lock"></i><span>Change Password</span></a></li>
                        <?php } ?>

                        <?php if ($this->session->position == 'division') { ?>
                            <!-- <li><a href="<?= base_url(); ?>pages/schools_division/<?= $this->session->division; ?>" class="waves-effect"><i class="fas fa-school"></i><span>Schools</span></a></li> -->
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="fas fa-cogs"></i>
                                    <span> Division Settings</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>pages/district_account/<?= $this->session->division; ?>">Districts</a></li>
                                    <li><a href="<?= base_url(); ?>pages/userlist_division">Manage Users</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/division_setup">Division Setup</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="mdi mdi-format-list-checks"></i>
                                    <span> SBM</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>Pages/district_list">District List</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/tana_summary_division">TANA</a></li>
                                </ul>

                            </li>
                            <li><a href="#" class="waves-effect" data-toggle="modal" data-target="#renren"><i class="fas fa-lock"></i><span>Change Password</span></a></li>

                        <?php } ?>

                        <?php if ($this->session->position == 'region') { ?>

                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="mdi mdi-format-list-checks"></i>
                                    <span> SBM</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>Pages/division_list">Division List</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/tana_summary_region">TANA</a></li>
                                </ul>

                            </li>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="mdi mdi-chart-line"></i>
                                    <span> Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>Pages/report_division_submission">Division Submission</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/report_overall_accomplishments">Overall Accomplishments</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/report_sgc">School Governance Council</a></li>
                                </ul>
                            </li>
                            <li><a href="#" class="waves-effect" data-toggle="modal" data-target="#renren"><i class="fas fa-lock"></i><span>Change Password</span></a></li>

                        <?php } ?>

                        <?php if ($this->session->position == 'admin') { ?>
                            <li><a href="<?= base_url(); ?>pages/school_by_district" class="waves-effect"><i class="fas fa-school"></i><span>Schools</span></a></li>
                            <li><a href="<?= base_url(); ?>pages/userlist" class="waves-effect"><i class="mdi mdi-account-supervisor"></i><span> Manage Users </span></a></li>
                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="mdi mdi-chart-line"></i>
                                    <span> Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>Pages/report_division_submission">Division Submission</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/report_overall_accomplishments">Overall Accomplishments</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/report_sgc">School Governance Council</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ($this->session->position == 'ict') { ?>
                            <li><a href="<?= base_url(); ?>pages/schools/<?= $this->session->division; ?>" class="waves-effect"><i class="fas fa-school"></i><span>Schools</span></a></li>
                            <li><a href="<?= base_url(); ?>pages/userlist_division" class="waves-effect"><i class="mdi mdi-account-supervisor"></i><span> Manage Users </span></a></li>
                        <?php } ?>
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
