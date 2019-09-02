<?php
session_start();

//require('time_out.php');

$_SESSION['user'];

//auto load classes required
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Connect();



@$query_pin = $db->selectPinNOPosition(@$_SESSION['user']);
@$record_pin= mysqli_fetch_assoc($query_pin);

//query school table
@$result_res2 = $db->selectSchool2($record_pin['pin_no_id']);
@$record_res2 = mysqli_fetch_assoc($result_res2);

//query capture table
@$query_pass = $db->selectPassport($record_pin['pin_no_id']);
@$result_pass = mysqli_fetch_assoc($query_pass);

//joining table biodata marital status Gender
$query_bio = $db->selectBioDataMaritalGender(@$record_pin['pin_no_id']);
$result_bio = mysqli_fetch_assoc($query_bio);


//query school logo table
@$query_logo = $db->selectSchoolLogo(@$record_res2['schools_id']);
@$result_logo = mysqli_fetch_assoc($query_logo)



?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admission Letter</title>

    <style>

        div{
            margin:10px;

        }

        .principal{
            text-align:center;
        }


        body{

            width:auto;
            height:auto;
            font-family:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
            font-size:16px;
            text-align:justify;
            padding:5px;


        }
        .email{
            font-size:13px;
        }

        p{
            margin-bottom:4px;
        }

        #logo{
            height: 110px;
            width: 1000px;

        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <link href="../css/table_result.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script src="../js/bootstrap.js" type="text/javascript"></script>
    <script src="../js/slide.js" type="text/javascript"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container-fluid text-center">
    <div class="row content">

        <div class="col-sm-12 text-left">
            <div class="container">
                <div  align="center" ><img  src="saved_images/letter_head.fw.png" class="img-rounded" height="98px" width="auto"/>

                </div>
                <div>

                    <p>&nbsp;</p>


                    <h4 align="center"> <strong>OFFER  OF PROVISIONAL ADMISSION INTO <?php echo strtoupper(@$recordset_app['program_name']);?> <br />PROGRAMME (<?php echo strtoupper(@$recordset_app['year']);?>  ACADEMIC SESSION)</strong></h4>
                    <p>With reference to your application  for admission into <strong> <?php echo ucwords(@$recordset_app['program_name']);?> Programme in the School  of Health Information Management, University College Hospital, Ibadan</strong>, I  have the pleasure to inform you that you have been offered provisional  admission to pursue an academic programme leading to the award of <strong><?php echo strtoupper(@$recordset_app['program_name']);?> in HEALTH  INFORMATION MANAGEMENT</strong>. The programme commencing from 29th  October 2018.  An arrangement for your  Medical Examination will be made when you resume.</p>
                    <p>Please take note of the following  conditions, which are related to your admission and registration:</p>
                    <ol>
                        <li>This offer of admission is  strictly provisional and may be revoked if:</li>
                        <li>You  fail to formally accept this offer by paying the acceptance fee of <strong>N25, 000.00</strong> (Naira), and other charge  within two (2 weeks) after printing of admission letter.</li>
                        <li>You are unable to complete medical exmaination 3 weeks after resumption</li>

                        <li>You  are unable to satisfy the necessary requirements for admission and  registration.</li>
                        <li>You  cannot produce as at the time of registration, the original copies of your  certificates, transcript and other academic credentials.</li>
                    </ol>
                    <p>This offer of provisional  admission and your continued stay in this School are subject to the condition  that your health conduct and general progress are satisfactory throughout the course.  Failure to achieve a Grade Point Average  (GPA) of 1.0 at the end of 1st semester would result in your being  asked to <strong><u>withdraw</u></strong> from the  School.</p>
                    <p>You should also note that the  School&rsquo;s policy stipulates that any student involved in any form of boycott,  strike action, mis-conduct or secret cult activities at any stage of training  will be dismissed and the Health Records Officers Registration Board would be  notified accordingly.</p>
                    <p><strong>Pregnancy  is not allowed during training</strong></p>
                    <p>In event of any emergency preventing  your arrival at scheduled time, you should inform the School and payment should  have been made. The offer lapses if for  any reason whatsoever you are not physically present in the School by 29th  October, 2018. The entire members of  staff of this School look forward to welcoming you and I pray you enjoy your  stay in the Premier Institution.</p>
                    <p class="principal">Yours  faithfully,</p>
                    <p class="principal"><img src="uploads/sig.jpg" height="35px" width="350px;"></p>
                    <p class="principal">O. Lanlehin <br>
                        <strong>Head of School</strong></p>
                    <p align="right" colspan="12"><button type="button" id="submit" name="submit"  class="btn btn-primary"  onClick="print_page()" formtarget="_blank"><span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Print</button></p>
                    <footer class="container-fluid text-center" id="footer_3">
                        <p align="center"><font color="#F1EBEB" size="1px;">&copy 20<?php echo date("y")?>&nbsp;&nbsp;   Designed by Information Technology Department, University College Hospital, Ibadan.</font></p>
                    </footer>
                    <div>
                        <div> <?php echo '<h3 style="text-align: left; color: #0F971A; font-size: 20px; position: absolute; top: 115px; left: 280px; z-index: 1;">'.  $recordset['surname'].'  '. '  '. $recordset['firstname'] . ' '. '    '.$recordset['othername'].'</h3>';?> .<img  style="position: absolute; top: 135px; right: 3px;"  src="uploads/<?php echo $recordset_pas['file'];?>" class="img-rounded" height="80px" width="88"/></div>
                    </div>
                </div>
            </div>
        </div>

</body>
</html>
