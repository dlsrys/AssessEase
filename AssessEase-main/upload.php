<?php
require_once "connection.php";
session_start();
$userid = $_SESSION['id'];
$quizid = $_GET['id'];
$title = mysqli_real_escape_string($con, $_GET['title']);
$points = $_GET['tot'];

//uploaded quiz details
$sql = "SELECT * FROM upQuiz WHERE userID='$userid'";
$sqlRes = mysqli_query($con,$sql);

//upload the quiz
$sql_upload = "INSERT INTO upQUiz(userID,quizID,title,totalPoints) VALUES ('$userid','$quizid','$title',$points)";

//cannot upload if there is no question in the quiz
$sql_question = "SELECT * FROM question WHERE quizID = '$quizid'";
$quesResult = mysqli_query($con,$sql_question);

if (mysqli_num_rows($quesResult)==0){
    echo "<script>alert('Quiz upload halted, questions await!'); window.location.href = 'quizzes.php';</script>";
}
else{
    //check if there is duplicate
    while($upquiz = mysqli_fetch_array($sqlRes)){
        if($upquiz['quizID'] == $quizid){
            echo "<script>alert('Quiz already uploaded!'); window.location.href = 'quizzes.php';</script>";
            exit();
        }
    }
    $result = mysqli_query($con,$sql_upload);
    if($result == TRUE){
        echo "<script>alert('Quiz successfully uploaded!'); window.location.href = 'quizzes.php';</script>"; 
    }
}

?>