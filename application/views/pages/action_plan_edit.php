                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
  

                                <?php if($this->session->flashdata('success')) : ?>

                                    <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>'
                                            .$this->session->flashdata('success'). 
                                        '</div>'; 
                                    ?>
                                    <?php endif; ?>

                                    <?php if($this->session->flashdata('danger')) : ?>
                                    <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>'
                                            .$this->session->flashdata('danger'). 
                                        '</div>'; 
                                    ?>
                                    <?php endif;  ?>

                                    <?= validation_errors(); ?>
                                    
                                   
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                       <!-- ============================================================== -->
                       <!-- Main Content here -->
                       <!-- ============================================================== -->



                       <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4"><?= $title; ?></h4>

                                        <?php 
                                            $attributes = array('class' => 'parsley-examples');
                                            echo form_open_multipart('pages/sbm_action_plan_update', $attributes);
                                        ?>
                                            <div class="row">
                                                <input type="hidden" name="id" value="<?= $data->id; ?>">
                                                                <div class="form-group col-lg-4">
                                                                    <label for="userName">Activity</label>
                                                                    <textarea class="form-control" rows="2" name="activity" id="example-textarea"><?= $data->activity; ?></textarea>
                                                                </div>
                                                                <div class="form-group col-lg-8">
                                                                    <label for="emailAddress">Objectives</label>
                                                                    <textarea class="form-control" rows="2" name="objective" id="example-textarea"><?= $data->objective; ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-lg-4">
                                                                    <label for="userName">Expected Outputs</label>
                                                                    <textarea class="form-control" rows="2" name="ex_output" id="example-textarea"><?= $data->ex_output; ?></textarea>
                                                                </div>
                                                                <div class="form-group col-lg-8">
                                                                    <label for="emailAddress">Methodology Strategy</label>
                                                                    <textarea class="form-control" rows="2" name="metho_strategy" id="example-textarea"><?= $data->metho_strategy; ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group col-lg-4">
                                                                    <label for="userName">Time Frame</label>
                                                                    <input type="text" name="time_frame" parsley-trigger="change"  class="form-control" value="<?= $data->time_frame; ?>">
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <label for="emailAddress">Person Involved</label>
                                                                    <input type="text" name="person_involved" parsley-trigger="change"  class="form-control" value="<?= $data->person_involved; ?>">
                                                                </div>
                                                                <div class="form-group col-lg-4">
                                                                    <label for="userName">Budgetary Requirement</label>
                                                                    <input type="text" name="bud_req" parsley-trigger="change"  class="form-control" value="<?= $data->bud_req; ?>">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                
                                                                <div class="form-group col-lg-12">
                                                                    <label for="emailAddress">Remarks</label>
                                                                    <textarea class="form-control" rows="2" name="remarks" id="example-textarea"><?= $data->remarks; ?></textarea>
                                                                </div>
                                                            </div>


                                                            <div class="form-group text-right mb-0">
                                                                <input type="submit" name="submit" value="Update" class="btn btn-primary waves-effect waves-light mr-1">
                                                            </div>

                                                        </form>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
