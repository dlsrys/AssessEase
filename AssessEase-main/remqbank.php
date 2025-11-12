<?php
require_once "connection.php";
$id = $_GET['id'];

//delete the value
$sql_delete = "DELETE FROM qbank WHERE qbankID = '$id'";
$result = mysqli_query($con,$sql_delete);

if($result == TRUE){
	header('location: qbank.php');
	exit();
}

?>