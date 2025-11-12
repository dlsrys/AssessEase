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
	
	// to check if table exist
    function tableExists($con, $table_name) {
		$sql = "SHOW TABLES LIKE '$table_name'";
		$result = $con->query($sql);
		return $result->num_rows > 0;
	}
    
	//check if uploaded quiz table exist
	$table = "upQuiz";
	if(!tableExists($con,$table)){
		echo "The table's gone missing! Set the database first!";
		$con->close();
		exit();
	}
	//check if quiz table exist
	$table1 = "quiz";
	if(!tableExists($con,$table1)){
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
 	<title></title>
 </head>
 <body>
	<br><br>
 <h4 class="text-center">Search Quiz</h4>
	<div class="col-md-5 border-right container1">
		<form class="d-flex" action="takequiz.php" method="POST">
    		<input class="form-control me-2" type="search" placeholder="Enter Quiz ID" name="quizid">
    		<button class="btn btn-outline-primary" type="submit" name="search">Search</button>
		</form>
<hr class="hr hr-blurry"/>

<?php
if (isset($_POST['search'])) {
    $quizid = $_POST['quizid'];

    $sql = "SELECT * FROM upQuiz WHERE quizID='$quizid'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo '<h6 class="text-center">Quiz lost in the digital realm.</h6>';
    } else {
        $upQuiz = mysqli_fetch_array($result);
        $upid = $upQuiz['upQuiz'];
        // Display quiz details
        echo '<table class="table table-hover table-sm">
                <tr>
                    <th>Quiz Title</th>
                    <th>Instructor</th>
                    <th>Open Date</th>
                    <th>Close Date</th>
                    <th>Total Points</th>
                    <th>Action</th>
                </tr>';

        // Fetch quiz details
        $sqlquiz = "SELECT * FROM quiz WHERE quizID = '$quizid'";
        $resultquiz = mysqli_query($con, $sqlquiz);

        while ($quiz = mysqli_fetch_array($resultquiz)) {
            $insID = $quiz['userID'];
            $title = $quiz['title'];

            // Fetch instructor details
            $sqlIns = "SELECT * FROM users WHERE userID = $insID";
            $resultIns = mysqli_query($con, $sqlIns);
            $ins = mysqli_fetch_array($resultIns);

            $now = time(); // Get the current timestamp
            $openDate = strtotime($quiz['StartDate']);
            $closeDate = strtotime($quiz['EndDate']);

            // Check if the user has already taken the quiz
            $userID = $_SESSION['id'];
            $sqlTaken = "SELECT * FROM quiz_taken WHERE userID = '$userID' AND upQuiz = '$upid'";
            $resultTaken = mysqli_query($con, $sqlTaken);

            echo '<tr>
                    <td>' .  $title . '</td>
                    <td>' . $ins['firstname'] . ' ' . $ins['lastname'] . '</td>
                    <td>' . $quiz['StartDate'] . '</td>
                    <td>' . $quiz['EndDate'] .'</td>
                    <td>' . $quiz['totalPoints'] . '</td>
                    <td>';

                    if ($now >= $openDate && $now <= $closeDate) {
                        if (mysqli_num_rows($resultTaken) == 0) {
                            // Fetch questions for the quiz
                            $sqlQ = "SELECT * FROM question WHERE quizID = '$quizid'";
                            $resultq = mysqli_query($con, $sqlQ);
                        
                            // Iterate through each question and store them in unansQues table
                            while ($ques = mysqli_fetch_array($resultq)) {
                                $quesID = $ques['questionID'];
                                $text = mysqli_real_escape_string($con, $ques['questionText']);
                                $ans = $ques['correctAnswer'];
                                $points = $ques['points'];
                        
                                // Insert questions into unansQues table
                                $insertQues = "INSERT INTO unansQues(quizID, questionText, correctAnswer, points, questionID) VALUES ('$quizid', '$text', '$ans', '$points', '$quesID')";
                                $insertquery = mysqli_query($con, $insertQues);
                            }
                        
                            // Create a new entry in quiz_taken to prevent retaking
                            $currentTimestamp = date('Y-m-d H:i:s');
                            $takenquiz = "INSERT INTO quiz_taken (userID, upQuiz, takenDate, title, totalScore, feedback) VALUES ('$userID', '$upid', '$currentTimestamp', '$title', '0', 'Fail')";
                            $querytaken = mysqli_query($con, $takenquiz);
                            $takenID = mysqli_insert_id($con);
                        
                            // Set initial score & feedback in session
                            $_SESSION['score'] = 0;
                            $_SESSION['feedback'] = 'fail';
                        
                            // Display the 'Take' button if the quiz is open and not taken
                            echo '<a href="quiz_access.php?quizID=' . $quizid . '&upid=' . $upid . '&takenID=' . $takenID . '" class="btn btn-success btn-sm">Take</a>';
                        }
                        else {
                            // Quiz is open, but the user has already taken it, display a disabled 'Taken' button or a message
                            echo '<button type="button" class="btn btn-secondary btn-sm" disabled>Taken</button>';
                        }
                    } 
                    else {
                    // Quiz is closed or not yet open, display a disabled button or message
                    echo '<button type="button" class="btn btn-secondary btn-sm" disabled>Closed</button>';
                    }
                    

            echo '</td></tr>';
        }

        echo '</table>';
    }
}
?>

	</div>	
 </body>
 </html>