<?php
    session_start();
    include 'partials/_dbconnect.php';
    $user_id = $_SESSION['id'];

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $update_name=$_POST['update_name'];
        $update_email=$_POST['update_email'];
        $update_phone=$_POST['update_phone'];
        $update_city=$_POST['update_city'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];

        $select = mysqli_query($conn, "SELECT * FROM `users` WHERE id='$user_id'") or die('query failed');
        
        if(mysqli_num_rows($select)>0){
            $fetch = mysqli_fetch_assoc($select);
            $db_password = $fetch['password'];
            if($fetch['type']=="Alumni"){
                $update_job=$_POST['update_job'];
            }else{
                $update_job='';
            }
            if ($old_password==$db_password){
                mysqli_query($conn, "UPDATE `users` SET username = '$update_name', email = '$update_email', phone='$update_phone' ,city='$update_city', job='$update_job'  WHERE id = '$user_id'") or die('query failed');

                $_SESSION['username'] = $update_name;
                $_SESSION['email'] = $update_email;

                if(!empty($new_password)){
                    mysqli_query($conn, "UPDATE `users` SET password = '$new_password' WHERE id = '$user_id'") or die('query failed');    
                }

            }else{
                echo '<div class="alert alert-danger" role="alert">
                Old Password deosnot match!
              </div>';
            }

        }
    
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.update_profile {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.update_profile h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333333;
}

.inputBox {
    margin-bottom: 15px;
}

.inputBox input[type="text"],
.inputBox input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.inputBox input[type="text"]:focus,
.inputBox input[type="password"]:focus {
    border-color: #80bdff;
    outline: none;
}

.btn {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
    color: #ffffff;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-danger {
    background-color: #dc3545;
    color: #ffffff;
}

.btn-danger:hover {
    background-color: #c82333;
}

.alert {
    margin-top: 20px;
    padding: 10px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}


    </style>

</head>
<body>
<?php require "partials/_nav.php"?>
    <?php
            $select = mysqli_query($conn, "SELECT * FROM `users` WHERE id='$user_id'") or die('query failed');

            if(mysqli_num_rows($select) > 0){
                $fetch = mysqli_fetch_assoc($select);
            }           

            //for image

    ?>
    <div class="update_profile">


        <form action="update_profile.php" method="post" >
            <div class="flex">
                <div class="inputBox">
                    Username:
                    <input type="text" name="update_name" value="<?php echo $fetch['username']?>"><br>
                    Email:
                    <input type="text" name="update_email" value="<?php echo $fetch['email']?>"><br>
                    Phone:
                    <input type="text" name="update_phone" value="<?php echo $fetch['phone']?>"><br>
                    City:
                    <input type="text" name="update_city" value="<?php echo $fetch['city']?>"><br>
                    <?php if ($fetch['type'] == "Alumni"): ?>
                    <!-- Additional fields for Alumni -->
                    Job:
                    <input type="text" name="update_job" value="<?php echo $fetch['job']?>"><br>
                    <?php endif; ?>

                    Current Password:
                    <input type="password" name="old_password" value="" placeholder="Please fill this always" required><br>
                    New Password:
                    <input type="password" name="new_password" value="" placeholder="Only if you want to change password"><br>

                </div>
            </div>
            <input type="submit" value="update profile" name="update_profile" class="btn btn-primary"><br>
            <a href="profile.php" type="submit" class="btn btn-danger">My Profile</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>