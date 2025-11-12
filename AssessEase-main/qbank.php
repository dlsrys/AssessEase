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
  $table = "qbank";
  if(!tableExists($con,$table)){
    echo "The table's gone missing! Set the database first!";
      $con->close();
      exit();
  }

  //session variable for user id
  $userID = $_SESSION['id'];

  //fetch questions in the bank
  $query = "SELECT * FROM qbank WHERE userID='$userID'";
  $qresult = mysqli_query($con,$query);

  
?>

<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="style.css" type="text/css" rel="stylesheet">
 	  <title>Question Bank</title>
</head>
<body>
  <br><br>
  <h3 class="text-center">Question Bank</h3><br>
  <div class="col-md-5 border-right container1">
  <?php
      //insert question
      if(isset($_POST['add'])){
        $ques = mysqli_real_escape_string($con, $_POST['ques']);
        $correctAns = strtolower($_POST['correctAns']);
        $points = $_POST['points'];
      
        $insert = "INSERT INTO qbank(userID,questionText,correctAnswer,points) VALUES ('$userID','$ques','$correctAns','$points')";
      
        if (mysqli_query($con, $insert)) {      
          echo "<div class='alert alert-success'>Question added successfully</div>";
          header('location: qbank.php');        
          }
        }
        //count of questions
        $counts = "SELECT COUNT(qbankID) FROM qbank WHERE userID = '$userID'";
        $result = mysqli_query($con,$counts);
      ?>
    <form action="qbank.php" method="POST">
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
        <div class="d-grid gap-2 d-md-block">
          <button type="submit" class="btn btn-info" name="add">Add Question</button>
          <button type="button" class="btn btn-secondary" onclick="location.href='index.php'">Back</button>
        </div>
      </div>
    </form>
    <?php if(mysqli_num_rows($qresult)==0){?>
      <br>
      <h6 class="text-center">Zero questions in the bank right now!</h6>
      <?php } else { ?>
    <!--question count-->
    <div class="mt-3 text-center">
        <p class="text-center">Question Count:
          <?php
          //count
          while($count = mysqli_fetch_array($result)){
          echo $count[0];
          }?>
          </p>
    </div>   
      <table class="table table-hover table-sm">
        <tr>
          <th>Questions</th>
          <th>Answer</th>
          <th>Points</th>
          <th>Action</th>
        </tr>
      <?php while($qbank = mysqli_fetch_array($qresult)){ ?>
        <tr>
          <td><?php echo $qbank['questionText']?></td>
          <td><?php echo $qbank['correctAnswer']?></td>
          <td><?php echo $qbank['points']?></td>
          <td><a href="remqbank.php?id=<?php echo $qbank['qbankID'];?>"><button type="button" class="btn btn-danger btn-sm">Remove</button></a></td>
        </tr>
      <?php }}?>  
      </table>
  </div>
  <br><br><br>
</body>
</html>