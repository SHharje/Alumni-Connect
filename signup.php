<?php 
    $showAlert = false;
    $showError = false;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include "partials/_dbconnect.php";
        
        $fusername = $_POST["fusername"];
        $lusername = $_POST["lusername"];
        $username = $fusername . " " . $lusername;
        $mail = $_POST["email"];
        $password = $_POST["password"];
        $type = $_POST["Radio"]; // Student or Alumni
        $phone = $_POST["phone"];
        $city = $_POST["city"];
        
        // Capture job and graduation year if Alumni is selected
        $job = '';
        $graduationYear = '';
        if($type == "Alumni"){
            $job = $_POST["job"];
            $graduationYear = $_POST["graduationYear"];

            // Validate Alumni-specific fields
            if(empty($job)){
                $showError = "Job is required for Alumni.";
                echo '<div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Error</h4>
                        <p>Job field is required for Alumni.</p>
                      </div>';
                exit;
            }
            if(empty($graduationYear)){
                $showError = "Graduation Year is required for Alumni.";
                echo '<div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Error</h4>
                        <p>Graduation Year is required for Alumni.</p>
                      </div>';
                exit;
            }
        }

        // Check if email already exists
        $existSql = "SELECT * FROM `users` WHERE email = '$mail'";
        $result = mysqli_query($conn, $existSql);
        $numRows = mysqli_num_rows($result);
        
        if($numRows > 0){
            $showError = "Email already in use. Please try a different email.";
            echo '<div class="alert alert-danger" role="alert">
                  <h4 class="alert-heading">Error</h4>
                  <p>This email already exists</p>
                  <hr>
                  <p class="mb-0">Try a different email.</p>
                </div>';
        } else {
            // Insert new user with Job and Graduation Year for Alumni
            $sql = "INSERT INTO `users` (`username`, `password`, `type`, `job`, `graduation_year`, `date`, `email`,`phone`,`city`) 
                    VALUES ('$username', '$password', '$type', '$job', '$graduationYear', current_timestamp(), '$mail' , '$phone','$city')";
            
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
            }
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

    <title>Sign Up</title>
    <style>
    </style>
  </head>
  <body>
    <?php require "partials/_nav.php"?>
    <?php if($showAlert): ?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Congratulations</h4>
        <p>You have successfully created an account.</p>
        <hr>
        <p class="mb-0">You can now <strong><a href="login.php" style="color: inherit; text-decoration: none;">Log in</a></strong></p>
    </div>
<?php endif; ?>

    <div class="container">
        <h1 class="text" style="text-align: center;">Sign Up to our website</h1>
   
        <form action="signup.php" method="post" style="display:flex; flex-direction:column; align-items: center;">
    <div class="form-group col-md-6">
        <label for="username">First Name</label>
        <input type="text" class="form-control" id="name1" placeholder="Enter first name" name="fusername">
    </div>
    <div class="form-group col-md-6">
        <label for="username">Last Name</label>
        <input type="text" class="form-control" id="name2" placeholder="Enter last name" name="lusername">
    </div>
    <div class="form-group col-md-6">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-group col-md-6">
        <label for="phone">Phone Number:</label><br>    
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="" pattern="[0-9]{11}"><br>
    </div>
    <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Current City:</label>
        <input type="text" class="form-control" name="city" id="exampleInputPassword1" placeholder="Enter City">
    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="Radio" value="Student" id="studentRadio">
        <label class="form-check-label" for="studentRadio">Student</label><br>
        <input class="form-check-input" type="radio" name="Radio" value="Alumni" id="alumniRadio">
        <label class="form-check-label" for="alumniRadio">Alumni</label><br>
    </div>

    <!-- New fields for Job and Graduation Year -->
    <div class="form-group col-md-6">
        <label for="job">Profession (Only for Alumni)</label>
        <input type="text" class="form-control" id="job" placeholder="Enter your job" name="job">
    </div>
    <div class="form-group col-md-6">
        <label for="graduationYear">Graduation Year (Only for Alumni)</label>
        <input type="number" class="form-control" id="graduationYear" placeholder="Enter your graduation year" name="graduationYear">
    </div>

    <button type="submit" class="btn btn-primary col-md-6">Submit</button>
</form>

</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>