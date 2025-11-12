<?php
//TO DO: CHECK IF THE ANSWER IS CORRECT, DELETE THE QUESTION IN UNANSWERED QUESTION TABLE
session_start();
include('usnavbar.html');
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
elseif ($_SESSION['accountType'] != "Student"){
    header("Location: index.php");
}
require_once "connection.php";
//vars
$quesID = mysqli_real_escape_string($con, $_GET['quesID']);
$upid = mysqli_real_escape_string($con, $_GET['upid']);
$userID = $_SESSION['id'];
$quID = $_SESSION['quizID'];
$takenID = $_SESSION['takenID'];
$currentScore = $_SESSION['score'];
$feedback = $_SESSION['feedback'];
   
//delete from temp
$delete = "DELETE FROM unansQues WHERE questionID='$quesID'";
$result2 = mysqli_query($con, $delete);

//fetch the correctAnswer from the question table
$sql2 = "SELECT * FROM quiz WHERE quizID='$quID'";
$result3 = mysqli_query($con,$sql2);
$quiz = mysqli_fetch_array($result3);

$totalPoints = $quiz['totalPoints'];

//fetch the correctAnswer from the question table
$sql = "SELECT * FROM question WHERE questionID='$quesID'";
$result = mysqli_query($con,$sql);
$question = mysqli_fetch_array($result);

//variables
$text = $question['questionText'];
$correct = $question['correctAnswer'];
$points = $question['points'];
$quizID = $question['quizID']; 

if(isset($_POST['check'])){
    $answer = strtolower($_POST['answer']);


    if ($answer == $correct){
        $currentScore = $currentScore + $points;
        $_SESSION['score'] = $currentScore;

        $feedback =" ";

        $equi = ($currentScore/$totalPoints)*100;

        if ($equi == 100) {
            $feedback = "Excellent";
        } elseif ($equi >= 85 && $equi <= 99) {
            $feedback = "Above Average";
        } elseif ($equi >= 70 && $equi <= 84) {
            $feedback = "Average";
        } elseif ($equi >= 60 && $equi <= 69) {
            $feedback = "Below Average";
        } else {
            $feedback = "Fail";
        }
        
        $_SESSION['feedback'] =$feedback;
    }

    header('location: quiz_access.php');
    exit();
}
?>

<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  	<link href="style.css" type="text/css" rel="stylesheet">
 	<title>Get and Check Answer</title>
 </head>
 <body>
 <br><br>
    <div class="col-md-5 border-right container1">
        <div class="card">
            <div class="card-body"><?php echo $text?></div><br>
        </div><br>
        <form method="POST">       
            <input class="form-control" type="text" placeholder="Answer" name="answer">
            <div class="mt-3 text-center">
                <div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-primary" type="submit" name="check">Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='quiz_access.php'">Back</button>                    
                </div>
            </div>
        </form>
    </div>
 </body>
 </html>