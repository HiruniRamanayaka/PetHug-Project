<?php
session_start();
if (!isset($_SESSION['dr_id'])) {
    header("Location: doctor_login.php");
    exit();
}

include_once '../connection.php'; // Include the database connection file
include_once 'header_dr.php';

$doctor_id = $_SESSION['dr_id'];

// Fetch notifications
$sql_notifications = "SELECT * FROM notifications WHERE recipient_id = $doctor_id AND recipient_type = 'doctor' ORDER BY created_at DESC";
$result_notifications = $conn->query($sql_notifications);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Notifications - PetHug</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            margin: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2 {
            border-bottom: 2px solid #007BFF;
            padding-bottom: 10px;
        }

        .notification {
            background-color: #e9f5ff;
            border-left: 4px solid #007BFF;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .notification:hover {
            background-color: #d0e7ff;
        }

        .notification p {
            margin: 5px 0;
        }

        .notification-time {
            font-size: 0.85em;
            color: #666;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // You can add any additional JavaScript functionality here
            console.log("Notification page loaded.");
        });
    </script>
</head>
<body>
   
    <div class="container">
        <h2>Your Notifications</h2>
        <?php if ($result_notifications->num_rows > 0): ?>
            <?php while ($row = $result_notifications->fetch_assoc()): ?>
                <div class="notification">
                    <p><strong><?php echo htmlspecialchars($row['title']); ?></strong></p>
                    <p><?php echo htmlspecialchars($row['message']); ?></p>
                    <p class="notification-time"><?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No notifications at this time.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
include_once "footer_dr.php";   
?>

<?php $conn->close(); ?>