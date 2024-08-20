<?php
$showAlert = false ;
$showError = false ; 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Check if username already exists
    $check_user_query = "SELECT * FROM `user` WHERE `username`='$username'";
    $result = mysqli_query($conn, $check_user_query);
    if(mysqli_num_rows($result) > 0){
        #$exists = true;
        $showError = " Username already exists";
    }
    else{
        #$exists = false;
        if(($password == $cpassword)){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`username`, `password`, `date`) VALUES ('$username', '$hash', current_timestamp())";
            // Debugging: Print the SQL query
            #echo $sql;
            if (mysqli_query($conn, $sql)){
                $showAlert = true;
            }   
            else{
                $showError = "Error: " . mysqli_error($conn);
            }
        }
        else{
        $showError = " Passwords do not match";
        }
    }
}
    
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    if ($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your account is now created!!! <a href="/loginsys/login.php">You can login now.</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    if ($showError){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>'. $showError. '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    <div class="container my-4">
    <h2 class="text-center"> Sign-Up to our website</h2>
    <form action="" method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" maxlength = "20" class="form-control" id="username" name="username" placeholder="Enter Username">
    </div> 
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" maxlength = "10" class="form-control" id="password" name= "password" placeholder="Enter Password" >
    </div>
    <div class="mb-3">
        <label for="cpassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter the same password" >
        <div id="emailHelp" class="form-text">Make sure to type the same password.</div>
    </div>
    <button type="submit" class="btn btn-primary">Signup</button><br>
    <div class="mb-4">Already have an account? <a href="/loginsys/login.php">Login here</a></div>
    </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>