<?php
session_start();

require ('time_out.php');

//auto load classes required
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Connect();


@$_SESSION['user'];

@$query_sch = $db->selectAllUsers(@$_SESSION['user']);
@$result_sch = mysqli_fetch_assoc($query_sch);

$school_name = @$result_sch['school'];

@$school2 = @$result_sch['school_id'];

@$school = @$school2 ;
@$session = $_SESSION['session'];

$query_ses2 = $db->selectSession3(@$_SESSION['session']);
$result_ses2 = mysqli_fetch_assoc($query_ses2);




@$school = $school2;

if(@$school && @$session) {

    if(@$school2 == 11) {
        $query = $db->selectPinNum222(@$school, $session, @$_SESSION['program']);
        $result = mysqli_fetch_assoc($query);
    }
    else{

        $query = $db->selectPinNum22(@$school, $session);
        $result = mysqli_fetch_assoc($query);
    }






    if(@$school2 == 11) {

//loop through

        @$query2 = $db->selectPinNum222($school, $session, @$_SESSION['program']);
        @$result2 = mysqli_fetch_assoc($query2);

        if (@$result2) {
            @$count = 0;

            do {
                @$result2["surname"];
                @$count++;
            } while (@$result2 = mysqli_fetch_assoc($query2));

            @$total_applicants = $count++;

        } else {
            @$total_applicants = 0;
        }

    }
    else{
        @$query2 = $db->selectPinNum22($school, $session);
        @$result2 = mysqli_fetch_assoc($query2);

        if (@$result2) {
            @$count = 0;

            do {
                @$result2["surname"];
                @$count++;
            } while (@$result2 = mysqli_fetch_assoc($query2));

            @$total_applicants = $count++;

        } else {
            @$total_applicants = 0;
        }
    }

}else{

    echo '<script type="text/javascript"> alert("No records for this school") </script>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php require ('title.php');?></title>

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/animate.css">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="css/font-awesome.css">

    <link rel="stylesheet" href="css/3.3.7bootstrap.min.css">


    <script src="js/3.3.7bootstrap.min.js.js"></script>

    <script src="js/3.2.1jquery.min.js.js"></script>

    <script src="js/slide.js"></script>


    <script src="js/jquery.min.js"></script>

    <style>
        .td{
            text-transform: uppercase;
        }

    </style>

</head>



<body>
<div class="container-fluid">

    <div class="panel panel-danger">
        <?php require ('header.php')?>

        <div class="panel-body">&nbsp;&nbsp;
            <div class="row">
                <form class="form-horizontal form-inline"   method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">


                    <div class="col-lg-4" >
                        <h6 class="button" align="left"> Applicants: <?php echo @$total_applicants;?></h6>
                    </div>


                </form>


            </div> <br/><br />

            <br/><br />
            <div class="row">

                <div class="col-lg-4 col-sm-offset-1 input-container" align="center"> <input type="text" id="myInput" class="input-field" onkeyup="myFunction()" placeholder="Search By Form NO" name="myInput"></div>
                <div class="col-lg-4 col-sm-offset-1 input-container" align="center"> <input type="text" id="myInput2" class="input-field" onkeyup="myFunction2()" placeholder="Search By Surname" name="myInput2"></div>

            </div>
            <div class="row">
                <div class="col-lg-12 showResult">
                    <h3 align="center"  style="color: #000000"><?php if(@$result){echo 'List of '. ' ' .@$result_sch2['school'].' '; if(@$school2 == 11){echo 'for ';} '  ' . '  '; echo @$result['program'].' '.'Applicant(s)'.' ('.@$result_ses2['session'].' Session)';}?></h3>

                    <table class="table table-bordered" id="myTable">
                        <thead>
                        <tr>

                            <th>S/N</th>
                            <th>Passport</th>
                            <th>Form NO</th>
                            <th>Surname</th>
                            <th>Firstname</th>
                            <th>Othername</th>
                            <th>Gender</th>
                            <th>Score</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $sn = 1; do{

                            if (@$result){
                                $image = $result['capture'];
                                $form_no = $result['code'];
                                $surname = $result['bsurname'];
                                $firstname = $result['bfirstname'];
                                $othername = $result['bothername'];
                                $gender = $result['gender'];
                                $score = $result['student_score'];

                                $applicant =  $result['pin_no_id'];

                                // @$_SESSION['id'] = $result['pin_no_id'];



                            }



                            ?>
                            <tr>
                                <td class="td"><?php if(@$result) {echo $sn++;} ?></td>
                                <td><img  align="right" src="uploads/<?php echo @$image;?>" class="img-rounded" width="80px" height="80px" /></td>
                                <td><?php echo @$form_no; ?></td>
                                <td class="td"> <a href="admin_applicant.php?id=<?php echo @$applicant;?>" target="_blank" > <?php echo @$surname;?></a>
                                <td><?php echo @$firstname; ?></td>
                                <td><?php echo @$othername; ?></td>
                                <td><?php echo @$gender; ?></td>
                                <td> <a href="student_exam_score.php?id=<?php echo @$applicant; ?>" class="btn btn-success" target="_blank">Enter Score</a> <br/>  <?php if(@$score){echo'<span style="font-size: 20px;"><strong>score:</strong></span>'.' '.@$score ;}?></td>


                            </tr>
                        <?php }while(@$result = mysqli_fetch_assoc($query));

                        ?>

                        </tbody>
                    </table>


                </div>


            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div align="right"><button class="button" ><a href="print_st_score.php" style="color: #FFFFFF;" target="_blank"><i class="fa fa-print"></i> Print</a> </button>
                    </div>
                </div>
                <?php require ('footer.php')?>

            </div>

        </div>


        <script>
            function myFunction() {

                var input, filter, table, tr, td, i;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for(i = 0; i < tr.length; i++){

                    td = tr[i].getElementsByTagName("td")[2];
                    if(td){

                        if(td.innerHTML.toUpperCase().indexOf(filter) > -1){

                            tr[i].style.display = "";
                        }

                        else {

                            tr[i].style.display = "none";
                        }
                    }
                }

            }


            function myFunction2() {

                var input, filter, table, tr, td, i;
                input = document.getElementById("myInput2");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for(i = 0; i < tr.length; i++){

                    td = tr[i].getElementsByTagName("td")[3];
                    if(td){

                        if(td.innerHTML.toUpperCase().indexOf(filter) > -1){

                            tr[i].style.display = "";
                        }

                        else {

                            tr[i].style.display = "none";
                        }
                    }
                }

            }
        </script>



</body>

</html>