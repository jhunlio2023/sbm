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
                                                    <th>Division Name </th>
                                                    <th class="text-center">Action Plan</th>
                                                    <th class="text-center">Self-Assessment</th>
                                                    <th class="text-center">TA Form</th>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $c = 1; 
                                                    foreach ($data as $row) {
                                                        $tables = [
                                                            'sgod_action_plan' => 'success',
                                                            'sbm'              => 'info',
                                                            'sbm_ta'           => 'primary'
                                                        ];
                                                    ?>
                                                    <tr>
                                                        <td><?= $c++; ?></td>
                                                        <td><?= $row->description; ?></td>
                                                        <?php foreach ($tables as $table => $badge): ?>
                                                            <?php $count = $this->Common->two_cond_count_row_gb($table,'division', $row->id,'fy',$this->session->fy, 'school_id')->num_rows(); ?>
                                                            <td class="text-center"><a href="<?= base_url(); ?>/Pages/district_list_division/<?= $row->id; ?>"><span class="badge badge-<?= $badge; ?>"><?= $count; ?></span></a></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                    <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        
                        