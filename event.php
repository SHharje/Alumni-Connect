<?php
session_start(); // Start the session

// Function to validate if the date is today or in the future
function isFutureDate($date) {
    $currentDate = new DateTime();
    $enteredDate = DateTime::createFromFormat('Y-m-d', $date);
    return $enteredDate >= $currentDate;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php'; // Include the database connection file

    // Check if the delete button was clicked
    if (isset($_POST['event_id'])) {
        $event_id = $_POST['event_id'];
        $delete_sql = "DELETE FROM event WHERE event_id='$event_id'";
        mysqli_query($conn, $delete_sql);
    } else {
        // Retrieve form data
        $event = $_POST["event"] ?? '';
        $date = $_POST["date"] ?? '';
        $time = $_POST["time"] ?? '';
        $venue = $_POST["venue"] ?? '';
        $details = $_POST["details"] ?? '';

        // Validate the date
        if (!isFutureDate($date)) {
            echo '<div style="text-align: center; color: red; font-weight: bold; font-size: 40px;">Invalid Date </div>';
        } else {
            // Check if the user is logged in
            if (isset($_SESSION['username'])) {
                $event_creator = $_SESSION['username'];

                // Get the user ID of the event creator
                $sql = "SELECT id FROM users WHERE username = '$event_creator'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $event_creator_id = $row['id'];

                // Insert the event into the database
                $sql = "INSERT INTO event (event_name, event_date, event_time, event_venue, created, event_creator, details, event_creator_id) 
                        VALUES ('$event', '$date', '$time', '$venue', current_timestamp(), '$event_creator', '$details', '$event_creator_id')";
                $result = mysqli_query($conn, $sql);

                // Check if the event was added successfully
                if ($result) {
                    echo '<div style="text-align: center; color: green; font-weight: bold; font-size: 20px;"> *event add hoise* </div>';
                    header("Location: event.php");
                    exit();
                } else {
                    echo '<div style="text-align: center; color: red; font-weight: bold; font-size: 40px;"> Event not added  </div>';
                }
            } else {
                echo '<div style="text-align: center;">User is not logged in.</div>';
            }
        }
    }
}
?>

<?php require "partials/_nav.php" // Include the navigation bar ?>

<div class="alert alert-success" role="alert" style="display: flex; flex-direction: column; align-items: center;">
    <h4 class="alert-heading">Hello <?php echo $_SESSION['username']; ?></h4> <!-- Display a greeting message with the username -->
    <p>Welcome to alumni website</p>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 1);
            width: 300px;
            margin: 20px auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, textarea, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="event.php" method="POST"> <!-- Form to add a new event -->
        <label for="event">Event Name:</label>
        <input type="text" id="event" name="event" required><br>

        <label for="details">Details:</label>
        <textarea id="details" name="details" required></textarea><br>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br>
        
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required><br>
        
        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" required><br>
        
        <button type="submit">Add Event</button>
    </form>

    <!-- Events list sorted based on event date and time -->
    <?php
    include 'partials/_dbconnect.php'; // Include the database connection file
    $sql = "SELECT * FROM event ORDER BY event_date, event_time"; // SQL query to select all events ordered by date and time
    $result = mysqli_query($conn, $sql); // Execute the query
    if (mysqli_num_rows($result) > 0) { // Check if there are any events
        echo '<div style="text-align: center; margin-top: 20px;">';
        echo '<h2 style="margin-bottom: 20px;">Events</h2>';
        echo '<table border="1" style="margin: 0 auto; border-collapse: collapse; width: 80%;">'; // Create a table to display the events
        echo '<tr style="background-color: #f2f2f2;">';
        echo '<th >Event Name</th>';
        echo '<th >Event Date</th>';
        echo '<th >Event Time</th>';
        echo '<th >Event Venue</th>';
        echo '<th >Event Creator</th>';
        echo '<th >Details</th>';
        echo '<th >Created</th>';
        echo '<th >Event Creator ID</th>';
        echo '<th >Action</th>';
        echo '</tr>';
        while ($row = mysqli_fetch_assoc($result)) { // Loop through the events
            echo '<tr>';
            echo '<td >' . $row['event_name'] . '</td>'; // Display event name
            echo '<td >' . date('d-M-y', strtotime($row['event_date'])) . '</td>'; // Display event date in d-m-y format
            echo '<td >' . $row['event_time'] . '</td>'; // Display event time
            echo '<td >' . $row['event_venue'] . '</td>'; // Display event venue
            echo '<td >' . $row['event_creator'] . '</td>'; // Display event creator
            echo '<td >' . $row['details'] . '</td>'; // Display event details
            echo '<td >' . date('d-M-y', strtotime($row['created'])) . '</td>'; // Display event creation date in d-m-y format
            echo '<td >' . $row['event_creator_id'] . '</td>'; // Display event creator ID

            // jodi user nijei login thake tahole tar creat kora event delete korte parbe
            if ($row['event_creator'] == $_SESSION['username']) {
                echo '<td >';
                echo '<form method="POST" action="">'; // Form to delete the event
                echo '<input type="hidden" name="event_id" value="' . $row['event_id'] . '">'; // Hidden input to store the event ID
                echo '<button type="submit">Delete</button>'; // Delete button
                echo '</form>';
                echo '</td>';
            } else {
                echo '<td ></td>'; // Empty cell if the event is not created by the logged-in user
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
    } else {
        echo '<div style="text-align: center; margin-top: 20px;">No events found</div>'; // Display a message if no events are found
    }
    ?>
</body>
</html>