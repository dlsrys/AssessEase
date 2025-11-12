<?php 

	session_start();
    if (!isset($_SESSION['user'])) {
		header("Location: login.php");
	}
    elseif ($_SESSION['accountType'] != "Teacher"){
        header("Location: student.php");
    }
    require_once "connection.php";
    include('adnavbar.html');
    
 ?>
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="style.css" type="text/css" rel="stylesheet">
 	<title>AssessEase Teacher</title>
 </head>
 <body>
    <br><br><br><br>
    <!-- tiles -->
    <div class="container px-4">
        <div class="row gx-5">
            <div class="col-sm-6 d-flex justify-content-center" style="width: 20rem;">
                <!-- Profile-->
                <div class="card mx-auto" style="width: 180px" id="card" onclick="location.href='adminprofile.php';"> 
                    <img src= "images/profile.png" class="card-img-top"> 
                    <div class="card-body text-center"> 
                        <h6 class="card-title">Profile</h6> 
                    </div>
                </div>
            </div>
            <div class="col-sm-6 d-flex justify-content-center" style="width: 20rem;">
                <!-- quizzes -->
                <div class="card mx-auto" style="width: 180px" id="card" onclick="location.href='quizzes.php';"> 
                    <img src= "images/quizzes.png" class="card-img-top"> 
                    <div class="card-body text-center"> 
                        <h6 class="card-title">Quizzes</h6> 
                    </div>
                </div>
            </div>
            <div class="col-sm-6 d-flex justify-content-center" style="width: 20rem;">
                <!-- question bank -->
                <div class="card mx-auto" style="width: 180px" id="card" onclick="location.href='qbank.php';"> 
                    <img src= "images/qb.png" class="card-img-top"> 
                    <div class="card-body text-center"> 
                        <h6 class="card-title">Question Bank</h6> 
                    </div>
                </div>
            </div>
            <div class="col-sm-6 d-flex justify-content-center" style="width: 20rem;">
                <!-- analytics -->
                <div class="card mx-auto" style="width: 180px" id="card" onclick="location.href='analytics.php';"> 
                    <img src= "images/analytics.png" class="card-img-top"> 
                    <div class="card-body"> 
                        <h6 class="card-title">Analytics</h6> 
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br><br>
        <figure class="text-center">
            <blockquote class="blockquote">
                <p>The future belongs to those who believe in the beauty of their dreams.</p>
            </blockquote>
            <figcaption class="blockquote-footer">
            Eleanor Roosevelt
            </figcaption>
        </figure>
</body>
</html>