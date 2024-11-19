<?php
// Include the database connection file
include '../connection.php';
include 'header_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $message = $conn->real_escape_string($_POST['message']);
    $recipient_type = $conn->real_escape_string($_POST['recipient_type']);
    $recipient_id = isset($_POST['recipient_id']) ? $conn->real_escape_string($_POST['recipient_id']) : null;

    // Insert the notification into the database
    $sql = "INSERT INTO notifications (recipient_type, recipient_id, title, message) VALUES ('$recipient_type', '$recipient_id', '$title', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo "New notification created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notification</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #e0f7ff; 
            margin: 0; 
            padding: 0; 
        }

        .container { 
            margin: 20px auto;
            max-width: 600px; 
            background-color: #ffffff; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            padding: 20px; 
        }

        .container h2 { 
            color: #007BFF; 
            text-align: center;
        }

        .container label { 
            margin-top: 10px; 
            display: block; 
            color: #333; 
        }

        .container input[type="text"], .container input[type="number"], .container textarea, .container select { 
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }

        .container textarea { 
            height: 100px; 
        }

        .container button { 
            background-color: #007BFF; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            padding: 10px 20px; 
            cursor: pointer; 
            width: 100%; 
        }

        .container button:hover { 
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Notification</h2>
        <form id="notificationForm" method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <label for="recipient_type">Send to:</label>
            <select id="recipient_type" name="recipient_type" required>
                <option value="user">User</option>
                <option value="doctor">Doctor</option>
                <option value="both">Both</option>
            </select>

            <label for="recipient_id">Recipient ID (optional):</label>
            <input type="number" id="recipient_id" name="recipient_id" placeholder="Enter User/Doctor ID (optional)">

            <button type="submit">Send Notification</button>
        </form>
    </div>

    <?php
        include '../footer.php';
    ?>
</body>
</html>