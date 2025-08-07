<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <?php include('includes/page-title.php'); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/hris.ico">

        <!-- Plugins css-->
        <link href="<?= base_url(); ?>assets/css/renren.css" rel="stylesheet" type="text/css" />
        <link href="https://db.onlinewebfonts.com/a/0nH393RJctHgt1f2YvZvyruY" rel="stylesheet" type="text/css"/>

    </head>


    <body>
            <div class="hwrap">
                <img class="logo" src="<?= base_url(); ?>assets/images/report/ke.png" alt="">
                    <p class="textwrap">
                    <span class="rp">Republic of the Philippines</span>
                        <span class="de">Department of Education</span>
                        <span class="r">Region XI</span>
                        <span class="r">School Division of Davao Oriental</span>
                        <span class="r">Mati City</span>
                    </p>

                    <p style="margin:20px 0; font-weight:bold">ACTION PLAN</p>

                    <p>
                    <b><u><?= strtoupper($school->schoolName); ?></u></b><br />
                        <?= ucfirst($school->brgy).', '.ucfirst($school->city) ?>, Davao Oriental<br />
                        School ID <b><u><?= $school->schoolID; ?></u></b><br />
                    </p>
                    
            </div>



            <div class="action_plan">
            <table>
                <tr>
                    <th>ACTIVITY</th> 	
                    <th>OBJECTIVES</th>
                    <th>EXPECTED OUTPUTS</th>
                    <th>METHODOLOGY STRATEGY</th>	
                    <th>TIME FRAME</th>
                    <th>PERSON INVOLVED</th>
                    <th>BUDGETARY REQUIREMENT</th>	
                    <th>REMARKS</th>
                </tr>
                <?php foreach($data as $row){?>
                <tr>
                    <td><?= $row->activity; ?></td>
                    <td><?= $row->objective; ?></td>
                    <td><?= $row->ex_output; ?></td>
                    <td><?= $row->metho_strategy; ?></td>
                    <td><?= $row->time_frame; ?></td>
                    <td><?= $row->person_involved; ?></td>
                    <td><?= $row->bud_req; ?></td>
                    <td><?= $row->remarks; ?></td>
                </tr>
                <?php } ?>
            </table>
            </div>




        </body>
    </html>

    