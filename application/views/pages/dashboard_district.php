                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title"><?= $this->session->user; ?> <?= $title; ?></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <li class="breadcrumb-item"><a href="#" data-toggle="modal" data-target="#myModal">Current Fiscal Year : <span class="badge badge-success"><?= $this->session->fy; ?></span></a></li>
                                        </ol>
                                    </div><br />
                                    <img class="img-fluid logo" src="<?= base_url(); ?>assets/images/renren.jpeg" alt="renrenguapo" width="100%">
                                    
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <?php 
                                $sgc1 = $this->Page_model->sgc_count_district(1); 
                                $sgc2 = $this->Page_model->sgc_count_district(2); 
                                $sgc3 = $this->Page_model->sgc_count_district(3); 
                                $total = $sgc1 + $sgc2 + $sgc3;

                                $sgc1_percent = ($total > 0) ? ($sgc1 / $total) * 100 : 0;
                                $sgc2_percent = ($total > 0) ? ($sgc2 / $total) * 100 : 0;
                                $sgc3_percent = ($total > 0) ? ($sgc3 / $total) * 100 : 0;

                            ?>

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-header py-3 bg-transparent">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h5 class="header-title mb-2"> School Governance Council (SGC)</h5>
                                    </div>
                                    <div id="cardCollpase2" class="collapse show">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="pl-xl-4">
                                                        <p class="mb-1">Not Yet Organized - <span class="text-purple"><?= number_format($sgc1_percent, 2); ?>%</span></p>
                                                        <div class="progress mb-5" style="height: 7px;">
                                                            <div class="progress-bar bg-purple progress-animated wow animated" role="progressbar" aria-valuenow="<?= number_format($sgc1_percent); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= number_format($sgc1_percent); ?>%">
                                                            </div>
                                                            <!-- /.progress-bar .progress-bar-danger -->
                                                        </div>
                                                        <!-- /.progress .no-rounded -->
                                                        <p class="mb-1">Organized but not Functional - <span class="text-warning"><?=number_format($sgc2_percent, 2); ?>%</span></p>
                                                        <div class="progress mb-5" style="height: 7px;">
                                                            <div class="progress-bar bg-warning progress-animated wow animated" role="progressbar" aria-valuenow="<?= number_format($sgc2_percent); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= number_format($sgc2_percent); ?>%">
                                                            </div>
                                                            <!-- /.progress-bar .progress-bar-warning -->
                                                        </div>
                                                        <!-- /.progress .no-rounded -->
                                                        <p class="mb-1">Functional - <span class="text-success"><?= number_format($sgc3_percent, 2); ?>%</span></p>
                                                        <div class="progress mb-5" style="height: 7px;">
                                                            <div class="progress-bar bg-success progress-animated wow animated" role="progressbar" aria-valuenow="<?= number_format($sgc3_percent); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= number_format($sgc3_percent); ?>%">
                                                            </div>
                                                            <!-- /.progress-bar .progress-bar-success -->
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-->

                            </div>
                            <!-- end col -->

                        </div>
                        <!-- End row -->

                        

                         
                       

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    
                                    <div class="card-body table-responsive">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="page-title-box">
                                                    <h4 class="page-title">Self-Assessment Checklist</h4>
                                                
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
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
                                                                                <tr>
                                                                                    <th rowspan="2" colspan="2"><h4 class="header-title mb-4">SBM Indicator</h4></th>
                                                                                    <th colspan="4" class="text-center">Degree of Manifestation<br /><cite title="Source Title">(Please tick the box that best describes your school)</cite></th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th class="text-center">Not Yet Manifested</th>
                                                                                    <th class="text-center">Rarely Manifested</th>
                                                                                    <th class="text-center">Frequently Manifested</th>
                                                                                    <th class="text-center">Always Manifested</th>
                                                                                </tr>
                                                                            </thead>
                                                                            
                                                                            <tbody>
                                                                                <?php 
                                                                                    $questions = $this->Common->one_cond('sbm_sub_indicator', 'priciple_id', $row->id);
                                                                                    $fy       = $this->session->fy;
                                                                                    $district = $this->session->district;
                                                                                    $base     = base_url();
                                                                                    $badges   = [1 => 'primary', 2 => 'purple', 3 => 'info', 4 => 'warning'];
                                                                                    $c = 0;

                                                                                    foreach ($questions as $sub_row):
                                                                                        $ren = 'q' . $sub_row->i_no;
                                                                                    ?>
                                                                                    <tr <?= (++$c % 2 ? '' : "class='table-active'"); ?>>
                                                                                        <td><?= $sub_row->i_no; ?></td>
                                                                                        <td><?= $sub_row->description; ?></td>

                                                                                        <?php foreach ($badges as $rate => $badge): 
                                                                                            $count = $this->Common->three_cond_count_row(
                                                                                                'sbm', $ren, $rate, 'fy', $fy, 'district', $district
                                                                                            )->num_rows();
                                                                                            $href = $base . "Pages/sbm_rate_list/{$ren}/{$rate}";
                                                                                        ?>
                                                                                            <td class="text-center">
                                                                                                <a href="<?= $href; ?>">
                                                                                                    <span class="badge badge-<?= $badge; ?>"><?= $count; ?></span>
                                                                                                </a>
                                                                                            </td>
                                                                                        <?php endforeach; ?>
                                                                                    </tr>
                                                                                    <?php endforeach; ?>
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    


                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    
                                   
                                    </div>


                                    
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                     </div>
                        <!-- End row -->
                    

                        <!-- sample modal content -->
                                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success">
                                                        <h5 class="modal-title text-white" id="myModalLabel">Change Fiscal Year</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action="<?= base_url('Pages/change_fy') ?>" method="post">
                                                        <div class="form-group row">
                                                            <div class="col-lg-12">
                                                                <select name="new_fy" class="form-control" onchange="this.form.submit()">
                                                                <option disabled selected>Change FY</option>
                                                                <?php for ($y = 2023; $y <= 2030; $y++) : ?>
                                                                    <option value="<?= $y ?>" <?= ($this->session->userdata('fy') == $y) ? 'selected' : '' ?>>
                                                                        <?= $y ?>
                                                                    </option>
                                                                <?php endfor; ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                    

                    
                
