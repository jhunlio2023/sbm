                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">

                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>pages/userlist">Manage User</a></li>
                                            <li class="breadcrumb-item active">Add New User</li>
                                        </ol>
                                    </div>

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
                                            echo form_open_multipart('pages/user_new', $attributes);
                                        ?>
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-md-4 col-form-label">Username <span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input type="text" required parsley-type="username" name="username" class="form-control" id="inputEmail3" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="hori-pass1" class="col-md-4 col-form-label">Password<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input id="myInput" type="password" placeholder="Password" name="password"  required class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="hori-pass2" class="col-md-4 col-form-label">Confirm Password
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input id="myInput2" data-parsley-equalto="#myInput" type="password" name="cpassword" required placeholder="Password" class="form-control" id="hori-pass2">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-8 offset-md-4">
                                                    <div class="checkbox checkbox-purple">
                                                        <input id="checkbox6" type="checkbox" onclick="myFunction()">
                                                        <label for="checkbox6">
                                                            Show Password
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label">First Name<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input type="text" required class="form-control" name="fname" placeholder="First Name" oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label">Middle Name</label>
                                                <div class="col-md-7">
                                                    <input type="text" name="mname" class="form-control" placeholder="Middle Name" oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label">Last Name<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input type="text" required name="lname" class="form-control" placeholder="Last Name" oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label">Position<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <select name="position" class="form-control" required>
                                                        <option value="">Select Position</option>
                                                        <?php foreach ($pos as $row): ?>
                                                            <option value="<?= $row->pos ?>"><?= $row->description ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label">Division<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <select name="division_id" id="division" class="form-control">
                                                        <option value="">Select Division</option>
                                                        <?php foreach($division as $row){ ?>
                                                            <option value="<?= $row->id; ?>"><?= $row->description; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label">District<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <select name="d_id" id="district" class="form-control">
                                                        <option value="">Select District</option>
                                                    </select>
                                                </div>
                                            </div>

                                            

                                            <div class="form-group row">
                                                <div class="col-md-8 offset-md-4">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio1" required name="gender" value="0" class="custom-control-input">
                                                        <label class="custom-control-label  text-xs" for="customRadio1">Male</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio2" required name="gender" value="1" class="custom-control-input">
                                                        <label class="custom-control-label text-xs" for="customRadio2">Female</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label">Profile Picture</label>
                                                <div class="col-md-7">
                                                    <input type="file" name="file" class="form-control" placeholder="Profile Picture">
                                                </div>
                                            </div>


                                            
                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Register
                                                    </button>
                                                    <button type="reset" class="btn btn-secondary waves-effect waves-light">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <script>
                        function myFunction() {
                        var x = document.getElementById("myInput");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                        var x = document.getElementById("myInput2");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                        }
                        </script>

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
                  