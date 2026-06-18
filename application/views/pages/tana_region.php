                        <style>
                            select option:disabled {
                                background-color: #ffcccc;
                                color: #555;
                                font-weight: bold;
                            }
                        </style>

<!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <a class="btn btn-success text-white" data-toggle="modal" data-target=".renren">Add Thematic Analysis</a>
                                    <h2 class="text-center"><?= $title; ?></h2>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                     

                        

                        

                        

                        <?php if ($this->session->flashdata('success')) : ?>

                            <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>'
                                . $this->session->flashdata('success') .
                                '</div>';
                            ?>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('danger')) : ?>
                            <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>'
                                . $this->session->flashdata('danger') .
                                '</div>';
                            ?>
                        <?php endif;  ?>



                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        
                                    <div class="table-responsive">
                                                                        <table class="table table-bordered mb-0">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th>#</th>
                                                                                    <th>Concerns, Issues, Gaps, Problems and Bottlenecks (CIGPB s) Encountered</th>
                                                                                    <!-- <th>Average</th>
                                                                                    <th>Priority</th> -->
                                                                                </tr>
                                                                            </thead>
                                                                            
                                                                            <tbody>
                                                                              <?php $ic=1; foreach($data as $row){
                                                                                $text = $row->tana;
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?= $ic++; ?></td>
                                                                                    <td><?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); ?></td>
                                                                                    <!-- <td><?= $row->average; ?></td>
                                                                                    <td><?= $row->sequence; ?></td> -->
                                                                                </tr>
                                                                                <?php } ?>
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <br />


                                               
                                            </div>

                                    </div>
                                </div>
                            </div>
                        
                        <?php if(!empty($ivy)){?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <h2 class="text-center">Thematic Analysis</h2>
                                        
                                    <div class="table-responsive">
                                                                        <table class="table table-bordered mb-0">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th>#</th>
                                                                                    <th>Concerns, Issues, Gaps, Problems and Bottlenecks (CIGPB s) Encountered</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            
                                                                            <tbody>
                                                                              <?php  foreach($ivy as $row){
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?= $row->sequence; ?></td>
                                                                                    <td><?= htmlspecialchars($row->tana, ENT_QUOTES, 'UTF-8'); ?></td>
                                                                                    <td>
                                                                                        <a onclick="return confirm('Are You Sure?')" href="<?= base_url(); ?>Pages/tana_region_delete/<?= $row->id; ?>" class="btn btn-danger btn-sm">Delete</a>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php } ?>
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <br />


                                               
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                         <?php } ?>

                        </div>
                        <!-- end row -->

                    </div>
                    <!-- end container-fluid -->
                     

                </div>
                <!-- end content -->

                <div class="modal fade renren" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabelcenter" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabelcenter">Add Thematic Analysis</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php $att = array('class' => 'parsley-examples'); ?>
                                                        <?= form_open('Pages/tana_region', $att); ?>

                                                        <div class="form-group row">
                                                            <div class="col-lg-12">
                                                                <label class="form-label">Thematic Analysis</label>
                                                                <textarea class="form-control" rows="5" name="tana" id="example-textarea"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-lg-12">
                                                                <label class="form-label">Sequence</label>
                                                                <select class="form-control" name="sequence" required>
                                                                    <option value="0"></option>
                                                                    <?php for($i = 1; $i <= 20; $i++): ?>
                                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                                    <?php endfor; ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                                                    </div>                                                  

