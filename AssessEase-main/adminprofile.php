<?php 
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
    elseif ($_SESSION['accountType'] != "Teacher"){
        header("Location: userprofile.php");
    }
    include('adnavbar.html');
    require_once 'connection.php';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
     integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
                    <div class="col-md-6"><label class="labels">First Name</label><input class="form-control" type="text" value="<?php echo$user['firstname']; ?>" disabled readonly></div>
                    <div class="col-md-6"><label class="labels">Last Name</label><input class="form-control" type="text" value="<?php echo$user['lastname']; ?>" disabled readonly></div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Email Address</label><input class="form-control" type="text" value="<?php echo$user['email']; ?>" disabled readonly></div>
                    <div class="col-md-12"><label class="labels">School</label><input class="form-control" type="text" value="<?php echo$user['school']; ?>" disabled readonly></div>
                    <div class="col-md-12"><label class="labels">Account Type</label><input class="form-control" type="text" value="<?php echo$user['accountType']; ?>" disabled readonly></div>

                    <div class="mt-5 text-center">
                        <div class="d-grid gap-2 d-md-block">
                            <button class="btn btn-primary profile-button" type="button" name="edit" onclick="location.href='edit.php'" >Edit Profile</button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='index.php'">Back</button>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
 </body>
 </html>