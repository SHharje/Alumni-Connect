<?php
  $login = false;
  $showError = false;
  if ($_SERVER["REQUEST_METHOD"]=="POST"){
    include "partials/_dbconnect.php";
    $email = $_POST["mail"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users where email='$email' AND password= '$password' ";
    $result = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
      $login = true;
      session_start();
      $row = $result->fetch_assoc();
      $username = $row['username'];
      $id = $row['id'];
      $_SESSION['id']=$id;
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      header("Location: welcome.php");
    } else {
      $showError = "Invalid credentials";
      echo '<div class="alert alert-warning" role="alert">
  Invalid Credentials
</div>' ;
    }
  }
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Log In</title>
  </head>
  <body>
    <?php require "partials/_nav.php"?>
    <?php
    if($login){
      echo '<div class="alert alert-success" role="alert">
  You are logged in
</div>';
    }
    ?>
    <h2 style = "text-align:center">Log In</h2>
    <form action="login.php" method="post" style=" display:flex; flex-direction:column;
    align-items: center;">
        <div class="form-group col-md-4">
          <label for="username">Email</label>
          <input type="email" class="form-control" name="mail" placeholder="Enter Email">
        </div>

        <div class="form-group col-md-4">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" name="password" name="password"  placeholder="Password">
        </div>

        <button type="submit" class="btn btn-primary col-md-4">Log In</button>
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>