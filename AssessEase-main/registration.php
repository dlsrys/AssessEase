<!-- IF THE USER HAS ALREADY REGISTERED IN, REDIRECT TO DASHBOARD/INDEX.PHP -->
<?php 

	session_start();
	if (isset($_SESSION['user'])) {
		header("Location: login.php");
	}
	// CONNECTION FOR THE DATABASE
	require_once "connection.php";
	
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

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="register.css">

	<title>Registration Form</title>
</head>
<body>
	<!-- THIS IS THE CONTAINER FOR THE REGISTRATION FORM -->
		<div class="container border rounded p-6">
			<!-- LOGO -->
			<div class="d-flex justify-content-center align-items-center">
				<img src="images/Logo.png" width="100" height="60">
			</div><br>
			<!-- PHP FUNCTION TO ONLY ADD VALUES WHEN SUBMIT IS CLICKED -->
			<?php 
				if(isset($_POST["submit"])){
					$firstname = mysqli_real_escape_string($con, $_POST['firstname']);
					$lastname = mysqli_real_escape_string($con, $_POST['lastname']);
					$school = mysqli_real_escape_string($con, $_POST['school']);
					$emailaddress = mysqli_real_escape_string($con, $_POST['emailaddress']);
					$password = mysqli_real_escape_string($con, $_POST['password']);
					$accountType = $_POST['accountType'];

					$passwordHash = password_hash($password, PASSWORD_DEFAULT);

					$errors = array();

					// CHECK IF ALL FIELDS ARE FILLED
					if(empty($firstname) OR empty($lastname) OR empty($school) OR empty($emailaddress) OR empty($password) OR empty($accountType)){
						array_push($errors, "All fields are required");
					}

					// CHECK IF EMAIL FORMAT IS CORRECT
					if (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) {
						array_push($errors, "Email is not a valid email format");
					}

					// CHECK IF PASSWORD IS AT LEAST 8 CHARACTERS LONG
					if (strlen($password)<8) {
						array_push($errors, "Password must be at least 8 characters long");
					}

					// CHECK IF THERE IS AN EXISTING EMAIL ADDRESS
					$sql = "SELECT * FROM users WHERE email = '$emailaddress'";
					$result = mysqli_query($con,$sql);
					$rowCount = mysqli_num_rows($result);

					if ($rowCount>0) {
						array_push($errors, "Email already exist");
					}

					// CHECKING STATEMENT IF THERE ARE ANY ERRORS
					if (count($errors)>0) {
						foreach ($errors as $error) {
							echo "<div class='alert alert-danger'>$error</div>";
						}
					}
					else{
						

						// SQL STATEMENT TO INSERT VALUES TO THE DATABASE
						$sql = "INSERT INTO users(firstname, lastname, school, email, pass, accountType) VALUES(?,?,?,?,?,?)";

						// CHECKING IF THERE ARE ANY ERRORS, IF THERE'S NOT INSERT THE VALUES TO THE DATABASE
						$stmt = mysqli_stmt_init($con);
						$preparestmt = mysqli_stmt_prepare($stmt,$sql);

						if($preparestmt){
							mysqli_stmt_bind_param($stmt,"ssssss",$firstname,$lastname,$school,$emailaddress,$passwordHash,$accountType);
							mysqli_stmt_execute($stmt);
							echo "<div class='alert alert-success'>You are registered successfully</div>";
						}
						else{
							die("Something went wrong");
						}
					}


				}
			 ?>
			<!-- THIS IS TO GROUP THE NEEDED INFORMATION -->
			<form action="registration.php" method="POST">
				<div class="form-group">
					<h4>Ready to join? Register now!!</h4>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="firstname" placeholder="First Name">
				</div>

				<div class="form-group">
					<input type="text" class="form-control" name="lastname" placeholder="Last Name">
				</div>

				<div class="form-group">
					<input type="text" class="form-control" name="school" placeholder="School">
				</div>

				<div class="form-group">
					<input type="text" class="form-control" name="emailaddress" placeholder="Email Address">
				</div>

				<div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>
				<div class="form-group">
					<select class="form-control" name="accountType" id="accountType">
  						<option value='Teacher'>Teacher</option>
  						<option value='Student'>Student</option>
  					</select>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Register" name="submit">
				</div>
			</form>

			<div><p>Already registered? <a href="login.php">Login Here</a></p></div>

		</div>
</body>
</html>