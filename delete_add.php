<?php
session_start();

require ('time_out.php');

@$_SESSION['user'];

@$id = $_GET['id'];

//auto load classes required
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$db = new Connect();

$query_add = "DELETE FROM additional_qualification  WHERE additional_qualification_id ='{$_POST['id']}'";
$db->delete($query_add);



?>