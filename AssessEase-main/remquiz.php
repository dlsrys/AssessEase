<?php
require_once "connection.php";
//quiz id
$id = $_GET['id'];

//fetch the uploaded quiz
$sql = "SELECT * FROM upQuiz WHERE quizID = '$id'";
$result2 = mysqli_query($con,$sql);

//check if the quiz is uploaded
//if not
if (mysqli_num_rows($result2)==0){
	//delete the questions in the quiz
	$sql_delete1 = "DELETE FROM question WHERE quizID= '$id'";
	$result1 = mysqli_query($con,$sql_delete1);

	//delete the quiz
	$sql_delete = "DELETE FROM quiz WHERE quizID = '$id'";
	$result = mysqli_query($con,$sql_delete);

	if($result == TRUE){
		header('location: quizzes.php');
		exit();
	}	
}
//the quiz is still uploaded
else{
	echo "<script>alert('Can\'t drop quiz, it\'s still uploaded!!'); window.location.href = 'quizzes.php';</script>";
}

?>