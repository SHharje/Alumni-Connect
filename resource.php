<?php
session_start();
include 'partials/_dbconnect.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ((!empty($_FILES["myfile"]["name"]) || !empty($_POST["homepage"])) && !empty($_POST["title"]) && !empty($_POST["about-resource"])) {
        
        $r_adder = $_SESSION["id"];
        $r_title = mysqli_real_escape_string($conn, $_POST["title"]);
        $r_about = mysqli_real_escape_string($conn, $_POST["about-resource"]);
        $r_file = null;
        $r_url = null;

        // Handle file upload
        //if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
            // Directory to store uploaded files
          //  $upload_dir = 'uploads/'; // Make sure this directory exists and is writable
            
            // Path to save the uploaded file
            //$r_file = $upload_dir . basename($_FILES['myfile']['name']);
            
        //} else {
          //  $r_file = null; // No file was uploaded
        //}
        

        // Handle URL input
        if (!empty($_POST["homepage"])) {
            $r_url = mysqli_real_escape_string($conn, $_POST["homepage"]);
        }

        // Insert into the database based on what data is available
        if ($r_file && !$r_url) {
            $sql = "INSERT INTO resources (r_adder, r_title, r_file, r_about) VALUES (?, ?, ?, ?)";
        } elseif ($r_url && !$r_file) {
            $sql = "INSERT INTO resources (r_adder, r_title, r_url, r_about) VALUES (?, ?, ?, ?)";
        } elseif ($r_file && $r_url) {
            $sql = "INSERT INTO resources (r_adder, r_title, r_file, r_url, r_about) VALUES (?, ?, ?, ?, ?)";
        }

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            if ($r_file && empty($r_url)) {
                mysqli_stmt_bind_param($stmt, "isss", $r_adder, $r_title, $r_file, $r_about);
            } elseif ($r_url && empty($r_file)) {
                mysqli_stmt_bind_param($stmt, "isss", $r_adder, $r_title, $r_url, $r_about);
            } else {
                mysqli_stmt_bind_param($stmt, "issss", $r_adder, $r_title, $r_file, $r_url, $r_about);
            }

            if (mysqli_stmt_execute($stmt)) {
                echo "Resource added successfully.";
                header("Location: resource.php");
                exit();
            } else {
                echo "Error adding resource: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing SQL statement: " . mysqli_error($conn);
        }
    } else {
        echo "Please fill in all required fields.";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


  </head>
  <body>
    <?php require "partials/_nav.php"?>
        <div class='main_div'>
        <h1>Welcome To Resource Vault, <?php echo $_SESSION['username']; ?>!</h1>
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form><br><br>
        <div class="resource-form">
            <h2>Contribute in the Vault</h2>
            <form action="resource.php" method="post">
                <input type="text" name="title" placeholder="Resource Title" required><br>
                <!--<label for="myfile">Select a file:</label>
                <input type="file" id="myfile" name="myfile"><br><br>-->
                <label for="homepage">Add your resource's url:</label>
                <input type="url" id="urlpage" name="homepage" placeholder="Insert URL"><br><br>
                <label for="about-resource">Description of the resource :</label>
                <textarea name="about-resource" placeholder="About resource" required></textarea><br>
                <button type="submit" class="btn btn-outline-success">Add To Vault</button>
            </form>
        </div>
        <div>
            <h2>Resources</h2>
            <?php
                $resources = mysqli_query($conn,"SELECT r.*, u.username FROM resources r JOIN users u ON r.r_adder = u.id");

                while ($resource = $resources->fetch_assoc()) {
                    echo '<div class="resource">';
                    echo '<h3>' . $resource['r_title'] . '</h3>';

                    echo '<p>'. $resource['r_about'].'</p>';

                    echo '<p><strong>Added by ' . $resource['username'] . '</strong></p>';
                    
                    echo '<p><a href="' .$resource['r_url']. '">' . $resource['r_url'] . '</a></p>';
 
                    echo '<p>' . $resource['r_file'] . '</p>'; 
                    
                    echo '</div>';
                }            
            ?>
        </div>
    </div>
    <style>
        .main_div{
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;   
        }
        body{
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0; 
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;  
        }
        h1,h2{
            color: #555;
        }
        .resource-form{
            margin-bottom: 20px;
        }
        input[type="text"],input[type="url"],textarea{
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>