<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include_once 'header_admin.php';
require '../connection.php';

if (isset($_GET['cancel_success'])) {
    echo "<script>alert('Appointment cancelled successfully.');</script>";
} elseif (isset($_GET['cancel_error'])) {
    echo "<script>alert('Error cancelling appointment.');</script>";
}


// Handle deletion of feedback
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM feedback WHERE feedback_id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $message = "Feedback deleted successfully!";
    } else {
        $message = "Error deleting feedback: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch all feedback
$sql = "SELECT feedback_id, rating, feedback_text, created_at FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedback</title>
   <style> 
   body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

header {
    background-color: #0056b3;
    color: #fff;
    padding: 20px 10px;
    text-align: center;
}

main {
    padding: 20px;
}

.message {
    color: green;
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    margin-bottom: 20px;
}

table th, table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background-color: #007bff;
    color: white;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.delete-btn {
    color: #ff4d4d;
    text-decoration: none;
    font-weight: bold;
}

.delete-btn:hover {
    text-decoration: underline;
}

footer {
    background-color: #0056b3;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    margin-top: 20px;
}

   </style>
</head>
<body>
    <header>
        <h1>Manage Feedback</h1>
    </header>
    <main>
        <?php if (isset($message)) { ?>
            <p class="message"><?= $message; ?></p>
        <?php } ?>

        <?php if ($result->num_rows > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rating</th>
                        <th>Feedback</th>
                        <th>Submitted On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['feedback_id']; ?></td>
                            <td><?= $row['rating']; ?>/5</td>
                            <td><?= $row['feedback_text']; ?></td>
                            <td><?= date("F d, Y h:i A", strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="manage_feedback.php?delete_id=<?= $row['feedback_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No feedback available.</p>
        <?php } ?>
    </main>
    <footer>
        <p>&copy; 2024 PetHug Veterinary Hospital</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>
