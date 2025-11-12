<?php 
    include('usnavbar.html');
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
    elseif ($_SESSION['accountType'] != "Student"){
        header("Location: index.php");
    }
    require_once 'connection.php';
    // USERID,TAKENID,QUIZID IS IN SESSION VARIABLE
    //userid
    $userid = $_SESSION['id'];
    //check if url has the quiz id
    if(isset($_GET['quizID'])){
        $qid = $_GET['quizID'];
    } else{
        $qid = $_SESSION['quizID'];
    }
    //set for reloading
    $_SESSION['quizID'] = $qid;
    //check if url has the quiz_taken id
    if(isset($_GET['takenID'])){
        $takenID = $_GET['takenID'];
    } else{
        $takenID = $_SESSION['takenID'];
    }
    //set for reloading
    $_SESSION['takenID'] = $takenID;
    //check if url has the upquiz id
    if(isset($_GET['upid'])){
        $upid = $_GET['upid'];
    } else{
        $upid = $_SESSION['upid'];
    }
    //for reloading
    $_SESSION['upid'] = $upid;
    //fetch the quiz details
    $sql = "SELECT * FROM quiz WHERE quizID ='$qid'";
    $result = mysqli_query($con,$sql);
    $quiz = mysqli_fetch_array($result);

    $title = $quiz['title'];
   
    //timestamp
    $currentDateTime = date('Y-m-d H:i:s');

    //fetch questions
    $sqlQ = "SELECT * FROM unansQues WHERE quizID = '$qid' ORDER BY rand()";
    $resultq = mysqli_query($con,$sqlQ);

    //count question
    $sqlcount = "SELECT COUNT(tempID) FROM unansQues WHERE quizID = '$qid'";
    $resultcount = mysqli_query($con,$sqlcount);
   
    //variable for score and feedback
    $currentScore = $_SESSION['score'];
    $currentFeedback = $_SESSION['feedback'];

    //update every reload of this page
    $sqlSF = "UPDATE quiz_taken SET totalScore = '$currentScore', feedback='$currentFeedback' WHERE takenID = '$takenID'";
    $updateSF = mysqli_query($con,$sqlSF);
    
   ?>
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  	<link href="style.css" type="text/css" rel="stylesheet">
 	<title>Quiz</title>
 </head>
 <body>
    <br><br>
    <div class="col-md-5 border-right container1">
    <!-- title -->
    <h1 class="display-6 text-center"><?php echo $title?></h1>
            <label>Instructions:</label>
            <div class="card">
                <div class="card-body"><?php echo $quiz['descri']?>
                </div><br>
            </div>
            <br><br>
            <div class="mb-3">
                <ul class="list-group">
                    <?php
                    //questions already answered
                    if (mysqli_num_rows($resultq)==0){?>
                        <p class="h6">Looks like we've pondered all the questions! Let's unveil those results now.</p>
                    <?php } else {?>
                    <div class="mt-2 text-center">
                        Questions: <?php
                        //count
                        while($count = mysqli_fetch_array($resultcount)){
                        echo $count[0];
                        }?>
                    </div>                  
                    <?php 
                    //while loop to fetch the temp questions holder
                    while($unques = mysqli_fetch_array($resultq)){
                    ?>
                    <hr class="hr hr-blurry"/>
                    <p><small>Points: <?php echo $unques['points']?></small></p>
                    <li class="list-group-item"><?php echo $unques['questionText']?></li>         
                    <!-- answer button -->
                    <div class="mt-2 text-center">
                    <a href="answer.php?quesID=<?php echo $unques['questionID'];?>&upid=<?php echo $upid?>">
                    <button type="button" class="btn btn-outline-primary btn-sm">Input Answer</button></a>
                    </div>
                    <?php
                    }}?>
                </ul>
            </div>
        </div>
        <div class="mt-3 text-center">
        <a href="result.php"><button type="button" class="btn btn-success">End Quiz</button></a>
        </div>
    </div>
    
    <br><br>
</body>
</html>