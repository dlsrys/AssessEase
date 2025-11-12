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
  
	//check if quiz_taken table exist
	$table = "quiz_taken";
	if(!tableExists($con,$table)){
		echo "The table's gone missing! Set the database first!";
		$con->close();
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
 	<title>Quizzes</title>
</head>
<body>
   <br><br>
   <div class="col-md-5 border-right container1" id="profile">
      <h3 class="text-center">Quiz Analytics</h3><br>
      <div class="list-group">
      <?php 
   $counter = 0;
   //Teacher userID
   $userid = $_SESSION['id'];
   //uploaded quizzes of the user
   $sql = "SELECT * FROM upQuiz WHERE userID='$userid'";
   $result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 0) {
    echo '<h6 class="text-center">Lost in the digital realm. Quiz not found!</h6>';
} else {
    while ($upQuiz = mysqli_fetch_array($result)) {
         //id of uploaded quiz
         $quizid = $upQuiz['quizID'];
         //check if in the quiz_taken table
         $sqlTaken = "SELECT * FROM quiz_taken WHERE upQuiz='$quizid'";
         $result2 = mysqli_query($con, $sqlTaken);
         //if the quiz is taken, display the uploaded quiz
         while ($quiz_taken = mysqli_fetch_array($result2)) { 
            $counter++;?>
            
            <a href="quizAnalytics.php?upquiz=<?php echo $upQuiz['upQuiz']; ?>&title=<?php echo $quiz_taken['title'] ?>" class="list-group-item list-group-item-action"><?php echo $quiz_taken['title'] ?></a>
   <?php }
        }
    }
    if($counter == 0){
      echo '<h6 class="text-center">Lost in the digital realm. Quiz not found!</h6>';
    }                         
      ?>
      </div>
      <br>
      <div class="mt-3 text-center">
         <button type="button" class="btn btn-secondary btn-sm" onclick="location.href='index.php'">Back</button>
      </div>
   </div>
</body>
</html>

