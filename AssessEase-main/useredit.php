<?php 
    require_once "connection.php";
    session_start();
    include('usnavbar.html');
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
    elseif ($_SESSION['accountType'] != "Student"){
        header("Location: edit.php");
    }

    //ID
    $id = $_SESSION['id'];
    $query = "SELECT * FROM users WHERE userID = '$id'";
    $acctype = "SELECT accType FROM users WHERE userID = '$id'";
	$sql = mysqli_query($con,$query);

    //update the form
	if(isset($_POST['edit'])){
		$fname = mysqli_real_escape_string($con, $_POST['fname']);
		$lname = mysqli_real_escape_string($con, $_POST['lname']);
		$school = mysqli_real_escape_string($con, $_POST['school']);

		$updateQuery = "UPDATE users SET firstname='$fname', lastname='$lname', school = '$school'
		WHERE userID ='$id'";
        
        $result = mysqli_query($con,$updateQuery);
        header('location: adminprofile.php');
        
	}
?>
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" type="text/css" rel="stylesheet">
 	<title>Edit Profile</title>
 </head>
 <body>
    <br><br>
    <div class="container1">
        <div class="d-flex justify-content-center">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-right">Profile Settings</h4>
            </div>
            <form action="edit.php" method="POST">
            <?php while($user = mysqli_fetch_array($sql)){ ?>
            <div class="row mt-2">
                <div class="col-md-6"><label class="labels">First Name</label><input type="text" name="fname" class="form-control" value="<?php echo$user['firstname']; ?>"></div>
                <div class="col-md-6"><label class="labels">Last Name</label><input type="text" name="lname" class="form-control" value="<?php echo$user['lastname']; ?>"></div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12"><label class="labels">Email Address</label><input class="form-control" name="email" type="text" value="<?php echo$user['email']; ?>" aria-label="Disabled input example" disabled readonly></div>
                <div class="col-md-12"><label class="labels">School</label><input type="text" class="form-control" name="school" value="<?php echo$user['school']; ?>"></div>
                <div class="col-md-12"><label class="labels">Account Type</label><input class="form-control" name="acctype" type="text" value="<?php echo$user['accountType']; ?>" aria-label="Disabled input example" disabled readonly></div>
                <!-- save and back button -->
                <div class="mt-5 text-center">
                    <div class="d-grid gap-2 d-md-block">
                        <input class="btn btn-primary profile-button" type="submit" value="Save Profile" name="edit">
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                    </div>
                </div>
            </div>
            <?php }?>
            </form>
        </div>
    </div>       
 </body>
 </html>