                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                        <a href="<?= base_url(); ?>Pages/action_plan_new" class="btn btn-success">Add New</a>

                                        <a target="_blank" href="<?= base_url(); ?>Pages/sbm_action_plan_pview" class="btn btn-primary"><i class="fas fa-print"></i> Print View</a>
                                
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
                                                    <th>Activity</th>
                                                    <th>Objectives</th>	
                                                    <th>Expected Outputs</th>	
                                                    <th>Methodology Strategy</th>	
                                                    <th>Time Frame</th>	
                                                    <th>Person Involved</th>	
                                                    <th>Budgetary Requirement</th>	
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($data as $row){?>
                                                <tr>
                                                    <td><?= $row->activity; ?></td>
                                                    <td><?= $row->objective; ?></td>
                                                    <td><?= $row->ex_output; ?></td>
                                                    <td><?= $row->metho_strategy; ?></td>
                                                    <td><?= $row->time_frame; ?></td>
                                                    <td><?= $row->person_involved; ?></td>
                                                    <td><?= $row->bud_req; ?></td>
                                                    <td><?= $row->remarks; ?></td>
                                                    <th>
                                                        <a href="<?= base_url(); ?>Pages/sbm_action_plan_update/<?= $row->id; ?>" class="btn btn-sm btn-warning">Update</a>
                                                        <a href="<?= base_url(); ?>Pages/action_plan_delete/<?= $row->id; ?>" class="btn btn-sm btn-danger">Delete</a>
                                                    </th>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

