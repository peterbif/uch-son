<?php
require_once ('connection.php');

session_start();

// check to see if $_SESSION['timeout'] is set

require ('time_out.php');

@$_SESSION['user'];

//auto load classes required
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Connect();




@$pin = $_POST['pin'];

@$email2 = $_POST['email'];

@$phone_no2 = $_POST['phone_no'];

if(isset($_POST['search'])) {


    @$result = $db->selectPinNo22($pin);
    @$row = mysqli_fetch_assoc($result);

   if(@$row){

       $email = $row['email'];

       $phone_no = $row['phone_no'];
   }

    else{

        echo '<script type="text/javascript"> alert("No record")</script>';
    }


}


if(isset($_POST['update'])) {


    if (empty($_POST['email'])) {

        echo '<script type="text/javascript"> alert("Enter Email")</script>';
    } else {
        $query = "UPDATE pin_nos SET email = '{$email2}', phone_no ='{$phone_no2}'  WHERE  pin = '{$pin}'";
        $db->update($query);


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

        .blink{
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            30% { opacity: 0; }
        }
    </style>

</head>

<body ><!-- background="img/jamb.jpg"-->
<div class="container-fluid" >
    <?php require ('header.php');?>

    <br />

    <div class="row">
        <div class="col-lg-12" align="right">
            <a href="super_admin.php" class="button" style="color: #ffffff">Back</a>
        </div>
    </div>

    <!--Pin form-->

            <h1 style="background-color: #FFFFFF; color: forestgreen; text-align: center">Update Email</h1>
            <form class="form-horizontal"  method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">

                <div class="row" align="center" style="margin-top: 30px;">
                    <div class="col-lg-6 col-sm-offset-3">
                       <div class="input-container">
                       <i class="fa fa-key icon"> &nbsp; Pin</i>
                       <input class="input-field" type="text" placeholder="Enter Pin" value="<?php echo @$pin; ?>" required name="pin">&nbsp;&nbsp;

                       <button type="submit" name="search" id="search" class="button"><i class="fa fa-search"></i></button>
                       </div>

                    </div>
                </div>


                <div class="row" align="center" style="margin-top: 30px;">
                    <div class="col-lg-6 col-sm-offset-3">
                <div class="input-container">
                    <i class="fa fa-envelope icon"> &nbsp; Email</i>
                    <input class="input-field" type="text"    placeholder="Email" value="<?php echo @$email;?>" name="email">
                </div>

                        <div class="input-container">
                            <i class="fa fa-phone icon"> &nbsp; Phone</i>
                            <input class="input-field" type="text"    placeholder="Phone No" value="<?php echo @$phone_no;?>" name="phone_no">
                        </div>



                        <div align="right">
                <button type="submit" name="update" class="button"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Update</button>
                </div>

                    </div>
                </div>

            </form>




</body>

</html>

<script>
    $(document).ready(function () {
        $("search").click(function fetch_data() {
            $.ajax({
                url:"load_pin.php",
                method:"POST",
                success:function (data) {
                    $('#live_data').val(data);
                }

            });
        });

        fetch_data();
</script>