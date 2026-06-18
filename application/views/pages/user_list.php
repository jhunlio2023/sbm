                        <?php if (!empty($division_scope)) { ?>
                        <style>
                            .division-users-page {
                                --du-primary: #8b1e3f;
                                --du-primary-dark: #64142d;
                                --du-surface: #ffffff;
                                --du-muted: #6b7280;
                                --du-border: #e8ecf4;
                            }

                            .division-users-hero {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                gap: 20px;
                                margin: 18px 0 22px;
                                padding: 26px 28px;
                                border-radius: 18px;
                                color: #fff;
                                background: linear-gradient(135deg, #64142d 0%, #a83255 100%);
                                box-shadow: 0 14px 34px rgba(139, 30, 63, .22);
                            }

                            .division-users-hero h2 {
                                margin: 0 0 6px;
                                color: #fff;
                                font-size: 25px;
                                font-weight: 700;
                            }

                            .division-users-hero p {
                                margin: 0;
                                color: rgba(255, 255, 255, .82);
                            }

                            .division-users-hero .btn-add-user {
                                flex: 0 0 auto;
                                padding: 11px 18px;
                                border: 0;
                                border-radius: 10px;
                                color: var(--du-primary-dark);
                                background: #fff;
                                font-weight: 600;
                                box-shadow: 0 7px 18px rgba(22, 36, 88, .18);
                            }

                            .division-users-card {
                                border: 1px solid var(--du-border);
                                border-radius: 16px;
                                box-shadow: 0 8px 28px rgba(31, 45, 75, .07);
                                overflow: hidden;
                            }

                            .division-users-card .card-body {
                                padding: 0;
                            }

                            .division-users-toolbar {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                gap: 14px;
                                padding: 20px 24px;
                                border-bottom: 1px solid var(--du-border);
                            }

                            .division-users-toolbar h4 {
                                margin: 0;
                                font-size: 17px;
                                font-weight: 700;
                            }

                            .division-users-count {
                                display: inline-flex;
                                align-items: center;
                                gap: 7px;
                                padding: 7px 11px;
                                border-radius: 999px;
                                color: var(--du-primary-dark);
                                background: #f9e9ee;
                                font-size: 12px;
                                font-weight: 700;
                            }

                            .division-users-table-wrap {
                                padding: 8px 24px 22px;
                            }

                            .division-users-page .dataTables_wrapper .row:first-child {
                                align-items: center;
                                padding: 12px 0 6px;
                            }

                            .division-users-page .dataTables_filter input,
                            .division-users-page .dataTables_length select {
                                min-height: 38px;
                                border: 1px solid #dce2ee;
                                border-radius: 9px;
                                box-shadow: none;
                            }

                            .division-users-page table.dataTable {
                                margin-top: 12px !important;
                                border-collapse: separate !important;
                                border-spacing: 0 8px !important;
                            }

                            .division-users-page table.dataTable thead th {
                                padding: 11px 14px;
                                border: 0;
                                color: #687086;
                                background: transparent;
                                font-size: 11px;
                                font-weight: 700;
                                letter-spacing: .06em;
                                text-transform: uppercase;
                            }

                            .division-users-page table.dataTable tbody td {
                                padding: 14px;
                                border-top: 1px solid var(--du-border);
                                border-bottom: 1px solid var(--du-border);
                                vertical-align: middle;
                                background: #fff;
                            }

                            .division-users-page table.dataTable tbody td:first-child {
                                border-left: 1px solid var(--du-border);
                                border-radius: 11px 0 0 11px;
                            }

                            .division-users-page table.dataTable tbody td:last-child {
                                border-right: 1px solid var(--du-border);
                                border-radius: 0 11px 11px 0;
                            }

                            .division-users-page table.dataTable tbody tr:hover td {
                                background: #fff7f9;
                            }

                            .account-cell {
                                display: flex;
                                align-items: center;
                                gap: 12px;
                                min-width: 190px;
                            }

                            .account-avatar {
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                width: 40px;
                                height: 40px;
                                flex: 0 0 40px;
                                border-radius: 12px;
                                color: #fff;
                                background: linear-gradient(135deg, #8b1e3f, #c65a77);
                                font-size: 14px;
                                font-weight: 700;
                            }

                            .account-name {
                                color: #27324a;
                                font-weight: 600;
                            }

                            .username-text {
                                color: #596277;
                                font-family: Consolas, Monaco, monospace;
                                font-size: 13px;
                            }

                            .account-level {
                                display: inline-flex;
                                padding: 6px 10px;
                                border-radius: 999px;
                                color: #8b1e3f;
                                background: #f9e9ee;
                                font-size: 11px;
                                font-weight: 700;
                                text-transform: capitalize;
                            }

                            .user-actions {
                                display: flex;
                                flex-wrap: wrap;
                                gap: 7px;
                            }

                            .user-actions form {
                                margin: 0;
                            }

                            .user-actions .btn {
                                display: inline-flex;
                                align-items: center;
                                gap: 5px;
                                min-height: 34px;
                                padding: 7px 10px;
                                border-radius: 8px;
                                font-size: 12px;
                                font-weight: 600;
                            }

                            .division-users-page .alert {
                                border: 0;
                                border-radius: 12px;
                                box-shadow: 0 6px 18px rgba(31, 45, 75, .07);
                            }

                            @media (max-width: 767.98px) {
                                .division-users-hero {
                                    align-items: stretch;
                                    flex-direction: column;
                                    padding: 22px;
                                    border-radius: 14px;
                                }

                                .division-users-hero .btn-add-user {
                                    width: 100%;
                                    text-align: center;
                                }

                                .division-users-toolbar {
                                    align-items: flex-start;
                                    flex-direction: column;
                                    padding: 18px;
                                }

                                .division-users-table-wrap {
                                    padding: 6px 14px 18px;
                                }

                                .division-users-page .dataTables_wrapper .row:first-child > div {
                                    width: 100%;
                                    max-width: 100%;
                                    flex: 0 0 100%;
                                }

                                .division-users-page .dataTables_filter,
                                .division-users-page .dataTables_length {
                                    text-align: left;
                                }

                                .division-users-page .dataTables_filter input {
                                    width: calc(100% - 58px);
                                    margin-left: 6px;
                                }

                                .division-users-page .dataTables_info,
                                .division-users-page .dataTables_paginate {
                                    text-align: center !important;
                                    white-space: normal;
                                }

                                .user-actions .btn {
                                    justify-content: center;
                                }
                            }
                        </style>
                        <?php } ?>

                        <div class="<?= !empty($division_scope) ? 'division-users-page' : ''; ?>">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <?php if (!empty($division_scope)) { ?>
                                <div class="division-users-hero">
                                    <div>
                                        <h2><i class="mdi mdi-account-group-outline mr-2"></i>Manage Users</h2>
                                        <p>Create and maintain accounts assigned to your division.</p>
                                    </div>
                                    <a class="btn btn-add-user" href="<?= base_url(); ?>pages/user_new">
                                        <i class="mdi mdi-account-plus-outline mr-1"></i> Add User
                                    </a>
                                </div>
                                <?php } else { ?>
                                <div class="page-title-box">
                                    <?php if(in_array($this->session->position, array('admin', 'division', 'ict'), true)){ ?>
                                    <a class="btn btn-success" href="<?= base_url(); ?>pages/user_new">Add New</a>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </div>
                                <?php } ?>

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
                            </div>
                        </div>
                        <!-- end page title -->


                       <!-- ============================================================== -->
                       <!-- Main Content here -->
                       <!-- ============================================================== -->



                        <div class="row">
                            <div class="col-12">
                                <div class="card <?= !empty($division_scope) ? 'division-users-card' : ''; ?>">
                                    <div class="card-body">
                                        <?php if (!empty($division_scope)) { ?>
                                        <div class="division-users-toolbar">
                                            <div>
                                                <h4>Division Accounts</h4>
                                                <small class="text-muted">Manage account details, access levels, and passwords.</small>
                                            </div>
                                            <span class="division-users-count">
                                                <i class="mdi mdi-account-multiple-outline"></i>
                                                <?= count($users); ?> <?= count($users) === 1 ? 'account' : 'accounts'; ?>
                                            </span>
                                        </div>
                                        <div class="division-users-table-wrap table-responsive">
                                        <?php } else { ?>
                                        <div class="table-responsive">
                                            <h4 class="m-t-0 header-title mb-4"><?= $title; ?></h4>
                                        <?php } ?>

                                        <table id="datatable" class="table <?= !empty($division_scope) ? 'dt-responsive' : 'table-bordered dt-responsive nowrap'; ?>" style="width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th><?= !empty($division_scope) ? 'Account' : 'Fullname'; ?></th>
                                                    <th>Username</th>
                                                    <th><?= !empty($division_scope) ? 'Acct. Level' : 'Position'; ?></th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($users as $row){?>
                                                <tr>
                                                    <td data-label="Account">
                                                        <?php if (!empty($division_scope)) {
                                                            $display_name = mb_convert_case(
                                                                trim((!empty($row->lname) ? $row->lname . ', ' : '') . $row->fname . (!empty($row->mname) ? ' ' . substr($row->mname, 0, 1) . '.' : '')),
                                                                MB_CASE_TITLE,
                                                                'UTF-8'
                                                            );
                                                            $initials = strtoupper(substr($row->fname, 0, 1) . (!empty($row->lname) ? substr($row->lname, 0, 1) : ''));
                                                        ?>
                                                        <div class="account-cell">
                                                            <span class="account-avatar"><?= html_escape($initials); ?></span>
                                                            <span class="account-name"><?= html_escape($display_name); ?></span>
                                                        </div>
                                                        <?php } else { ?>
                                                        <?= !empty($row->lname) ? $row->lname . ', ' : '' ?> <?= $row->fname; ?> <?php if(!empty($row->mname)){echo substr($row->mname, 0, 1).'.';} ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td data-label="Username"><span class="<?= !empty($division_scope) ? 'username-text' : ''; ?>"><?= html_escape($row->username); ?></span></td>
                                                    <td data-label="Acct. Level"><span class="<?= !empty($division_scope) ? 'account-level' : ''; ?>"><?= html_escape($row->position); ?></span></td>
                                                    <td>
                                                        <div class="<?= !empty($division_scope) ? 'user-actions' : ''; ?>">
                                                        <?php if(in_array($this->session->position, array('admin', 'division', 'ict'), true)){ ?>
                                                        <a class="btn btn-primary btn-sm" href="<?= base_url(); ?>pages/user_update/<?= $row->id; ?>"><i class="mdi mdi-pencil-outline"></i> Edit</a>
                                                        <?php } ?>
                                                        <?php if($this->session->position == 'admin'){ ?>
                                                        <a href="#profile" class="open-AddBookDialog btn btn-primary btn-sm waves-effect waves-light" data-id="<?= $row->id; ?>" data-animation="slit" data-plugin="custommodal" data-overlayspeed="100" data-overlaycolor="#36404a">Change profile</a>
                                                        <?php } ?>

                                                        <?= form_open('pages/user_reset_password', array('style' => 'display:inline;', 'onsubmit' => "return confirm('Reset this user\\'s password?');")); ?>
                                                            <input type="hidden" name="id" value="<?= $row->id; ?>">
                                                            <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light"><i class="mdi mdi-lock-reset"></i> Reset</button>
                                                        </form>
                                                        
                                                        <?php if(in_array($this->session->position, array('admin', 'division', 'ict'), true) && (string) $row->id !== (string) $this->session->id){ ?>
                                                        <a onclick="return confirm('Delete this user account?')" class="btn btn-danger btn-sm" href="<?= base_url(); ?>pages/user_delete/<?= $row->id; ?>"><i class="mdi mdi-trash-can-outline"></i> Delete</a>
                                                        <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <!-- Modal -->
                        <div id="profile" class="modal-demo">
                            <button type="button" class="close" onclick="Custombox.modal.close();">
                                <span>&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="custom-modal-title">Change Profile Picture</h4>
                            <div class="custom-modal-text">
                                
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?php 
                                            $attributes = array('class' => 'parsley-examples');
                                            echo form_open_multipart('pages/profile', $attributes);
                                        ?>

                                            <div class="modal-body">
                                                <input type="hidden" name="id" id="id" value="">            
                                            </div> 
                                            
                                            <div class="form-group row">
                                                <label for="hori-pass1" class="col-md-4 col-form-label">Select Image<span class="text-danger">*</span></label>
                                                <div class="col-md-7">
                                                    <input id="myInput" type="file" placeholder="Password" name="file"  required class="form-control">
                                                </div>
                                            </div>

                                          
                                            
                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Change Profile
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
                            </div>
                        </div>



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
                        </div>
