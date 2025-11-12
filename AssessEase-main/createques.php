<?php 
   include('adnavbar.html');
   session_start();
   if (!isset($_SESSION['user'])) {
      header("Location: login.php");
   }
   elseif ($_SESSION['accountType'] != "Teacher"){
    header("Location: student.php");
  }
   require_once 'connection.php';
    
   //check if url has the quiz id
    if(isset($_GET['id'])){
    $qid = $_GET['id'];
    } else{
    $qid = $_SESSION['quizid'];
    }
    //fetch the quiz details
    $sql = "SELECT * FROM quiz WHERE quizID ='$qid'";
    $result = mysqli_query($con,$sql);
    $quiz = mysqli_fetch_array($result);
   
   ?>

<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="style.css" type="text/css" rel="stylesheet">
 	<title>Create Question</title>
</head>
<body>
<br><br>
<h3 class="text-center">Create Question</h3><br>
  <div class="col-md-5 border-right container1">
  <?php
      //insert question
      if(isset($_POST['add'])){
        $ques = mysqli_real_escape_string($con, $_POST['ques']);
        $correctAns = strtolower($_POST['correctAns']);
        $points = $_POST['points'];
              
      
        $insert = "INSERT INTO question(quizID,questionText,correctAnswer,points) VALUES ('$qid','$ques','$correctAns','$points')";
      
        if (mysqli_query($con, $insert)) {      
          header('location: editquiz.php');        
          }
        }
    ?>
    <form action="createques.php" method="POST">
      <div class="p-3 py-5">
        <div class="mb-3">
          <!--text area for question input -->
          <label for="ques" class="form-label">Question</label>
          <textarea class="form-control" id="ques" name="ques" rows="5" required></textarea>
        </div>
        <div class="mb-3">
          <!--correct answer -->
          <label for="correctAns" class="form-label">Correct Answer</label>
          <input class="form-control form-control-sm" type="text" name="correctAns" required>
        </div>
        <div class="mb-3">
          <!--points -->
          <label for="correctAns" class="form-label">Points</label>
          <input class="form-control form-control-sm" type="number" min="1" name="points" required>
        </div>
        </div>
        <div class="mt-3 text-center">
          <button type="submit" class="btn btn-info" name="add">Add Question</button>
          <button type="button" class="btn btn-secondary" onclick="location.href='editquiz.php'">Back</button>
        </div>
    </form>
 </body>
 </html>