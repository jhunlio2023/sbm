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



                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <h4 class="m-t-0 header-title mb-4"><?= $title; ?></h4>

                                        <table class="table mb-0">
                                            <!-- <table class="table mb-0"> -->
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>School ID</th>
                                                    <th>School Name </th>
                                                    <th class="text-center">Action Plan</th>
                                                    <th class="text-center">Self-Assessment</th>
                                                    <th class="text-center">TA Form</th>
                                            </thead>
                                            <tbody>

                                                <?php $c=1; foreach($data as $row){
                                                    $sbm_submit=$this->Page_model->two_cond_row_select('sbm','school_id,fy','school_id',$row->schoolID,'fy',$this->session->fy);
                                                    $sbm_ta=$this->Page_model->two_cond_row_select('sbm_ta','school_id,fy','school_id',$row->schoolID,'fy',$this->session->fy);
                                                    $sbm_action=$this->Page_model->two_cond_row_select('sgod_action_plan','school_id,fy','school_id',$row->schoolID,'fy',$this->session->fy);
                                                    ?>
                                                <tr>
                                                    <td><?= $c++; ?></td>
                                                    <td><?= $row->schoolID; ?></td>
                                                    <td><?= strtoupper($row->schoolName); ?></td>
                                                    <td class="text-center">
                                                    <?php if(empty($sbm_action)){?>
                                                    <span class="text-danger">&#10008;</span> 
                                                    <?php }else{ ?>
                                                        <a target="_blank" href="<?= base_url(); ?>Pages/sbm_action_plan_pview_district/<?= $row->schoolID; ?>" class="btn btn-success btn-sm">View</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if(empty($sbm_submit)){?>
                                                    <span class="text-danger">&#10008;</span> 
                                                    <?php }else{ ?>
                                                        <a target="_blank" href="<?= base_url(); ?>Pages/checklist_district/<?= $row->schoolID; ?>" class="btn btn-success btn-sm">View</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if(empty($sbm_ta)){?>
                                                    <span class="text-danger">&#10008;</span> 
                                                    <?php }else{ ?>
                                                    
                                                        
                                                        <a target="_blank" href="<?= base_url(); ?>Pages/tapr_form_district/<?= $row->schoolID; ?>" class="btn btn-success btn-sm">View</a>


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


                        
                        