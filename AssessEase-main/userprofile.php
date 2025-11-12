<?php 
    session_start();
    include('usnavbar.html');
    require_once 'connection.php';
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
    elseif ($_SESSION['accountType'] != "Student"){
        header("Location: adminprofile.php");
    }
    //fetch the user details
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE userID = '$id'";
    $result = mysqli_query($con,$sql);
    $user = mysqli_fetch_array($result);    
?>
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>Account Profile</title>
 </head>
 <body>
    <br><br>
    <div class="container1">
        <div class="d-flex justify-content-center">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Hi, <?php echo$user['firstname']; ?>! </h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">First Name</label><input class="form-control" type="text" value="<?php echo$user['firstname']; ?>" aria-label="Disabled input example" disabled readonly></div>
                    <div class="col-md-6"><label class="labels">Last Name</label><input class="form-control" type="text" value="<?php echo$user['lastname']; ?>" aria-label="Disabled input example" disabled readonly></div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Email Address</label><input class="form-control" type="text" value="<?php echo$user['email']; ?>" aria-label="Disabled input example" disabled readonly></div>
                    <div class="col-md-12"><label class="labels">School</label><input class="form-control" type="text" value="<?php echo$user['school']; ?>" aria-label="Disabled input example" disabled readonly></div>
                    <div class="col-md-12"><label class="labels">Account Type</label><input class="form-control" type="text" value="<?php echo$user['accountType']; ?>" aria-label="Disabled input example" disabled readonly></div>
                    
                    <!-- sve and back button -->
                    <div class="mt-5 text-center">
                        <div class="d-grid gap-2 d-md-block">
                            <button class="btn btn-primary profile-button" type="button" name="edit" onclick="location.href='useredit.php'" >Edit Profile</button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='student.php'">Back</button>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </body>
 </html>