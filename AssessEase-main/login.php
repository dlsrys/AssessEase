<!-- IF THE USER HAS ALREADY LOGGED IN, REDIRECT TO DASHBOARD/INDEX.PHP -->
<?php 

	session_start();
	if (isset($_SESSION['user'])) {
		if ($_SESSION['accountType'] == "Teacher") {
			header("Location: index.php");
		}
		if ($_SESSION['accountType'] == "Student") {
			header("Location: student.php");
		}
	}
	
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="register.css">
	<title>AssessEase</title>
</head>
<body>
	<!-- THIS IS TO GROUP THE NEEDED INFORMATION -->
		<div class="container border rounded p-6">
			<!-- LOGO -->
			<div class="d-flex justify-content-center align-items-center">
				<img src="images/Logo.png" width="110" height="70">
			</div><br>
			<!-- CHECK IF THE EMAIL AND PASSWORD EXIST IN THE DATABASE -->
			<?php
			if (isset($_POST["login"])) {
				$emailaddress = $_POST['email'];
				$password = $_POST['password'];
				$accountType = $_POST['accountType'];

				require_once"connection.php";

				// to check if table exist
				function tableExists($con, $table_name) {
					$sql = "SHOW TABLES LIKE '$table_name'";
					$result = $con->query($sql);
					return $result->num_rows > 0;
				}

				//check if table exist
				$userTable = "users";
				if(!tableExists($con,$userTable)){
					echo "The table's gone missing! Set the database first!";
    				$con->close();
    				exit();
				}

				// SQL STATEMENT FOR EMAIL AND PASSWORD
				$sql = "SELECT * FROM users WHERE email = '$emailaddress'";
				$result = mysqli_query($con,$sql);
				$user = mysqli_fetch_array($result, MYSQLI_ASSOC);

				//check if empty
				if(empty($user)) {
    				echo"<div class='alert alert-danger'>Email does not exist</div>"; }

				else{//variable for user id number
					$_SESSION['id'] = $user['userID'];

					// PASSWORD DECRYPTION AND CHECKING IF THE ACCOUNT IS TEACHER OR STUDENT
					if ($user) {
						if (password_verify($password, $user["pass"]) AND $accountType == $user["accountType"] AND $user["accountType"] == "Teacher") {
							session_start();
							$_SESSION['user'] = "yes";
							$_SESSION['accountType'] = "Teacher";
							header("Location: index.php");
							die();
						}
						if (password_verify($password, $user["pass"]) AND $accountType == $user["accountType"] AND $user["accountType"] == "Student") {
						session_start();
							$_SESSION['user'] = "yes";
							$_SESSION['accountType'] = "Student";
							header("Location: student.php");
							die();
						}
						else{
							echo"<div class='alert alert-danger'>Password does not match</div>";
						}
					}
					else{
						echo"<div class='alert alert-danger'>Email does not match</div>";
					}
				}
			}
			?>
			<form action="login.php" method="POST">
				<div class="form-group">
					<h4>Welcome Back!</h4>
					<p class="text-muted">Log in and let the journey continue!</p>
				</div>
				<!-- EMAIL FIELD -->
				<div class="form-group">
					<input type="email" placeholder="Enter email" name="email" class="form-control">
				</div>

				<!-- PASSWORD FIELD -->
				<div class="form-group">
					<input type="password" placeholder="Enter password" name="password" class="form-control">
				</div>

				<!-- SELECTION IF STUDENT OR TEACHER -->
				<div class="form-group">
					<select class="form-control" name="accountType" id="accountType">
  						<option value='Teacher'>Teacher</option>
  						<option value='Student'>Student</option>
  					</select>
				</div>

				<!-- FORM BUTTON -->
				<div class="form-btn">
					<input type="submit" value="Login" name="login" class="btn btn-primary">
				</div>
			</form>
			<br>
			<div><p>Not registered yet? <a href="registration.php">Register Here</a></p></div>

		</div>
</body>
</html>