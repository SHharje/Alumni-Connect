<?php
session_start();
include 'partials/_dbconnect.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && isset($_POST['content'])) {
        // Handle new discussion posts
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_SESSION['id'];

        $sql=mysqli_query($conn, "INSERT INTO discussions (user_id, title, content) VALUES ('$user_id', '$title', '$content')");


        if (isset($sql)) {
            header("Location: discussion.php");
            exit();
        } else {
            echo "Error: " . $sql->error;
        }
    } elseif (isset($_POST['reply_content']) && isset($_POST['discussion_id'])) {
        // Handle replies
        $reply_content = $_POST['reply_content'];
        $discussion_id = $_POST['discussion_id'];
        $user_id = $_SESSION['id'];

        $sql = mysqli_query($conn, "INSERT INTO replies (discussion_id, user_id, content) VALUES ('$discussion_id', '$user_id', '$reply_content')");
        if (isset($sql)) {
            echo "Discussion posted!";
            header("Location: discussion.php");
            exit();
        } else {
            echo "Error: " . $sql->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Forum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        

        h1, h2, h3 {
            color: #555;
        }

        .container {
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 8px;
        }

        .discussion-form, .reply-form {
            margin-bottom: 20px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .discussion {
            margin-bottom: 40px;
        }

        .discussion h3 {
            margin: 0;
        }

        .discussion p {
            margin: 10px 0;
            color: #555;
        }

        .reply {
            margin-left: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
            border-left: 4px solid #5cb85c;
            margin-top: 10px;
        }

        .reply p {
            margin: 5px 0;
        }

        .logout-btn {
            background-color: #d9534f;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<?php require "partials/_nav.php" ?>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <!-- Logout Button -->
        <form action="logout.php" method="post">
            <button class="logout-btn" type="submit">Logout</button>
        </form>

        <hr>

        <div class="discussion-form">
            <h2>Start a New Discussion</h2>
            <form action="discussion.php" method="post">
                <input type="text" name="title" placeholder="Discussion Title" required><br>
                <textarea name="content" placeholder="Discussion Content" required></textarea><br>
                <input type="submit" value="Post Discussion">
            </form>
        </div>

        <h2>Discussions</h2>

        <?php
        $discussions = mysqli_query($conn,"SELECT d.*, u.username FROM discussions d JOIN users u ON d.user_id = u.id ORDER BY d.created_at DESC");

        while ($discussion = $discussions->fetch_assoc()) {
            echo '<div class="discussion">';
            echo '<h3>' . $discussion['title'] . ' <strong>by ' . $discussion['username'] . '</strong></h3>';

            echo '<p>' . $discussion['content'] . '</p>';

            // Display replies
            $discussion_id = $discussion['id'];
            $replies = mysqli_query($conn,"SELECT r.*, u.username FROM replies r JOIN users u ON r.user_id = u.id WHERE r.discussion_id = $discussion_id ORDER BY r.created_at ASC");


            if ($replies->num_rows > 0) {
                echo '<h4>Replies:</h4>';
                while ($reply = $replies->fetch_assoc()) {
                    echo '<div class="reply">';
                    echo '<p><strong>' . $reply['username'] . ':</strong> ' . $reply['content'] . '</p>';
                    echo '</div>';
                }
            }

            // Reply form
            echo '
            <div class="reply-form">
                <form action="discussion.php" method="post">
                    <input type="hidden" name="discussion_id" value="' . $discussion['id'] . '">
                    <textarea name="reply_content" placeholder="Write your reply..." required></textarea><br>
                    <input type="submit" value="Reply">
                </form>
            </div>
            </div>';
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</body>
</html>
