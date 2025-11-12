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
  $table = "upQuiz";
  if(!tableExists($con,$table)){
    echo "The table's gone missing! Set the database first!";
      $con->close();
      exit();
    }
  //userid
  $userid = $_SESSION['id'];

  //fetch the uploaded quizzes
  $sql = "SELECT * FROM upQuiz WHERE userID='$userid'";
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
 	<title>Upload Quiz</title>
</head>
<body>
<br><br>
   <div class="col-md-5 border-right container1" id="profile">
    <h3 class="text-center">Quizzes</h3><br>
    <div class="p-3 py-5">
    <table class="table table-hover">
    <?php if(mysqli_num_rows($result)==0){?>
      <br>
      <h6 class="text-center">Zero quizzes uploaded right now!</h6>
      <?php } else { ?>
        <tr>
          <th>Quiz ID</th>
          <th>Quiz Title</th>
          <th>Total Points</th>
          <th>Action</th>
        </tr>
      <?php while($quizUp = mysqli_fetch_array($result)){ ?>
        <tr>
          <td><?php echo $quizUp['quizID']?></td>
          <td><?php echo $quizUp['title']?></td>
          <td><?php echo $quizUp['totalPoints']?></td>
          <td><a href="removeup.php?id=<?php echo $quizUp['upQuiz']?>"><button type="button" class="btn btn-danger btn-sm">Remove</button></a></td>
      <?php }}?>  
      </table>
    </div>
    <div class="mt-3 text-center">
          <button type="button" class="btn btn-secondary" onclick="location.href='quizzes.php'">Back</button>
    </div>
    </div>
 </body>
 </html>