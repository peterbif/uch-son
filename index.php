<?php
session_start();


@$_SESSION['user'] = $_POST['email'];


@$_SESSION['pin'] = $_POST['pin'];

//auto load classes required
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});


$db = new Connect();



if(isset($_POST['generate'])) {


    @$pin = (string) $_POST['pin'];

//query pin table

    @$result = $db->selectPinCode($pin);
    $row = mysqli_fetch_assoc($result);



    if(($row['pin']) === ($_POST['pin']) && ($row['applicant_id'] == 0)){


        header('location:create_acct.php');
    }

    else if($row['applicant_id'] != 0)
    {

        echo '<script type="text/javascript"> alert("Already Used Pin")</script>';
    }

    else
    {

        echo '<script type="text/javascript"> alert("Incorrect Pin")</script>';
    }


}




if(isset($_POST['login'])) {

    $email = $_POST['email'];

    $password = md5($_POST['password']);


    //query pin_no table
    @$result_pin = $db->selectPinNoEMail($email);
    @$row_pin = mysqli_fetch_assoc($result_pin);


    //query users table
    $query = $db->selectAllUsers($email);
    $record = mysqli_fetch_assoc($query);

    // echo $record['uemail'];

    // echo $row_pin['email'] ;

    // echo  $_POST['email'];

    //echo $record['uemail'];


    if(isset($_POST['login'])) {

        $email = strtolower(trim($_POST['email']));

        $password = md5($_POST['password']);

        //$password = $_POST['password'];


        //query pin_no table

        @$result_pin = $db->selectPinNoEMail($email);
        @$row_pin = mysqli_fetch_assoc($result_pin);


        //query users table

        $query = $db->selectAllUsers($email);
        $record = mysqli_fetch_assoc($query);


        if($record) {
            if ((strtolower($record['uemail'])) != $email) {

                echo '<script type="text/javascript"> alert("Email is incorrect") </script>';
            } else if ($record['password'] != $password) {


                echo '<script type="text/javascript"> alert("Password is incorrect") </script>';

            } elseif ($record['password'] == $password && $record['role'] == 1) {

                header('location: admin.php');

            } else {
                if ($record['password'] == $password && $record['role'] == 2) {

                    header('location: super_admin.php');

                }
            }
        }


        if(!$record){

            if ((strtolower($row_pin['email'])) != $email) {

                echo '<script type="text/javascript"> alert("Email is incorrect") </script>';
            } else if ($row_pin['pin_no'] != md5($_POST['password'])) {


                echo '<script type="text/javascript"> alert("Password is incorrect") </script>';

            } else {


                if ($row_pin['pin_no'] == $password) {

                    header('location: biodata.php');

                }

            }

        }

    }


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php require ('title.php');?></title>

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/animate.css">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="css/font-awesome.css">

    <link rel="stylesheet" href="css/style2.css">


    <script src="js/jquery.min.js"></script>
    <script src="js/myOpenForm.js"></script>
    <style>
        body {
            background-image: url("img/nurse.jpg");
            background-repeat: no-repeat;
            background-size:1485px 650px;

        }
    </style>

    <style>

        .blink{
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            30% { opacity: 0; }
        }

        .marquee {
            width: 400px;
            line-height: 50px;
            color: Black;
            white-space: nowrap;
            box-sizing: border-box;
        }
        .marquee p {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 60s linear infinite;
            font-size: 20px;
        }
        @keyframes marquee {
            0%   { transform: translate(0, 0); }
            100% { transform: translate(-100%, 0); }
        }

    </style>

</head>

<body ><!-- background="img/jamb.jpg"-->
<div class="container-fluid" >
    <?php require ('header.php');?>
   <!-- <div class="marquee">
        <p><span style="color: orangered; background-color: #FFFFFF">All SHIM applicants should login to check their Admission Status &nbsp; &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; &nbsp; School of Health Information Management's  Interview comes up on  Friday, 13th September, 2019 ............<a href="interview.pdf" target="_blank">Read More</a></span>
        </p>
    </div>-->



    <!--Pin form-->
    <div class="row" align="center" style="margin-top: 30px;">
        <div class="col-lg-6 col-sm-offset-3">
            <div class="top">
                <div class="form-popup2" id="myForm1">
                    <h1 style="background-color: #FFFFFF; color: forestgreen; text-align: center">Enter Pin Code</h1>
                    <form class="form-horizontal"  method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">

                        <div class="input-container">
                            <i class="fa fa-key icon"> </i>
                            <input class="input-field" type="text"   placeholder="Enter Pin"  required name="pin">
                        </div>

                        <button type="submit" name="generate" class="button"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;login</button> &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" class="button" onclick="closeForm1()"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Close</button>
                    </form>
                </div>
            </div>
        </div>


    </div>


    <!--login form-->
    <!-- <div class="row" align="center" style="margin-top: 30px;">
        <div class="col-lg-6 col-sm-offset-3">
            <div class="top">
                <div class="form-popup" id="myForm2">
                    <h1 style="background-color: #FFFFFF; color: forestgreen; text-align: center">Applicant Login</h1>
                    <form class="form-horizontal"  method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
                        <div class="input-container">
                            <i class="fa fa-text-width icon"></i>
                            <input class="input-field" type="text"   placeholder="Email" required name="email">
                        </div>

                        <div class="input-container">
                            <i class="fa fa-key icon"></i>
                            <input class="input-field" type="text" placeholder="Password"  required name="psw">
                        </div>

                        <button type="submit" class="button">Login</button> &nbsp;&nbsp;
                        <button type="submit" class="button" onclick="closeForm2()">Close</button>
                    </form>
                </div>
            </div>
        </div>


    </div>-->

    <!--Login form-->

    <div class="row" align="center" style="margin-top: 30px;">
        <div class="col-lg-6 col-sm-offset-3">
            <div class="top">
                <div class="form-popup" id="myForm3">
                    <h1 style="background-color: #FFFFFF; color: forestgreen; text-align: center">Login</h1>
                    <form class="form-horizontal"  method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
                        <div class="input-container">
                            <i class="fa fa-envelope icon">&nbsp; Email</i>
                            <input class="input-field" type="text"   placeholder="Email" required  name="email">
                        </div><br /><b />

                        <div class="input-container">
                            <i class="fa fa-key icon"> Password</i>
                            <input class="input-field" type="password"  placeholder="Password"  required  name="password">
                        </div>

                        <button type="submit" name="login" class="button"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Login</button> &nbsp;&nbsp;
                        <button type="submit" class="button" onclick="closeForm3()"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Close</button><br /><br />

                        <div><a href="forget_password.php">Forget Password/Change Password</a> </div>
                    </form>
                </div>
            </div>
        </div>


    </div>


    <br /><br/><br/><br /><br/><br/><br />

    <div class="row" align="center" style="margin-top: 15px;">

        <button class="button" onclick="openForm()"><span class="login-button"><i class="fa fa-folder-open"></i>&nbsp;&nbsp;Enter Pin</span></button> &nbsp;&nbsp;&nbsp;&nbsp;<!-- <a href="#"  ><img src="img/pay.png"></a>-->&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <button class="button" onclick="openForm3()"><span class="login-button"><i class="fa fa-folder-open"></i>&nbsp;&nbsp;Log In</span></button>
    </div><br/><br /><br/><br/><br />

    <div class="col-lg-12"><br/><br />

    </div>

    <div class="row" align="center" style="margin-top: 15px;">
        <!--<button><a href="vanc.pdf" class="blink" style="font-size:20px; color:#EE1122;" target="_blank">New Advertisement for Vacancies</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
        <button><a href="Applicants User Guide.pdf" class="blink" style="font-size:20px; color:#EE1122;" target="_blank">Download Applicant's Guide</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="mailto:admission@uch-ibadan.org.ng" style="font-size:20px; background-color: black; color:#ffffff;" target="_blank">Mail us for any complaint or call: Elizabeth: 07035073765 or Omobolanle:08034635861</a>

    </div>



    <script>
        function openForm() {
            document.getElementById("myForm1").style.display = "block";
        }

        function closeForm1() {
            document.getElementById("myForm1").style.display = "none";
        }
    </script>




    <script>
        function openForm2() {
            document.getElementById("myForm2").style.display = "block";
        }

        function closeForm2() {
            document.getElementById("myForm2").style.display = "none";
        }


        function openForm3() {
            document.getElementById("myForm3").style.display = "block";
        }

        function closeForm3() {
            document.getElementById("myForm3").style.display = "none";
        }



    </script>


</body>

</html>
</script>

