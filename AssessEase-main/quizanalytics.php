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

   //upQuiz
   $upquiz = $_GET['upquiz'];
   $title = $_GET['title'];

   //fetch the quiz details
   $sql = "SELECT * FROM quiz_taken WHERE upQuiz ='$upquiz'";
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
 	<title>Quiz Analytics</title>
</head>
<body>
   <br><br>
   <h4 class="text-center"><?php echo $title ?></h4><br>
   <div class="col-md-5 border-right container1">
   <?php 
   echo '<table class="table table-hover">
      <tr>
         <th>No.</th>
         <th>Student</th>
         <th>Score</th>
         <th>Feedback</th>
      </tr>';
      $counter = 0;
      while ($taken = mysqli_fetch_array($result)) {
         $counter++;
         //userID to fetch student name
         $studID = $taken['userID'];
         //access the users table
         $sqluser = "SELECT * FROM users WHERE userID = '$studID'";
         $resultUser = mysqli_query($con,$sqluser);
         $student = mysqli_fetch_array($resultUser);

         echo '<tr>
                  <td>' . $counter . '</td>
                  <td>' . $student['firstname'] . " " . $student['lastname'] . '</td>
                  <td>' . $taken['totalScore'] . '</td>
                  <td>' . $taken['feedback'] . '</td>
               </tr>';
         echo '</table>';
      }
   ?>
   <br>
      <div class="mt-3 text-center">
         <button type="button" class="btn btn-secondary btn-sm" onclick="location.href='analytics.php'">Back</button>
      </div>
   </div>  
 </body>
 </html>

 