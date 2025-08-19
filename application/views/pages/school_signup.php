<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>SBM - School-Based Management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

    </head>

    <body class="authentication-page">

        <div class="account-pages my-12">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-10">
                        <div class="card mt-4">
                            <div class="card-header p-4" style="background:#a00000">
                                <h4 class="text-white text-center mb-0 mt-0"><img src="<?= base_url(); ?>assets/images/candor.png" width="10%" alt=""><br />FTAD OneView</h4>
                            </div>
                            <div class="card-body">
                            <?php if($this->session->flashdata('failed')) : ?>

                            <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>'
                                    .$this->session->flashdata('failed'). 
                                '</div>'; 
                            ?>
                            <?php endif; ?> 
                            <?php if($this->session->flashdata('success')) : ?>

                                <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>'
                                        .$this->session->flashdata('success'). 
                                    '</div>'; 
                                ?>
                                <?php endif; ?> 
                                
                            <?= validation_errors(); ?>
                                <?= form_open('Pages/signup') ?>

                                <div class="form-row">
                                    
                                    <div class="form-group col-md-6">
                                        <label for="schoolID">School ID</label>
                                        <input class="form-control" type="text" id="schoolID" required="" name="schoolID" placeholder="School ID">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="schoolID">Password</label>
                                        <input class="form-control" type="password" id="password" required="" name="password" placeholder="Your Password">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="schoolName">School Name</label>
                                        <input class="form-control" type="text" id="schoolName" required="" name="schoolName" placeholder="Your Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="schoolName">School Email</label>
                                        <input class="form-control" type="email" id="schoolEmail" name="schoolEmail" required="" placeholder="Your Name">
                                    </div>
                                    
                                </div>

                                

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="schoolName">Division</label>
                                        <select name="division_id" id="division" class="form-control">
                                                <option value="">Select Division</option>
                                                    <?php foreach($division as $row){ ?>
                                                        <option value="<?= $row->id; ?>"><?= $row->description; ?></option>
                                                <?php } ?>
                                            </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="schoolID">District</label>
                                        <select name="d_id" id="district" class="form-control">
                                                <option value="">Select District</option>
                                            </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="schoolName">School Governance Council (SGC)</label>
                                        <select name="sgc" id="sgc" required class="form-control">
                                                <option disabled selected>Select SGC</option>
                                                    <option value="1">Not yet Organized</option>
                                                    <option value="2">Organized only</option>
                                                    <option value="3">Organized but not Functional</option>
                                                    <option value="4">Functional</option>
                                            </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                                    <label name="">Categories</label>
                                                    <select class="form-control" required name='course'>
                                                        <option disabled selected>Choose Offers</option>
                                                        <?php $schoo_type = array(1=>'Elementary',2=>'Integrated(Elem & JHS)',3=>'Integrated(Elem, JHS, & SHS)',4=>'Secondary(JHS only)',5=>'Secondary(JHS & SHS)',6=>'SHS - Stand Alone');

                                                        foreach($schoo_type as $key => $row){
                                                        ?>
                                                        <option value="<?= $key; ?>"><?= $row; ?></option>
                                                        <?php } ?>
                                                    </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="schoolName">Type</label>
                                        <select name="type" id="school_type" class="form-control">
                                                <option disabled selected>Select Type</option>
                                                    <option value="0"></option>
                                                    <option value="1">School-based ALS program</option>
                                                    <option value="2">TLE-TVL course offerings </option>
                                            </select>
                                    </div>
                                </div>

                                    
                                    <input type="hidden" valu="" name="renren">
                                    <input type="hidden" valu="" name="ivykate">
                                    <input type="hidden" valu="" name="ivankyle">
                                    <input type="hidden" valu="" name="ic">
                                    

                                    <div class="form-group mb-4">
                                        <div class="checkbox checkbox-success">
                                            <input id="remember" type="checkbox" checked="" required>
                                            <label for="remember">
                                                I accept <strong><a href="#" data-toggle="modal" data-target="#myModal">Terms and Conditions</a></strong>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="6LedsqorAAAAAMSwAX3ZLaCOyCFv5oVRRwR9AW34"></div>
                                    </div> -->


                                    <div class="form-group text-right mt-4 mb-4">
                                        <div class="col-12">
                                            <button class="btn btn-md waves-effect waves-light" style="background:#a00000" type="submit">Register</button>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-sm-12 text-center">
                                            <a href="<?= base_url(); ?>">Already have account?</a>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <!-- end row -->

                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

            </div>
        </div>

        <!-- sample modal content -->
                                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <h5 class="modal-title text-white" id="myModalLabel">DECLARATION AND ATTESTATION:</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-justify" style="text-indent: 2rem;">Consent & Privacy Notice (Online School-Based Self-Assessment) The Department of Education (DepEd) complies with Republic Act No. 10173 or the Data Privacy Act of 2012 and its Implementing Rules and Regulations. By ticking the checkbox and clicking “Submit,” you freely, specifically, and informedly consent to DepEd’s collection, processing, and storage of your personal information (e.g., name, position/designation, school, contact details, and assessment responses) for lawful and legitimate purposes connected with the implementation, monitoring, and validation of the Revised School-Based Management (SBM) System under DepEd Order No. 007, s. 2024 and the Regional initiative to consolidate results, provide technical assistance, and support continuous improvement at the school level</p>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->

        <!-- Vendor js -->
        <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                 <script>
                    function validateCaptcha(event) {
                        var response = grecaptcha.getResponse();
                        if (response.length == 0) {
                            alert("Please verify that you are not a robot.");
                            event.preventDefault(); // prevent form submission
                            return false;
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

    </body>

</html>