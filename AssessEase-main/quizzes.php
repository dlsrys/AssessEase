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
   
   // to check if table exist
   function tableExists($con, $table_name) {
      $sql = "SHOW TABLES LIKE '$table_name'";
      $result = $con->query($sql);
      return $result->num_rows > 0;
   }

   //check if table exist
   $table = "quiz";
   if(!tableExists($con,$table)){
      echo "The table's gone missing! Set the database first!";
       $con->close();
       exit();
   }

   //fetch the quizzes that the user owns
   $userID = $_SESSION['id'];
   $sql = "SELECT * FROM quiz WHERE userID = '$userID'";
   $result = mysqli_query($con,$sql);
?>
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <link href="style.css" type="text/css" rel="stylesheet">
 	<title>Quizzes</title>
</head>
<body>
   <br><br>
   <div class="col-md-5 border-right container1" id="profile">
      <h3 class="text-center">Quizzes</h3><br>
      <div class="row mt-2">   
         <button type="button" class="btn btn-info" onclick="location.href='createquiz.php';">Create a Quiz</button>
      </div>
      <div class="row mt-2">   
         <button type="button" class="btn btn-info" onclick="location.href='uploadedQuiz.php';">View Uploaded Quiz</button>
      </div>
      <br><br>
      <div class="mt-3 text-center">
          <button type="button" class="btn btn-secondary" onclick="location.href='index.php'">Back</button>
        </div>
      <hr class="hr hr-blurry" />
      <!--fetch the quizzes from the database-->
      <h4 class="text-center">List of Quizzes</h4>         
         <!-- if the database table is empty-->
         <?php if(mysqli_num_rows($result)==0){?>
      <br>
      <h6 class="text-center">No quizzes to show</h6>
         <?php 
         //display the list of quiz
         } else {?>   
      <table class="table table-hover">
        <tr>
            <th>Quiz Title</th>
            <th>Total Points</th>
            <th>Action</th>
        </tr>
         <?php   while($quiz = mysqli_fetch_array($result)){ ?>
         <tr>
            <!-- details of quiz -->
            <td><a href="editquiz.php?id=<?php echo $quiz['quizID'];?>" class="list-group-item list-group-item-action"><?php echo $quiz['title']; ?></a></td>
            <td><?php echo $quiz['totalPoints']?></td>
            <td>
               <!-- option to edit -->
               <a href="editquiz.php?id=<?php echo $quiz['quizID'];?>"><button type="button" class="btn btn-success btn-sm">Edit</button></a>
               <!-- option to upload quiz -->
               <a href="upload.php?id=<?php echo $quiz['quizID'];?>&title=<?php echo $quiz['title']?>&tot=<?php echo $quiz['totalPoints'];?>"><button type="submit" class="btn btn-primary btn-sm" name='upload'>Upload</button></a>
               <!-- option to remove quiz -->
               <a href="remquiz.php?id=<?php echo $quiz['quizID'];?>"><button type="button" class="btn btn-danger btn-sm">Remove</button></a>
            </td>
        </tr>
      <?php     
      }
         }?>
      </table>
   </div>
</body>
</html>