<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
  $loggedin=true;
}else{
  $loggedin = false;
}
echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Alumni Connect</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';
      if(!$loggedin){
        echo '<li class="nav-item">
        <a class="nav-link" href="signup.php">SignUp</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="login.php">LogIn</a>
      </li>';

      }
      
      if ($loggedin){
        echo '
        <li class="nav-item active">
        <a class="nav-link" href="welcome.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="profile.php">My Profile <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
      </li>
      
        <li class="nav-item">
        <a class="nav-link" href="logout.php">LogOut</a>
        </li>';
      }
      
   
    echo '</ul>
   
  </div>
</nav>'
?>