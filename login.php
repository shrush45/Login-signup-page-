<?php
$login = false ;
$showError = false ; 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    
$sql = "Select * from user where username = '$username'";
// Debugging: Print the SQL query
#echo $sql;
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

if ($num == 1){
    while($row = mysqli_fetch_assoc($result)){
      if (password_verify($password, $row['password'])){
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username; 
        header("location: welcome.php");
      }  
      else{
        $showError = "Invalid Credentials";
      }
    }
  }   
  else{
    $showError = "Invalid Credentials";
  }
}  
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
    <div class="row justify-content-right">
    <div class="md-3">
    <?php
    if ($login){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in!!
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
    </div>
    <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">Login</h2>
    <form action="" method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Enter your Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
    </div> 
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name= "password" placeholder="Enter Password" >
        
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label><br><br>
    <span class="psw">Don't have an account? <a href="/loginsys/signup.php">Register Here</a></span><br>
    <span class="psw">Forgot <a href="#">password?</a></span>
    
    </form>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
  </body>
</html>