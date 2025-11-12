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

    //to access the quiz
    $_SESSION['quizid'] = $qid;
   
   //fetch the questions of the quiz
    $sql_ques = "SELECT * FROM question WHERE quizID ='$qid'";
    $ques = mysqli_query($con,$sql_ques);

   //update question
    if(isset($_POST['save'])){
		  $title = mysqli_real_escape_string($con, $_POST['qtitle']);
		  $dsc = mysqli_real_escape_string($con, $_POST['descri']);
      $open = $_POST['openDate'];
      $close = $_POST['closeDate'];


		  $update = "UPDATE quiz SET title='$title', descri='$dsc' WHERE quizID ='$qid'";
      $insertData = "UPDATE quiz set StartDate='$open', EndDate='$close' WHERE quizID ='$qid'";
      
      if ($result = mysqli_query($con,$update)){
        if($resultInsert = mysqli_query($con,$insertData)){
          //make sure there are questions in the quiz
          if (mysqli_num_rows($ques)==0){
             echo "<div class='alert alert-warning'>Quiz saved, questions pending. Edit anytime!</div>";
          }
            else{
              echo "<script>alert('Quiz saved!'); window.location.href = 'quizzes.php';</script>";
        
            } 
          }
        }
      }
   //count of questions in the quiz
   $counts = "SELECT COUNT(questionID) FROM question WHERE quizID = '$qid'";
   $resultCount = mysqli_query($con,$counts);
   //sum of points
   $sum = "SELECT SUM(points) FROM question WHERE quizID='$qid'";
   $resultSum = mysqli_query($con,$sum);
   
?>
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="style.css" type="text/css" rel="stylesheet">
 	<title>Edit Quiz</title>
</head>
<body>
  <br><br>
  <h3 class="text-center"><?php echo $quiz['title']; ?></h3>
  <h6 class="text-center">Quiz ID: <?php echo $quiz['quizID']; ?></h6><br>
  <div class="col-md-5 border-right container1">
  <form action="editquiz.php" method="POST">
    <!-- button for save and back -->
    <div class="mt-2 text-center">
      <div class="d-grid gap-2 d-md-block">
        <button type="submit" class="btn btn-info" name="save">Save Changes</button>
        <button type="button" class="btn btn-secondary" onclick="location.href='quizzes.php'">Back</button>
      </div>
    </div>
    <div class="p-3 py-5">     
        <!--Title and description -->
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Title</label>
          <input type="text" class="form-control" id="exampleFormControlInput1" value="<?php echo$quiz['title']; ?>" name="qtitle" required>
        </div>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">Instructions</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" name="descri" required><?php echo$quiz['descri']; ?></textarea>
        </div>
        <!--question count-->
        <div class="mt-3 text-center">
          <p class="text-center">Question Count:
            <?php
            //count
            while($count = mysqli_fetch_array($resultCount)){
              echo $count[0];
            }?>
          </p>
          <p class="text-center">Total Points:
          <?php
            //count
            while($sumPoints = mysqli_fetch_array($resultSum)){
              $totPoints = $sumPoints[0];
              echo $sumPoints[0];

              //update the points for quiz
              $updatePoints = "UPDATE quiz SET totalPoints ='$totPoints' WHERE quizID='$qid'";
              $resultUpdate = mysqli_query($con,$updatePoints);
            }?>
          </p>
        </div> 
          <!-- no questions to display-->
      <?php if (mysqli_num_rows($ques)==0){?>
      <h6 class="text-center">No questions yet!</h6>  
      <?php } else {
        //FETCH QUESTIONS
      while($question = mysqli_fetch_array($ques)){?>
      <br>
      <div class="card">
      <!-- display question-->
        <div class="card-header">
          <p class="text-center"><?php echo$question['questionText']; ?></p>  
        </div>
        <br>   
        <div class="card-body">  
          <!--display the correct answer and points-->
            <p class="text-center">Correct Answer: <?php echo$question['correctAnswer']; ?></p>
            <p class="text-center">Points: <?php echo$question['points']; ?></p>
        </div>
        <div class="text-center">
          <a href="editques.php?quesID=<?php echo $question['questionID'];?>"><button type="button" class="btn btn-primary btn-sm">Edit</button></a>
          <a href="remove.php?quesID=<?php echo $question['questionID'];?>"><button type="button" class="btn btn-danger btn-sm">Remove</button></a>
        </div><br>
      </div>
      <?php }?>
      <?php }?>          
    </div>
    <!-- button for creting question and adding from the question bank -->
    <div class="mt-2 text-center">
      <div class="d-grid gap-2 d-md-block">
        <a href="createques.php?id=<?php echo $quiz['quizID'];?>"><button class="btn btn-primary" type="button">Create Question</button></a>
        <a href="import.php?id=<?php echo $quiz['quizID'];?>"><button class="btn btn-success" type="button">Import Question</button></a>
      </div>
    </div>
    <br>
        <!-- fields for quiz settings -->
        <div class="mb-3">
            <label for="openDate">Open Date:</label>
            <input type="datetime-local" id="openDate" value="<?php echo $quiz['StartDate'];?>" name="openDate" class="form-control" required>
        </div>
         <div class="mb-3">
            <label for="closeDate">Close Date:</label>
            <input type="datetime-local" id="closeDate" value="<?php echo $quiz['EndDate'];?>" name="closeDate" class="form-control" required>
         </div>
        </form>
   </div>
 </body>
 </html>