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
    //questionID
    if(isset($_GET['quesID'])){
        $quesid = $_GET['quesID'];
    } else{
        $quesid = $_SESSION['quesID'];
    }

    //to access the quiz when the page reloads
    $_SESSION['quesID'] = $quesid;

    //fetch the question details
    $query = "SELECT * FROM question WHERE questionID='$quesid'";
    $result = mysqli_query($con,$query);
    $ques = mysqli_fetch_array($result);

    //update the question
    if(isset($_POST['save'])){
        $qText = mysqli_real_escape_string($con, $_POST['ques']);
        $correct = mysqli_real_escape_string($con, $_POST['correct']);
        $points = $_POST['points'];
        
        $update="UPDATE question SET questionText='$qText', correctAnswer='$correct', points='$points' WHERE questionID='$quesid'";
        $result = mysqli_query($con,$update);
        header('location: editques.php');    
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
 	<title>Edit Question</title>
</head>
<body>
    <br><br>
    <div class="col-md-5 border-right container1">
        <!-- form -->
        <form action="editques.php" method="POST">
            <!-- save and back button -->
        <div class="mt-2 text-center">
            <div class="d-grid gap-2 d-md-block">
                <button type="submit" class="btn btn-info" name="save">Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="location.href='editquiz.php'">Back</button>
            </div>
        </div>
        <div class="p-3 py-5">
            <div class="card">
                <div class="card-body"> 
                    <!-- edit question--> 
                    <textarea class="form-control" id="ques" name="ques" rows="5" required><?php echo$ques['questionText']; ?></textarea>  
                    <!--edit the correct answer-->
                    <p class="text-center">Correct Answer:</p>
                    <input class="form-control form-control-sm" type="text" value="<?php echo$ques['correctAnswer']; ?>" name="correct" required>
                    <p class="text-center">Points:</p>
                    <input class="form-control form-control-sm" type="number" min="1" value="<?php echo$ques['points']; ?>" name="points" required><br>
                </div>
            </div>
        <div>
    </form>
    </div> 
 </body>
 </html>