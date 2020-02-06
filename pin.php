<?php
require_once ('connection.php');

session_start();

require ('time_out.php');

//auto load classes required
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Connect();


@$_SESSION['school'] = $_POST['school'];

@$_SESSION['session'] = $_POST['session'];


@$query_sch = $db->selectSchools();
@$result_sch = mysqli_fetch_assoc($query_sch);


@$query_ses = $db->selectSession();
@$result_ses = mysqli_fetch_assoc($query_ses);


if(isset($_POST['submit'])) {
    $number = 1;
    $length = $_POST['total'];

    $counter = $_POST['first'];

    do {
        $char = "1233456789012356432176896543290186423615178837353535436378887543214567986543754433624513980754267389654231098763451987243564781298707501312145167484948765443122436536748748982625244232452526436738909022";
       $pin = trim(substr(str_shuffle($char), -1000000000, 10));
        $school = $_POST['school'];
        $session = $_POST['session'];
        $counter = trim($counter);
        $query_con = "INSERT INTO pin(pin, school_id, session_id, form_no, applicant_id) VALUES ('{$pin}', '{$school}', '{$session}', '{$counter}', '')";
        $db->insertPin($query_con);
        $number++;
        $counter++;
    } while ($number <= $length);

    if(@$query_con) {
        echo '<script type="text/javascript"> alert("Pins successfully generated")</script>';

    }
}


if(isset($_POST['submit2'])) {
    $school = $_POST['school'];
    $session = $_POST['session'];
    @$query_sepin = $db->selectPinSessionSchool($school, $session);
    @$result_sepin = mysqli_fetch_assoc($query_sepin);

    if(@$result_sepin){
        header('location:pin2.php');
    }
    if(!isset($result_sepin)){

        echo '<script type="text/javascript"> alert("No record for this school and session")</script>';
    }

}



if(isset($_POST['submit3'])) {
    $school = $_POST['school'];
    $session = $_POST['session'];
    @$query_sepin = $db->selectPinSessionSchool($school, $session);
    @$result_sepin = mysqli_fetch_assoc($query_sepin);

    if(@$result_sepin){
        header('location:pin3.php');
    }
    if(!isset($result_sepin)){

        echo '<script type="text/javascript"> alert("No record for this school and session")</script>';
    }

}


?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

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
<div class="container-fluid body">
    <?php require ('header.php');?>

    <br /><br />
    <div class="row">
        <div class="col-lg-12" align="right">
            <a href="super_admin.php" class="button" style="color: #ffffff">Back</a>
        </div>
    </div>

    <div class="row col-sm-offset-2">
        <div class="col-lg-8">
            <h2 align="center"><strong>Generate/Print Pins for Schools</strong></h2>
        </div>
    </div><br />



    <form class="form-horizontal"  method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">

        <div class="row col-sm-offset-2">


            <div class="col-lg-3">
                <label>First Pin</label>
                <input type="text" class="form-control" name="first">
            </div>



            <div class="col-lg-3">
                <label>Total Pins</label>
                <input type="text" class="form-control" name="total">
            </div>


        </div>

        <br/>

                <div class="row col-sm-offset-1">
                    <div class="col-lg-7">
                        <select name="school" class="input-field" required>
                            <option value="">Select School</option>
                            <?php do{?>
                                <option value="<?php echo @$result_sch['schools_id'];?>"><?php echo @$result_sch['school'];?></option>
                            <?php }while(@$result_sch = mysqli_fetch_assoc($query_sch));?>
                        </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <select class="input-field state state-control" name="session" required>
                            <option value="">Select Session</option>
                            <?php do{  ?>
                                <option value="<?php echo @$result_ses['session_id']; ?>"><?php echo @$result_ses['session'];?></option>
                            <?php }while(@$result_ses = mysqli_fetch_assoc($query_ses)); ?>
                        </select>
                    </div>

                        <div class="col-lg-3">
                            <button type="submit" name="submit" class="button btn btn-lg">Generate Pins</button>&nbsp;&nbsp;&nbsp;
                            <button type="submit" name="submit3" class="button btn btn-lg">Print Student Pins</button>&nbsp;&nbsp;&nbsp;
                            <button type="submit" name="submit2" class="button btn btn-lg">Print School Pins</button>

                        </div>

                    </div>

                </div>


    </form>
        </div>


</body>

</html>