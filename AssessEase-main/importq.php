<?php
require_once "connection.php";
$quizid = $_GET['quizid'];
$qbankid = $_GET['qbankid'];

//fetch qbank details
$sql_qbank = "SELECT * FROM qbank WHERE qbankID = '$qbankid'";
$result_qbank = mysqli_query($con,$sql_qbank);
$qbank = mysqli_fetch_array($result_qbank,MYSQLI_ASSOC);

//variables
$ques = mysqli_real_escape_string($con, $qbank['questionText']);
$ans = mysqli_real_escape_string($con, $qbank['correctAnswer']);
$points = mysqli_real_escape_string($con, $qbank['points']);

$sql = "INSERT INTO question(quizID,questionText,correctAnswer,points) VALUES ($quizid,'$ques','$ans','$points')";
$result = mysqli_query($con,$sql);

if($result == TRUE){
    echo "<script>alert('Question added!'); window.location.href = 'import.php';</script>";
}

?>