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
                                    <h2 class="text-center"><?= $title; ?></h2>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                         <?php 
                            $ts = $this->Common->two_cond_order_by('tana_summary','school_id', $this->session->username,'fy',$this->session->fy,'sequence','ASC');
                            $ta = $this->Common->two_cond_row('sbm_ta','school_id', $this->session->username,'fy',$this->session->fy);
                         ?>

                        

                        

                        

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
                        <?php if(empty($ts)){?>
                            <?= form_open('Pages/tana_summary', $att); ?>
                        <?php }else{ ?>
                            <?= form_open('Pages/tana_summary_update', $att); ?>
                        <?php } ?>

                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="district" value="<?= $this->session->district; ?>">


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
                                                                                    <th>Average</th>
                                                                                    <th>Priority</th>
                                                                                </tr>
                                                                            </thead>
                                                                            
                                                                            <tbody>
                                                                                <?php
                                                                                    $ic = 1;

                                                                                    if(empty($ts)){

                                                                                    foreach ($averages as $index => $avg):
                                                                                        $col = 'q' . $index;

                                                                                        $text = ($ta && isset($ta->$col) && $ta->$col !== null) ? $ta->$col : '';

                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="hidden" value="<?= $index; ?>" name="concern_id[]" /> 
                                                                                            <input type="hidden" value="<?= number_format((float)$avg, 2); ?>" name="average[]" /> 
                                                                                            <?= $ic++; ?></td>
                                                                                        <td><?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); ?></td>
                                                                                        <td><?= number_format((float)$avg, 2); ?></td>
                                                                                        <td>
                                                                                            <select class="form-control seq-select" name="sequence[]">
                                                                                                <option value="0"></option>
                                                                                                <?php for($i = 1; $i <= 20; $i++): ?>
                                                                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                                                                <?php endfor; ?>
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php endforeach; ?>

                                                                                    <?php }else{ ?>
                                                                                        <?php 
                                                                                            foreach($ts as $row){
                                                                                            $col = 'q' . $row->concern_id;
                                                                                            $text = ($ta && isset($ta->$col) && $ta->$col !== null) ? $ta->$col : '';
                                                                                            
                                                                                            ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <input type="hidden" value="<?= $row->concern_id; ?>" name="concern_id[]" /> 
                                                                                                <input type="hidden" value="<?= $row->average; ?>" name="average[]" /> 
                                                                                                <?= $ic++; ?></td>
                                                                                            <td><?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); ?></td>
                                                                                            <td><?= $row->average; ?></td>
                                                                                            <td>
                                                                                                <select class="form-control" name="sequence[]">
                                                                                                    <?php for($i = 1; $i <= 20; $i++): ?>
                                                                                                        <option <?php if($row->stat != 0){echo ' disabled ';} ?> <?php if($i ==  $row->sequence){echo ' selected ';}?> value="<?= $i ?>"><?= $i ?></option>
                                                                                                    <?php endfor; ?>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } } ?>
                                                                                
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <br />


                                                <div class="form-group text-left mb-0">
                                                <?php $check = $this->Common->two_cond_count_row('tana_summary','school_id',$this->session->username,'stat',1); if($check->num_rows() == 0){?>
                                                <input type="submit" name="submit" value="Save" class="btn btn-primary waves-effect waves-light mr-1">
                                                <a href="<?= base_url(); ?>Pages/update_tana_summary" onclick="return confirm('Are you sure? If you press OK, everything currently saved will be deleted.');" class="btn btn-purple waves-effect waves-light mr-1">Update</a>
                                                <a href="<?= base_url(); ?>Pages/final_tana_summary" onclick="return confirm('Are you sure? If you press OK, you will not be able to update afterward.');" class="btn btn-info waves-effect waves-light mr-1">Final</a>
                                                <?php } ?>
                                               
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


                    <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const selects = document.querySelectorAll('.seq-select');

                        function updateDisabledOptions() {
                            let selected = Array.from(selects)
                                .map(sel => sel.value)
                                .filter(v => v !== "0" && v !== "");

                            selects.forEach(sel => {
                                for (let opt of sel.options) {
                                    if (opt.value !== "0") {
                                        opt.disabled = false;
                                    }
                                }
                            });
                            selects.forEach(sel => {
                                for (let opt of sel.options) {
                                    if (selected.includes(opt.value) && sel.value !== opt.value) {
                                        opt.disabled = true;
                                    }
                                }
                            });
                        }
                        selects.forEach(sel => {
                            sel.addEventListener("change", updateDisabledOptions);
                        });
                    });
                    </script>