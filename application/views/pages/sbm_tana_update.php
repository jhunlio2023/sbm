<!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
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

                        <?php $att = array('class' => 'parsley-examples'); ?>
                        <?= form_open('Pages/tana_form_update', $att); ?>

                        <input type="hidden" name="id" value="<?= $tana->id; ?>">


                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        
                                    <div id="accordion" class="mb-3">

                                        <?php $ivy=1; $ivan=1; foreach($sbm as $row){?>
                                        <div class="card mb-0">
                                            <div class="card-header" id="headingOne">
                                                <h6 class="m-0">
                                                    <a href="#collapse<?= $row->id; ?>" class="text-dark" data-toggle="collapse"
                                                            aria-expanded="true"
                                                            aria-controls="collapse<?= $row->id; ?>">
                                                        <?= $row->indicator; ?>
                                                    </a>
                                                </h6>
                                                
                                            </div>

                                            <div id="collapse<?= $row->id; ?>" class="collapse <?php if($row->id == 1){echo 'show';} ?>" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                                <blockquote class="blockquote border-0">
                                                                <p><?= $row->description; ?></p>
                                                                </blockquote>

                                                                <div class="table-responsive">
                                                                        <table class="table table-borderless mb-0">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th colspan='2'>SBM Indicator</th>
                                                                                    <th>Degree Of Manifestation</th>
                                                                                    <th>Concerns, Issues, Gaps, Problems and Bottlenecks (CIGPB s) Encountered</th>
                                                                                    <th>Strategic Importance </th>
                                                                                    <th>Urgency</th>
                                                                                    <th>Magnitude</th>
                                                                                    <th>Feasibility</th>
                                                                                    <th>Average</th>
                                                                                </tr>
                                                                            </thead>
                                                                            
                                                                            <tbody>
                                                                                <?php 
                                                                                    $dm = array(
                                                                                        '1'=>'Not Yet Manifested',
                                                                                        '2'=>'Rarely Manifested',
                                                                                        '3'=>'Frequently Manifested',
                                                                                        '4'=>'Always Manifested',
                                                                                        '5'=>'<span class="text-danger">No data</span>'
                                                                                    );

                                                                                    $cat = array(
                                                                                        '1'=>'Technical', 
                                                                                        '2'=>'Institutional', 
                                                                                        '3'=>'Financial', 
                                                                                        '4'=>'Political', 
                                                                                        '5'=>'Infrastructure', 
                                                                                        '6'=>'Social', 
                                                                                        '7'=>'Gender'
                                                                                    );

                                                                                    $question = $this->Common->one_cond('sbm_sub_indicator','priciple_id',$row->id);
                                                                                    $name = 'q'; 

                                                                                    $no = 1;
                                                                                    $c = 0;
                                                                                    
                                                                                    foreach($question as $sub_row){
                                                                                        $sbmc = $this->Common->two_cond_row('sbm','school_id',$this->session->username,'fy',$this->session->fy);
                                                                                        $ta = $this->Common->two_cond_row('sbm_ta','school_id',$this->session->username,'fy',$this->session->fy);
                                                                                        $taq = 'q' . $sub_row->i_no;
                                                                                        $aq = 'a' . $sub_row->i_no;
                                                                                        $bq = 'b' . $sub_row->i_no;
                                                                                        $cq = 'c' . $sub_row->i_no;
                                                                                        $dq = 'd' . $sub_row->i_no;

                                                                                        $sbm_col = 'q'.$sub_row->i_no;

                                                                                ?>
                                                                                <tr <?php echo (++$c%2 ? "" : "class='table-active'"); ?>>
                                                                                    <td><?= $sub_row->i_no; ?> </td>
                                                                                    <td><?= $sub_row->description; ?></td>
                                                                                    <td class="text-center">
                                                                                        <?php 
                                                                                            if (!empty($sbmc) && isset($sbmc->$sbm_col)) {
                                                                                                foreach($dm as $key => $row){
                                                                                                    if($key == $sbmc->$sbm_col){
                                                                                                        echo $row;
                                                                                                    }
                                                                                                }
                                                                                            } else {
                                                                                                echo '<span class="text-danger">No data</span>'; 
                                                                                            }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td><textarea class="form-control" name="q<?=$sub_row->i_no; ?>"  rows="2" id="example-textarea" readonly><?= $ta->$taq; ?></textarea></td>
                                                                                    <td>
                                                                                        <select class="form-control" name="a<?=$sub_row->i_no; ?>">
                                                                                            <option value=""></option>
                                                                                            <?php
                                                                                            for ($i = 1; $i <= 5; $i++) {
                                                                                                echo "<option ";
                                                                                                if($i == $tana->$aq){echo " selected ";}
                                                                                                echo " value=\"$i\">$i</option>";
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select class="form-control" name="b<?=$sub_row->i_no; ?>">
                                                                                            <option value=""></option>
                                                                                            <?php
                                                                                            for ($i = 1; $i <= 5; $i++) {
                                                                                                echo "<option ";
                                                                                                if($i == $tana->$bq){echo " selected ";}
                                                                                                echo " value=\"$i\">$i</option>";
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select class="form-control" name="c<?=$sub_row->i_no; ?>">
                                                                                            <option value=""></option>
                                                                                            <?php
                                                                                            for ($i = 1; $i <= 5; $i++) {
                                                                                                echo "<option ";
                                                                                                if($i == $tana->$cq){echo " selected ";}
                                                                                                echo " value=\"$i\">$i</option>";
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select class="form-control" name="d<?=$sub_row->i_no; ?>">
                                                                                            <option value=""></option>
                                                                                            <?php
                                                                                            for ($i = 1; $i <= 5; $i++) {
                                                                                                echo "<option ";
                                                                                                if($i == $tana->$dq){echo " selected ";}
                                                                                                echo " value=\"$i\">$i</option>";
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td><?= (($tana->$aq + $tana->$bq + $tana->$cq + $tana->$dq) / 4) ?: '' ?></td>
                                                                                </tr>
                                                                                <?php } ?>
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    


                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?> 
                                    
                                   
                                    </div>


                                    <div class="form-group text-left mb-0">
                                               <input type="submit" name="submit" value="Save Draft" class="btn btn-primary waves-effect waves-light mr-1">
                                               <a href="<?= base_url(); ?>Pages/tana_summary" class="btn btn-success waves-effect waves-light mr-1">TANA Summary</a>
                                                
                                               
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                                                                                    </form>

                    </div>
                    <!-- end container-fluid -->

                </div>
                <!-- end content -->