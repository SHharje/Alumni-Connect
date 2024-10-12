<?php
session_start();
include 'partials/_dbconnect.php';
$user_id = $_SESSION['id'];

if (!isset($user_id)) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Profile page</title>
    <style>
        .container {
            min-height: 100vh;
            background-color: var(--light-bg);
            display: flex;
            align-items: flex-start; /* Align items at the top */
            justify-content: center;
            padding: 20px;
            padding-top: 50px; /* Adjust padding to control how high the container starts */
        }

        .container .profile {
            padding: 20px;
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            text-align: left; /* Align text to the left */
            width: 600px; /* Increase width for better layout */
            border-radius: 5px;
        }

        .container .profile img {
            height: 150px;
            width: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 5px;
        }

        .container .profile h3 {
            font-size: 24px; /* Increase the font size for the name */
            margin-bottom: 15px;
        }

        .container .profile a {
            width: 100%; /* Ensure buttons have the same size */
            padding: 10px 0; /* Adjust padding to make buttons appear larger */
            font-size: 16px;
            margin-top: 10px; /* Add a bit of margin between the buttons */
        }

        .event-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .event-table th, .event-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left; /* Align text to the left */
        }

        .event-table th {
            background-color: #f2f2f2;
        }

        .event-table td button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .event-table td button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<?php require "partials/_nav.php" ?>
<div class="container">
    <div class="profile">
        <?php
        $select = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
        }

        // Display user profile image
        echo '<img src="istockphoto-1337144146-612x612.jpg">';
        ?>

        <h3><?php echo "Name: {$fetch['username']}"; ?></h3><br>
        
        <h3><?php echo "Email: {$fetch['email']}"; ?></h3><br>
        <h3><?php echo "Currently living in: {$fetch['city']}"; ?></h3><br>
        <h3><?php echo "Phone: {$fetch['phone']}"; ?></h3><br>
        <h3><?php echo "Type: {$fetch['type']}"; ?></h3><br>
        <h3>
            <?php
            if ($fetch['type'] == "Alumni") {
                echo "Profession: {$fetch['job']}<br>";
                echo "<br>";
                echo "Graduation: {$fetch['graduation_year']}<br>";
            }
            ?>
        </h3>

        <!-- Add event list which was created by the user from event table -->
        <h3>Events Created by You:</h3>
        <?php

        $sql = "SELECT * FROM event WHERE event_creator  = '{$fetch['username']}'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="event-table">';
            echo '<tr>';
            echo '<th>Event Name</th>';
            echo '<th>Event Date</th>';
            echo '<th>Event Time</th>';
            echo '<th>Event Venue</th>';
            echo '<th>Details</th>';
            echo '<th>Created</th>';
           
            echo '</tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['event_name'] . '</td>';
                echo '<td>' . $row['event_date'] . '</td>';
                echo '<td>' . $row['event_time'] . '</td>';
                echo '<td>' . $row['event_venue'] . '</td>';
                echo '<td>' . $row['details'] . '</td>';
                echo '<td>' . $row['created'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No events created by you.</p>';
        }
        ?>



<h3>Resource upload by You:</h3>

        <?php

        $sql = "SELECT * FROM resources WHERE r_adder  = '{$fetch['id']}'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="event-table">';
            echo '<tr>';
            echo '<th>Resource Name</th>';
            echo '<th>Resource URL</th>';
            
           
            echo '</tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['r_title'] . '</td>';
                echo '<td>' . $row['r_url'] . '</td>';
                
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No resources uploaded by you.</p>';
        }
        
        ?>






        <!-- Add Update Profile Button -->
        <a href="update_profile.php" class="btn btn-primary mt-3">Update Profile</a><br>
        <a href="logout.php" class="btn btn-danger mt-3">Log Out</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>