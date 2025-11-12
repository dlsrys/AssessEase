<?php
require_once "connection.php";
$id = $_GET['id'];

// check if the upQuiz is in the quiz_taken
$sql = "SELECT * FROM quiz_taken WHERE upQUiz = '$id'";
$result1 = mysqli_query($con,$sql);

if(mysqli_num_rows($result1) == 0){
	//if not found in the quiz_taken delete the value
	$sql_delete = "DELETE FROM upQuiz WHERE upQuiz = '$id'";
	$result = mysqli_query($con,$sql_delete);
	
	if($result == TRUE){
		header('location: uploadedQuiz.php');
		exit();
	}
}
else{
	echo "<script>alert('Quiz locked: Students beat you to it!'); window.location.href = 'uploadedQuiz.php';</script>";
}





?>