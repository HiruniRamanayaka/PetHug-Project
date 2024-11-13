<?php
session_start();
if (!isset($_SESSION['dr_id'])) {
    header("Location: doctor_login.php");
    exit();
}

require '../connection.php'; // Include the database connection file
include_once 'header_dr.php';

$doctor_id = $_SESSION['dr_id'];
$today = date('Y-m-d');

// Fetch today's accepted appointments
$acceptedQuery = "SELECT appointment.*, pet.pet_name, user.user_first_name AS pet_owner_name FROM appointment 
                  JOIN pet ON appointment.pet_id = pet.pet_id 
                  JOIN user ON appointment.user_id = user.user_id 
                  WHERE appointment.doctor_id = ? AND appointment.appointment_time = ? AND appointment.status = 'Accepted'";
$acceptedStmt = $conn->prepare($acceptedQuery);
$acceptedStmt->bind_param("is", $doctor_id, $today);
$acceptedStmt->execute();
$acceptedAppointments = $acceptedStmt->get_result();

// Fetch pending appointments
$pendingQuery = "SELECT appointment.*, pet.pet_name, user.user_first_name AS pet_owner_name FROM appointment 
                 JOIN pet ON appointment.pet_id = pet.pet_id 
                 JOIN user ON appointment.user_id = user.user_id 
                 WHERE appointment.doctor_id = ? AND appointment.status = 'Pending'";
$pendingStmt = $conn->prepare($pendingQuery);
$pendingStmt->bind_param("i", $doctor_id);
$pendingStmt->execute();
$pendingAppointments = $pendingStmt->get_result();

// Fetch canceled appointments
$canceledQuery = "SELECT appointment.*, pet.pet_name, user.user_first_name AS pet_owner_name FROM appointment 
                  JOIN pet ON appointment.pet_id = pet.pet_id 
                  JOIN user ON appointment.user_id = user.user_id 
                  WHERE appointment.doctor_id = ? AND appointment.status = 'Canceled'";
$canceledStmt = $conn->prepare($canceledQuery);
$canceledStmt->bind_param("i", $doctor_id);
$canceledStmt->execute();
$canceledAppointments = $canceledStmt->get_result();

// Handle button actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $appointment_id = $_POST['appointment_id'];
    $action = $_POST['action'];

    switch ($action) {
        case "accept":
            $updateQuery = "UPDATE appointment SET status = 'Accepted' WHERE appointment_id = ?";
            break;
        case "cancel":
            $updateQuery = "UPDATE appointment SET status = 'Canceled' WHERE appointment_id = ?";
            break;
        case "delete":
            $updateQuery = "DELETE FROM appointment WHERE appointment_id = ?";
            break;
        case "update_notes":
            $details = $_POST['details'];
            $updateQuery = "UPDATE appointment SET details = ?, status = 'Completed' WHERE appointment_id = ?";
            break;
        default:
            $updateQuery = ""; // No action matched
            break;
    }

    if (!empty($updateQuery)) {
        $updateStmt = $conn->prepare($updateQuery);
        if ($action === "update_notes") {
            $updateStmt->bind_param("si", $details, $appointment_id);
        } else {
            $updateStmt->bind_param("i", $appointment_id);
        }

        if ($updateStmt->execute()) {
            header("Location: assigned_appointments.php");
            exit();
        } else {
            $error_message = "Error updating appointment. Please try again.";
        }
    } else {
        $error_message = "No valid action provided.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management - PetHug</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7ff;
            margin: 0;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            margin-top: 50px;
            margin-bottom: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .accept-btn {
            background-color: #28a745;
            color: white;
        }
        .cancel-btn, .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        .update-notes-btn, .ShowNotes-btn {
            background-color: #007bff;
            color: white;
        }
        .notes-container {
            display: none;
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Appointment Management</h2>
    <?php if (isset($error_message)) { echo "<p style='color:red;text-align:center;'>$error_message</p>"; } ?>

    <!-- Today's Accepted Appointments -->
    <h3>Today's Accepted Appointments</h3>
    <table>
        <tr>
            <th>Appointment ID</th>
            <th>Pet Owner</th>
            <th>Pet Name</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $acceptedAppointments->fetch_assoc()) { 
            $datetime = new DateTime($row['appointment_time']);
            $date = $datetime->format("Y-m-d"); 
            $time = $datetime->format("H:i:s"); 
        ?>
            <tr>
                <td><?php echo $row['appointment_id']; ?></td>
                <td><?php echo $row['pet_owner_name']; ?></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $time; ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
                <td>
                   <form method="POST" style="display:inline;">
                      <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                      <input type="hidden" name="action" value="update_notes">
                      <textarea name="details" id="details_<?php echo $row['appointment_id']; ?>" placeholder="Enter notes..." required></textarea>
                     <button type="submit" class="update-notes-btn">Save Notes</button>
                   </form>
                </td>

            </tr>
        <?php } ?>
    </table>

    <!-- Pending Appointments -->
    <h3>Pending Appointments</h3>
    <table>
        <tr>
            <th>Appointment ID</th>
            <th>Pet Owner</th>
            <th>Pet Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Doctor Notes</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $pendingAppointments->fetch_assoc()) { 
            $datetime = new DateTime($row['appointment_time']);
            $date = $datetime->format("Y-m-d"); 
            $time = $datetime->format("H:i:s"); 
        ?>
            <tr>
                <td><?php echo $row['appointment_id']; ?></td>
                <td><?php echo $row['pet_owner_name']; ?></td>
                <td><?php echo $row['pet_name']; ?></td>
                <td><?php echo $date; ?></td>
                <td><?php echo $time; ?></td>
                <td>
                    <button class="ShowNotes-btn" onclick="showNotes(<?php echo $row['pet_id']; ?>)">Show Notes</button>
                    <div id="notes_<?php echo $row['pet_id']; ?>" class="notes-container">
                        <?php 
                        // Fetch all doctor notes related to the pet_id
                        $notesQuery = "SELECT appointment_reason FROM appointment WHERE pet_id = ? AND doctor_id = ? ORDER BY created_at DESC";
                        $notesStmt = $conn->prepare($notesQuery);
                        $notesStmt->bind_param("ii", $row['pet_id'], $doctor_id);
                        $notesStmt->execute();
                        $notesResult = $notesStmt->get_result();
                        
                        // Display all notes
                        if ($notesResult->num_rows > 0) {
                            while ($noteRow = $notesResult->fetch_assoc()) {
                                echo "<p>" . htmlspecialchars($noteRow['appointment_reason']) . "</p>";
                            }
                        } else {
                            echo "<p>No notes available for this pet.</p>";
                        }
                        ?>
                    </div>
                </td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                        <input type="hidden" name="action" value="accept">
                        <button type="submit" class="accept-btn">Accept</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                        <input type="hidden" name="action" value="cancel">
                        <button type="submit" class="cancel-btn">Cancel</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

 <!-- Canceled Appointments -->
<h3>Canceled Appointments</h3>
<table>
    <tr>
        <th>Appointment ID</th>
        <th>Pet Owner</th>
        <th>Pet Name</th>
        <th>Date</th>
        <th>Time</th>
        <th>Actions</th> <!-- Add Actions header -->
    </tr>
    <?php while ($row = $canceledAppointments->fetch_assoc()) { 
        $datetime = new DateTime($row['appointment_time']);
        $date = $datetime->format("Y-m-d"); 
        $time = $datetime->format("H:i:s"); 
    ?>
        <tr>
            <td><?php echo $row['appointment_id']; ?></td>
            <td><?php echo $row['pet_owner_name']; ?></td>
            <td><?php echo $row['pet_name']; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $time; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

</div>

<script>
function showNotes(petId) {
    var notesContainer = document.getElementById("notes_" + petId);
    if (notesContainer.style.display === "block") {
        notesContainer.style.display = "none";
    } else {
        notesContainer.style.display = "block";
    }
}
</script>

</body>
</html>

<!-- footer -->
<?php include_once "footer_dr.php"?>