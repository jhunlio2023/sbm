

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title" id="myLargeModalLabel">                            
                                        <a href="<?= base_url(); ?>Pages/sbm_district_tech_new" class="btn btn-success">Add New</a>

                                    </h4>
                                    <div class="clearfix"></div>
                                </div>
                                <?php if($this->session->flashdata('success')) : ?>

                                    <?= '<div class="col-12 alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>'
                                            .$this->session->flashdata('success'). 
                                        '</div>'; 
                                    ?>
                                    <?php endif; ?>

                                    <?php if($this->session->flashdata('danger')) : ?>
                                    <?= '<div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>'
                                            .$this->session->flashdata('danger'). 
                                        '</div>'; 
                                    ?>
                                    <?php endif;  ?>
                            </div>
                            
                        </div>
                        <!-- end page title -->


                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4"><?= $title; ?></h4>
                                        <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <thead>
                                                <tr>
                                                    <th>TA Recommendation</th>
                                                    <th>Strategies/Activities</th>
                                                    <th>Concerned: Districts/SDO</th>
                                                    <th>Management Team District/SDO</th>
                                                    <th>Schedule</th>
                                                    <th>Composite Team</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($data as $row){?>
                                                <tr>
                                                    <td><?= $row->ta_rec; ?></td>
                                                    <td><?= $row->sa; ?></td>
                                                    <td><?= $row->cd; ?></td>
                                                    <td><?= $row->mtd; ?></td>
                                                    <td><?= $row->schedule; ?></td>
                                                    <td><?= $row->ct; ?></td>
                                                    <td>
                                                        <a href="<?= base_url(); ?>Pages/sbm_district_tech_edit/<?= $row->id; ?>" class="btn btn-sm btn-warning">Update</a>
                                                        <a href="<?= base_url(); ?>Pages/sbm_district_tech_del/<?= $row->id; ?>" class="btn btn-sm btn-danger">Delete</a>
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
                        <!--- end row -->

                    </div>
                    <!-- end container-fluid -->

                </div>
                <!-- end content -->

          
                



                                        
