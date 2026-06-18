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
                                        <h4 class="header-title mb-4">Edit School Info</h4>

                                        <?php $att = array('class' => 'parsley-examples'); ?>
                                        <?= form_open('Pages/school_update', $att); ?>
                                        

                                            <div class="form-row">
                                            <input type="hidden" class="form-control" name="recID" value="<?= $data->recID; ?>">
                                            <input type="hidden" class="form-control" name="schoolID" value="<?= $data->schoolID; ?>">
                                                
                                                <div class="form-group col-md-6">
                                                    <label for="inputAddress" class="col-form-label" name="q1">School Name</label>
                                                    <input type="text" class="form-control" name="schoolName" value="<?= $data->schoolName; ?>">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="inputAddress" class="col-form-label">Division</label>
                                                    <select name="division_id" id="division" class="form-control">
                                                        <option value="">Select Division</option>
                                                            <?php foreach($division as $row){ ?>
                                                                <option value="<?= $row->id; ?>" <?php if($data->division_id == $row->id){ echo "selected"; } ?>><?= $row->description; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="inputAddress" class="col-form-label">District/Cluster</label>
                                                    <select name="d_id" id="district" class="form-control">
                                                        <option value="">Select District/Cluster</option>
                                                        <?php if(isset($districts)): ?>
                                                            <?php foreach($districts as $row){ ?>
                                                                <option value="<?= $row->id; ?>" <?php if($data->district_id == $row->id){ echo "selected"; } ?>><?= $row->description; ?></option>
                                                            <?php } ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>

                                                    
                                                

                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">School Head</label>
                                                    <input type="text" class="form-control" name="adminFName" value="<?= $data->adminFName; ?>" placeholder="First Name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">_</label>
                                                    <input type="text" class="form-control" name="adminMName" value="<?= $data->adminMName; ?>" placeholder="Middle Name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">_</label>
                                                    <input type="text" class="form-control" name="adminLName" value="<?= $data->adminLName; ?>" placeholder="Last Name">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="inputPassword4" class="col-form-label">School Head Designation</label>
                                                    <input type="text" class="form-control" name="adminDesignation" value="<?= $data->adminDesignation; ?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="inputEmail4" class="col-form-label">School Head E-mail</label>
                                                    <input type="text" class="form-control" name="adminEmail" value="<?= $data->adminEmail; ?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="inputEmail4" class="col-form-label">School E-mail</label>
                                                    <input type="text" class="form-control" name="schoolEmail" value="<?= $data->schoolEmail; ?>">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="inputPassword4" class="col-form-label">Contact Number/s</label>
                                                    <input type="text" class="form-control" name="adminMobile" value="<?= $data->adminMobile; ?>">
                                                </div>

                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="inputPassword4" class="col-form-label">Province</label>
                                                    <input type="text" class="form-control" name="province" value="<?= $data->province; ?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="inputEmail4" class="col-form-label">City/Municipality</label>
                                                    <input type="text" class="form-control" name="city" value="<?= $data->city; ?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="inputEmail4" class="col-form-label">Barangay</label>
                                                    <input type="text" class="form-control" name="brgy" value="<?= $data->brgy; ?>">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="inputPassword4" class="col-form-label">Sitio</label>
                                                    <input type="text" class="form-control" name="sitio" value="<?= $data->sitio; ?>">
                                                </div>
                                            </div>



                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="schoolName">School Governance Council (SGC)</label>
                                                    <select name="sgc" id="sgc" required class="form-control">
                                                            <option disabled selected>Select</option>
                                                                <option <?php if($data->sgc == 1){echo " selected "; }?> value="1">Not Yet Organized</option>
                                                                <option <?php if($data->sgc == 2){echo " selected "; }?> value="2">Organized but not Functional</option>
                                                                <option <?php if($data->sgc == 3){echo " selected "; }?> value="3">Functional</option>
                                                        </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                                <label name="">Categories</label>
                                                                <select class="form-control" required name='category'>
                                                                    <option disabled selected>Choose Offers</option>
                                                                    <?php $schoo_type = array('Elementary'=>1,'Integrated(Elem & JHS)'=>2,'Integrated(Elem, JHS, & SHS)'=>3,'Secondary(JHS only)'=>4,'Secondary(JHS & SHS)'=>5,'SHS - Stand Alone'=>6);

                                                                    foreach($schoo_type as $key => $row){
                                                                    ?>
                                                                    <option <?php if($data->category == $row){echo " selected "; }?> value="<?= $row; ?>"><?= $key; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="schoolName">Offerings</label>
                                                    <select name="schoolType" id="school_type" class="form-control">
                                                            <option disabled selected>Select Offerings</option>
                                                                <option <?php if($data->schoolType == 1){echo " selected "; }?> value="1">None</option>
                                                                <option <?php if($data->schoolType == 2){echo " selected "; }?> value="2">School-Based ALS Program</option>
                                                                <option <?php if($data->schoolType == 3){echo " selected "; }?> value="3">TLE-TVL Course Offerings </option>
                                                                <option <?php if($data->schoolType == 4){echo " selected "; }?> value="4">School-Based ALS Program and TLE-TVL Course Offerings </option>
                                                        </select>
                                                </div>
                                            </div>

                                         

                                            <input type="submit" name="submit" value="Update" class="btn btn-primary">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
        $(document).ready(function(){
            $('#division').on('change', function(){
                var divisionID = $(this).val();
                $('#district').html('<option value="">Loading...</option>');
                if(divisionID != ''){
                    $.ajax({
                        url: '<?= base_url("Pages/get_district_by_division"); ?>',
                        method: 'POST',
                        data: {division_id: divisionID},
                        dataType: 'json',
                        success: function(response){
                            $('#district').html('<option value="">Select District</option>');
                            $.each(response, function(index, item){
                                $('#district').append('<option value="'+item.id+'">'+item.description+'</option>');
                            });
                        }
                    });
                } else {
                    $('#district').html('<option value="">Select District</option>');
                }
            });
        });
        </script>

        <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.getElementById("toggleIcon");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        </script>

                        
                        