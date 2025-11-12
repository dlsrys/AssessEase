<?php 
session_start();
include ('usnavbar.html');
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
elseif ($_SESSION['accountType'] != "Student"){
    header("Location: index.php");
}
require_once 'connection.php';

$quizID = $_SESSION['quizID'];
$takenID = $_SESSION['takenID'];
//get the score and feedback from quiz_taken
$sql = "SELECT * FROM quiz_taken WHERE takenID='$takenID'";
$result = mysqli_query($con,$sql);
$quiztaken = mysqli_fetch_array($result);

//score and feedback
$score = $quiztaken['totalScore'];
$feedback = $quiztaken['feedback'];
//get the totalPoints in quiz table
$sql1 = "SELECT * FROM quiz WHERE quizID='$quizID'";
$result1 = mysqli_query($con,$sql1);
$quiz = mysqli_fetch_array($result1);
//total possible score
$totalScore = $quiz['totalPoints'];
?>
<!DOCTYPE html>
<html>
<head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  	<link href="style.css" type="text/css" rel="stylesheet">
 	<title>Result</title>
</head>
<body>
    <br><br>
    <div class="col-md-5 border-right container1">
    <h1 class="display-6 text-center">Unveiling Your Triumph!</h1>
    <table class="table table-hover">
        <tr>
            <th>Your Score</th>
            <th>Total Possible Score</th>
            <th>Feedback</th>
        </tr>
        <tr>
            <td><?php echo $score?></td>
            <td><?php echo $totalScore?></td>
            <td><?php echo $feedback?></td>
        </tr>
    </table>
    <br>
        <div class="mt-3 text-center">
            <button type="button" class="btn btn-secondary" onclick="location.href='student.php'">Return</button>
        </div>
    </div>
</body>
</html>