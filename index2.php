<?php
require_once ('connection.php');

session_start();

// check to see if $_SESSION['timeout'] is set

require ('time_out.php');

@$_SESSION['user'] = $_POST['email'];

//auto load classes required
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Connect();



//query set time table
$result2 = $db->selectSetTime3();
$row2 = mysqli_fetch_assoc($result2);

//query position
$result = $db->selectPosition2();
$row = mysqli_fetch_assoc($result);


if(isset($_POST['generate'])) {

    $email = strtolower(htmlspecialchars($_POST['email2']));
    $phone_no = htmlspecialchars($_POST['phone_no']);

    @$result = $db->selectPinNo($email,$phone_no);
    $row = mysqli_fetch_assoc($result);


    $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";

    if($row){

        echo '<script type="text/javascript"> alert("Your Record exists")</script>';
    }

    else if ($pin = substr(str_shuffle($char), -1000000000, 8)) {

        @$pin;
        $time = $row2['set_time'];
        $position = $_POST['position'];
        $query_pin = "INSERT INTO pin_nos (pin_no, email, phone_no, time, position_id) VALUES ('{$pin}', '{$email}','{$phone_no}','{$time}', '{$position}')";
        $db->insert($query_pin);

        $to = $_POST['email2'];
        $subject = "My PIN Code Request";
        $body = "This is your PIn Code:" . '   ' . $pin . " Click this link to create password to sign in: => " . ' ' . "http://employment.uch-ibadan.org.ng/sign_in.php";
        $header = 'From: <employment.uch-ibadan.org.ng>';

        if(mail($to, $subject, $body, $header)) {
            echo $email_sent = '<script type="text/javascript"> alert("Pin Code has been sent to your email to continue your application!")</script>';
        }

    }

    else {

        echo '<script type="text/javascript"> alert("Pin Code not generated, retry")</script>';

    }


}
if(isset($_POST['login'])) {

    $email = $_POST['email'];

    $password = /*md5*/($_POST['password']);

    //$password = $_POST['password'];


    //query pin_no table

    @$result_pin = $db->selectPinNoEMail($_POST['email'], $_POST['password']);
    @$row_pin = mysqli_fetch_assoc($result_pin);


    //query users table

    $query = $db->selectAllUsers($email);
    $record = mysqli_fetch_assoc($query);

    // echo $record['uemail'];

    //echo $row_pin['pin_no'] ;
    // echo  $_POST['password'];
    if ($record){
        if ($record['uemail'] != $email) {

            echo '<script type="text/javascript"> alert("Email is incorrect") </script>';
        } else if ($record['password'] != $password) {


            echo '<script type="text/javascript"> alert("Password is incorrect") </script>';

        }

        else{
            if($record['password'] == $password && $record['role'] == 1) {

                header('location: admin.php');

            }


        }
    }



    if(@$row_pin){

        if($row_pin['email'] != $email){

            echo '<script type="text/javascript"> alert("Email is incorrect") </script>';
        }


        else if($row_pin['pin_no'] != $_POST['password']){


            echo '<script type="text/javascript"> alert("Password is incorrect") </script>';

        }

        else {


            if($row_pin) {

                header('location: biodata.php');

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

</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div align="center" class="col-sm-12">
<h1 style="font-size: 50px; background-color: #3c763d; color: #FFFFFF"> For  UCH Vacancies, Please Check Back Very Soon! </h1>
        </div>
    </div>
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
</script>



<script>
    function openForm3() {
        document.getElementById("myForm3").style.display = "block";
    }

    function closeForm3() {
        document.getElementById("myForm3").style.display = "none";
    }
</script>


</body>

</html>