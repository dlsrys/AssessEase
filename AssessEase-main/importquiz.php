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
    //session variable for user id
    $userID = $_SESSION['id'];

    //for realoading the page
    $_SESSION['quizid'] = $qid;

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
 	<title>Import Questions</title>
</head>
<body>
   <br><br>
   <h3 class="text-center">Import from Question Bank</h3><br>
    <div class="col-md-5 border-right container1">
        <?php if(mysqli_num_rows($qresult)==0){?>
        <br>
        <h6 class="text-center">Zero questions in the bank right now!</h6>
        <?php } else { ?>   
        <table class="table table-hover">
            <tr>
                <th>Questions</th>
                <th>Answer</th>
                <th>Points</th>
                <th>Action</th>
            </tr>
        <?php while($qbank = mysqli_fetch_array($qresult)){
                ?>
            <tr>
                <td><?php echo $qbank['questionText']?></td>
                <td><?php echo $qbank['correctAnswer']?></td>
                <td><?php echo $qbank['points']?></td>
                <td><a href="import2quiz.php?qbankid=<?php echo $qbank['qbankID'];?>&quizid=<?php echo $qid?>"><button type="button" class="btn btn-primary btn-sm" name="add">Add</button></a></td>
            </tr>
            <?php }}?>  
        </table>
        <div class="mt-3 text-center">
          <button type="button" class="btn btn-secondary" onclick="location.href='quiz.php'">Back</button>
        </div>
    </div>
 </body>
 </html>