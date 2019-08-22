<?php
session_start();

// check to see if $_SESSION['timeout'] is set

//require ('time_out.php');

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



    if(((string) $row['pin']) == ((string) $_POST['pin']) && ($row['bar'] != 1)){


        header('location:create_acct.php');
    }

    else if($row['bar'] == 1)
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

        $email = strtolower($_POST['email']);

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


    </style>

</head>

<body ><!-- background="img/jamb.jpg"-->
<div class="container-fluid" >
    <?php require ('header.php');?>
    <div class="marquee">
        <p id="div1"><span style="color: deeppink; background-color: #FFFFFF" id="son"> The List of Successful Candidates for SON Entrance Examination, 2019/2020 Academic Session:  <a href="1st_set2.pdf"><i class="fa fa-list-ol"> 1st List</i></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="2nd_set2.pdf"><i class="fa fa-list-ol"> 2nd List</i></a>
        </p>
        <p id="div2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span style="color: purple; background-color: #FFFFFF" >Sales of Admission Forms for POST-BASIC PERIOPERATIVE NURSING COURSE For 2019/2020 Academic Session are on ....<a href="https://pns.uch-ibadan.org.ng/" target="_blank">Click here</a></span></p>
        <p id="div3">   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span style="color: dodgerblue; background-color: #FFFFFF" >Sales of Admission Forms for POST-BASIC OCCUPATIONAL HEALTH NURSING COURSE  For 2019/2020 Academic Session are on ....<a href="SOHN.pdf" target="_blank">Click here</a></span></p>
        <p id="div4">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span style="color: orangered; background-color: #FFFFFF" >Sales of Admission Forms into School of Health Information Management For 2019/2020 Academic Session are on ....<a href="http://shim.uch-ibadan.org.ng/" target="_blank">Click here</a></span></p>
        </p>

    </div>



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
        <a href="mailto:admission@uch-ibadan.org.ng" style="font-size:20px; background-color: black; color:#ffffff;" target="_blank">Mail us for any complaint or call: 08067155307</a>

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


        var son = document.getElementById("son");
        var perio = document.getElementById("perio");
        var occ = document.getElementById("occ");
        var shim = document.getElementById("shim");

        var arrayShow =[son, perio, occ, shim];
        var countArrayShow = 0;


        function changeURLAdvert() {

            arrayShow.visibility = visible();

        }



        $(function () {

            var counter = 0,
                divs = $('#div1, #div2, #div3, #div4');

            function showDiv () {
                divs.hide() // hide all divs
                    .filter(function (index) { return index == counter % 4; }) // figure out correct div to show
                    .show('fast'); // and show it

                counter++;
            }; // function to loop through divs and show correct div

            showDiv(); // show first div

            setInterval(function () {
                showDiv(); // show next div
            }, 40 * 1000); // do this every 20 seconds

        });
    </script>


</body>

</html>
</script>

