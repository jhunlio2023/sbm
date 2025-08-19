                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    

                                
                                    <div class="clearfix"></div>

                                    <?php if($this->session->flashdata('success')) : ?>

                                        <?= '<br /><div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>'
                                                .$this->session->flashdata('success'). 
                                            '</div>'; 
                                        ?>
                                        <?php endif; ?>

                                        <?php if($this->session->flashdata('danger')) : ?>
                                        <?= '<br /><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>'
                                                .$this->session->flashdata('danger'). 
                                            '</div>'; 
                                        ?>
                                        <?php endif;  ?>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                       <!-- ============================================================== -->
                       <!-- Main Content here -->
                       <!-- ============================================================== -->


                        <!-- start page title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="profile-bg-picture" style="background-image:url('<?= base_url(); ?>assets/images/bg-profile.jpg')">
                                    <span class="picture-bg-overlay"></span>
                                    <!-- overlay -->
                                </div>
                                <!-- meta -->
                                <div class="profile-user-box">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="profile-user-img"><img src="<?= base_url(); ?>assets/images/users/avatar-1.jpg" alt="" class="avatar-lg rounded-circle"></div>
                                            <div class="">
                                                <h4 class="mt-5 font-18 ellipsis"><?= $data->schoolName; ?></h4>
                                                <!-- <p class="font-13"> User Experience Specialist</p>
                                                <p class="text-muted mb-0"><small>California, United States</small></p> -->
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-right">
                                                <button type="button" class="btn btn-success waves-effect waves-light">
                                                    <i class="mdi mdi-account-settings-variant mr-1"></i> Edit Profile
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ meta -->
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="card p-0">
                                    <div class="card-body p-0">
                                        <ul class=" nav nav-tabs tabs-bordered nav-justified">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#aboutme">About The School</a></li>
                                        </ul>

                                        <div class="tab-content m-0 p-4">

                                            <div id="aboutme" class="tab-pane active">
                                                <div class="profile-desk">

                                                    <h5 class="mt-4">Official Information</h5>
                                                    <table class="table table-condensed mb-0">
                                                        
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">School Head</th>
                                                                    <td><?= $data->schoolName; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">School Head Designation</th>
                                                                    <td><?= $data->adminDesignation; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">School Head Email</th>
                                                                    <td><?= $data->adminEmail; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">School Email</th>
                                                                    <td><?= $data->schoolEmail; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">School Email</th>
                                                                    <td><?= $data->schoolEmail; ?></td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end profile-desk -->
                                                </div> <!-- about-me -->

                                                

                                                

                                        </div> 
                                    </div>
                                </div>
                            <!-- end page title -->

                        </div>
                        <!-- end row -->


                        
                        