                    </div>
                    <!-- end container-fluid -->

                </div>
                <!-- end content -->

                
                
                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                &copy; <?= date('Y'); ?> FTAD OneView. All Rights Reserved.
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <div id="renren" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Change Password</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('Pages/change_password_user') ?>" method="post">
                                                            
                                                            <div class="form-group row">
                                                                <div class="col-lg-12">
                                                                    
                                                                    <div class="input-group">
                                                                        <input type="password" 
                                                                            class="form-control" 
                                                                            name="password" 
                                                                            id="password">

                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text" 
                                                                                onclick="togglePassword()" 
                                                                                style="cursor: pointer;">
                                                                                <i class="fa fa-eye" id="toggleIcon"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                    </div>

                                                    <div class="modal-footer">

                                                        <button type="submit" 
                                                                class="btn btn-primary waves-effect waves-light">
                                                            Save
                                                        </button>
                                                    </div>

                                                    </form>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal --></div>
                                        

                                        <div id="ivankylecrodua" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">UPLOAD PROFILE IMAGE</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('Pages/user_profile') ?>" method="post" enctype="multipart/form-data">
                                                            
                                                            <div class="form-group row">
                                                                <div class="col-lg-12">
                                                                   <label>Profile Picture <code>(Accepted file extensions: PNG, JPG, GIF, and JPEG.)</code></label>
                                                                    <input type="file" class="form-control" name="file" required>
                                                                    <p>Limit the size to <span style="color:red; font-weight:bold">1MB only</span>. The recommended size is <span style="color:red; font-weight:bold">128px by 128px</span>.</p> 
                                                                </div>
                                                            </div>

                                                    </div>

                                                    <div class="modal-footer">

                                                        <button type="submit" 
                                                                class="btn btn-primary waves-effect waves-light">
                                                            Save
                                                        </button>
                                                    </div>

                                                    </form>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->

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
                                        </script>

        


        