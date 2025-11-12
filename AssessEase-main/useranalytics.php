<?php 
	session_start();
	if (!isset($_SESSION['user'])) {
		header("Location: login.php");
	}
	elseif ($_SESSION['accountType'] != "Student"){
        header("Location: index.php");
    }
	require_once "connection.php";
    include('usnavbar.html');
	
	//userID
	$user = $_SESSION['id'];

	//fetch quiz taken by user
	$sql = "SELECT * FROM quiz_taken WHERE userID = '$user'";
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
 	<title>Analytics</title>
 </head>
 <body>
 	<br><br>
   <div class="col-md-5 border-right container1">
   <?php 
   echo '<table class="table table-hover">
      <tr>
         <th>No.</th>
         <th>Quiz</th>
         <th>Score</th>
         <th>Feedback</th>
      </tr>';
		$counter = 0;
	  while($quizTaken = mysqli_fetch_array($result)){
		$counter++;
		echo '<tr>
                  <td>' . $counter . '</td>
                  <td>' . $quizTaken['title'] . '</td>
                  <td>' . $quizTaken['totalScore'] . '</td>
                  <td>' . $quizTaken['feedback'] . '</td>
               </tr>';
         echo '</table>';
	  }
	  ?>
</div>

 </body>
 </html>