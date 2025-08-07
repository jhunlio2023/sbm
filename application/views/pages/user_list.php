                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <a class="btn btn-success" href="<?= base_url(); ?>pages/user_new">Add New</a>
                                    

                                
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



                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <h4 class="m-t-0 header-title mb-4"><?= $title; ?></h4>

                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>Fullname</th>
                                                    <th>Username</th>
                                                    <th>Position</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($users as $row){?>
                                                <tr>
                                                    <td><?= $row->lname.', '.$row->fname; ?> <?php if(!empty($row->mname)){echo substr($row->mname, 0, 1).'.';} ?></td>
                                                    <td><?= $row->username; ?></td>
                                                    <td><?= $row->position; ?></td>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm" href="<?= base_url(); ?>pages/user_update/<?= $row->id; ?>">Edit</a>
                                                        <a href="#cp" class="open-AddBookDialog btn btn-warning btn-sm waves-effect waves-light" data-id="<?= $row->id; ?>" data-animation="newspaper" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a">Change Password</a>
                                                        <a href="#profile" class="open-AddBookDialog btn btn-primary btn-sm waves-effect waves-light" data-id="<?= $row->id; ?>" data-animation="slit" data-plugin="custommodal" data-overlayspeed="100" data-overlaycolor="#36404a">Change profile</a>
                                                    
                                                        
                                                        <?php if($this->session->position == 'admin'){ ?>
                                                        <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="<?= base_url(); ?>pages/user_delete/<?= $row->id; ?>">Delete</a>
                                                        <?php } ?>
                                                        
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <!-- Modal -->
                        <div id="cp" class="modal-demo">
                            <button type="button" class="close" onclick="Custombox.modal.close();">
                                <span>&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="custom-modal-title">Change Password</h4>
                            <div class="custom-modal-text">
                                
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?php 
                                            $attributes = array('class' => 'parsley-examples');
                                            echo form_open('pages/cp', $attributes);
                                        ?>

                                            <div class="modal-body">
                                                <input type="hidden" name="id" id="id" value="">            
                                            </div> 
                                            
                                            <div class="form-group row">
                                                <label for="hori-pass1" class="col-md-4 col-form-label">Password<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input id="myInput" type="password" placeholder="Password" name="password"  required class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="hori-pass2" class="col-md-4 col-form-label">Confirm Password
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input id="myInput2" data-parsley-equalto="#myInput" type="password" name="cpassword" required placeholder="Password" class="form-control" id="hori-pass2">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-8 offset-md-4">
                                                    <div class="checkbox checkbox-purple">
                                                        <input id="checkbox6" type="checkbox" onclick="myFunction()">
                                                        <label for="checkbox6">
                                                            Show Password
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Change Password
                                                    </button>
                                                    <button type="reset" class="btn btn-secondary waves-effect waves-light">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            </div>
                            <!-- end row -->
                            </div>
                        </div>


                        <!-- Modal -->
                        <div id="profile" class="modal-demo">
                            <button type="button" class="close" onclick="Custombox.modal.close();">
                                <span>&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="custom-modal-title">Change Profile Picture</h4>
                            <div class="custom-modal-text">
                                
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?php 
                                            $attributes = array('class' => 'parsley-examples');
                                            echo form_open_multipart('pages/profile', $attributes);
                                        ?>

                                            <div class="modal-body">
                                                <input type="hidden" name="id" id="id" value="">            
                                            </div> 
                                            
                                            <div class="form-group row">
                                                <label for="hori-pass1" class="col-md-4 col-form-label">Select Image<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input id="myInput" type="file" placeholder="Password" name="file"  required class="form-control">
                                                </div>
                                            </div>

                                          
                                            
                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Change Profile
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            </div>
                            <!-- end row -->
                            </div>
                        </div>



                        <script>
                        function myFunction() {
                        var x = document.getElementById("myInput");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                        var x = document.getElementById("myInput2");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                        }
                        </script>

                        