                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h5>List of District</h5>
                                    

                                
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
                            <div class="col-lg-12">
                                <div id="accordion" class="mb-3">
                                    <?php $i = 0; foreach ($district as $row) { $i++; 
                                    $school = $this->Common->one_cond_select('schools','schoolName,district_id,schoolID,schoolType,recID,division_id','district_id',$row->id);
                                    $cd = $this->Common->two_cond_count_row('users','position','district','d_id',$row->id);
                                    ?>
                                        <div class="card mb-0">
                                            <div class="card-header" id="heading<?= $i; ?>">
                                                <h6 class="m-0">
                                                    <a href="#collapse<?= $i; ?>"
                                                    class="text-dark <?= ($i != 1) ? 'collapsed' : ''; ?>"
                                                    data-toggle="collapse"
                                                    aria-expanded="<?= ($i == 1) ? 'true' : 'false'; ?>"
                                                    aria-controls="collapse<?= $i; ?>">
                                                        <?= $row->description; ?> <a href="<?= base_url(); ?>Pages/district_userlist_by_division/<?= $row->id; ?>" class="badge badge-success rounded-circle"><?= ($cd->num_rows() > 0) ? $cd->num_rows() : ''; ?></a>
                                                    </a>
                                                </h6>
                                            </div>

                                            <div id="collapse<?= $i; ?>"
                                                class="collapse <?= ($i == 1) ? 'show' : ''; ?>"
                                                aria-labelledby="heading<?= $i; ?>"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="table-responsive">
                                                            <table class="table table-sm mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>School ID</th>
                                                                        <th>School Name</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        $ivy=1; foreach($school as $row){
                                                                        $user_check = $this->Common->one_cond_count_row('users','username',$row->schoolID);
                                                                    ?>
                                                                    <tr>
                                                                        <th scope="row"><?= $ivy++; ?></th>
                                                                        <td><?= $row->schoolID; ?></td>
                                                                        <td><?= strtoupper($row->schoolName); ?></td>
                                                                        <td>
                                                                            <?php if($user_check->num_rows() == 0){?>
                                                                                <a onclick="return confirm('Are you sure?');" href="<?= base_url(); ?>Pages/add_school_user/<?= $row->schoolID; ?>/<?= rawurlencode($row->schoolName); ?>/<?= $row->district_id; ?>/<?= $row->division_id; ?>" class="text-success"><i class="fab fa-mailchimp"></i> Add User</a> &nbsp; &nbsp;
                                                                            <?php } ?>

                                                                            <?php if($user_check->num_rows() != 0){?>
                                                                                <a href="#" class="text-purple open-AddBookDialog" data-toggle="modal" data-target="#ivykate" data-id="<?= $row->schoolID; ?>"><i class="fas fa-lock "></i> Change Password</a> &nbsp; &nbsp;
                                                                            <?php } ?>

                                                                            <a href="<?=base_url(); ?>school/<?= $row->schoolID; ?>" class="text-success"><i class="mdi mdi-file-document-box-check-outline"></i>View</a> &nbsp; &nbsp;
                                                                            <a href="<?=base_url(); ?>Pages/school_update/<?= $row->recID; ?>" class="text-warning"><i class="mdi mdi-pencil-outline"></i>edit</a> &nbsp; &nbsp;
                                                                            <a onclick="return confirm('Are you sure?')" href="<?=base_url(); ?>Pages/school_delete/<?= $row->schoolID; ?>" class="text-danger"><i class="fas fa-trash-alt"></i>Delete</a> &nbsp; &nbsp;
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                         

                        <div id="ivykate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-purple">
                                                        <h5 class="modal-title text-white" id="myModalLabel">Change Password</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= base_url('Pages/change_password_user_division') ?>" method="post">
                                                            
                                                            <input type="hidden" id="id" name="school_id">
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
                                                                class="btn btn-purple waves-effect waves-light">
                                                            Save
                                                        </button>
                                                    </div>

                                                    </form>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->

                        


                        