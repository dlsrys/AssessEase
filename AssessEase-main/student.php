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
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="style.css" type="text/css" rel="stylesheet">
	<title>AssessEase Student</title>
</head>
<body>
<br><br><br><br>
    <!-- tiles -->
    <div class="container px-4">
        <div class="row gx-5 justify-content-center">
            <div class="col-sm-6 d-flex justify-content-center" style="width: 20rem;">
                <!-- Profile-->
                <div class="card mx-auto" style="width: 180px" id="cardst" onclick="location.href='userprofile.php';"> 
                    <img src= "images/profile.png" class="card-img-top"> 
                    <div class="card-body text-center"> 
                        <h6 class="card-title">Profile</h6> 
                    </div>
                </div>
            </div>
            <div class="col-sm-6 d-flex justify-content-center" style="width: 20rem;">
                <!-- quizzes -->
                <div class="card mx-auto" style="width: 180px" id="cardst" onclick="location.href='takequiz.php';"> 
                    <img src= "images/quizzes.png" class="card-img-top"> 
                    <div class="card-body"> 
                        <h6 class="card-title text-center">Take a Quiz</h6> 
                    </div>
                </div>
            </div>
            <div class="col-sm-6 d-flex justify-content-center" style="width: 20rem;">
                <!-- quizzes -->
                <div class="card mx-auto" style="width: 180px" id="cardst" onclick="location.href='useranalytics.php';"> 
                    <img src= "images/analytics.png" class="card-img-top"> 
                    <div class="card-body"> 
                        <h6 class="card-title text-center">Analytics</h6> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br>
    <figure class="text-center">
            <blockquote class="blockquote">
                <p>The road to success and the road to failure are almost exactly the same.</p>
            </blockquote>
            <figcaption class="blockquote-footer">
            Colin R. Davis
            </figcaption>
        </figure>
</body>
</html>