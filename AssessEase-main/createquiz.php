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

   $userid = $_SESSION['id'];

    if(isset($_POST['nextBtn'])){
        $title = mysqli_real_escape_string($con, $_POST['quiz-title']);
        $descri = mysqli_real_escape_string($con, $_POST['quiz-description']);

        $insert = "INSERT INTO quiz(title,descri,userID)
        VALUES ('$title','$descri','$userid')";

        if (mysqli_query($con, $insert)) {
            //to get the quiz id     
            $quizid = mysqli_insert_id($con);
            //for reference in add question
            $_SESSION['createID'] = $quizid;  
            header('location: quiz.php');        
        }
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
 	<title>Create Quiz</title>
</head>
<body>
   <br><br>
   <div class="col-md-5 border-right container1">
    <form action="createquiz.php" method="POST">
      <!-- form for title and description -->
      <div class="p-3 py-5">
         <div class="mb-3">
            <label for="quiz-title">Title:</label>
            <input type="text" id="quiz-title" class="form-control" name="quiz-title" required>
         </div>
         <div class="mb-3">        
            <label for="quiz-description">Instructions:</label>
            <textarea id="quiz-description" class="form-control" name="quiz-description" rows="4" required></textarea>
         </div>    
   
         <!-- add questions -->
         <div class="mt-3 text-center">
            <div class="d-grid gap-2 d-md-block">
               <button type="submit" class="btn btn-info" name="nextBtn">Next</button>
               <button type="button" class="btn btn-secondary" onclick="location.href='quizzes.php'">Back</button>
            </div>
         </div>
      </div> 
    </form>
   </div>
 </body>
 </html>