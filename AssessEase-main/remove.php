<?php
require_once "connection.php";
$id = $_GET['quesID'];

//delete the value
$sql_delete = "DELETE FROM question WHERE questionID = '$id'";
$result = mysqli_query($con,$sql_delete);



if($result == TRUE){
	header('location: editquiz.php');
	exit();
}

?>