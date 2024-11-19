<?php

session_start();
if (!isset($_SESSION['dr_id'])) {
    header("Location: doctorLogin.php");
    exit();
}

require '../connection.php'; // Include the database connection file
include_once 'header_dr.php';

$doctor_id = $_SESSION['dr_id']; // Assign doctor_id from session before using it in query


    if (isset($_POST['search'])) {
        $pet_id = $_POST['pet_id'];

        $sql = "
            SELECT 'Appointment' AS report_type, DATE(appointment_time) AS report_date, details AS report_details, d.dr_id, d.dr_name
            FROM appointment a
            INNER JOIN doctor d ON a.doctor_id = d.dr_id
            WHERE a.pet_id = $pet_id

            UNION ALL

            SELECT 'Consultation' AS report_type, DATE(consultation_time) AS report_date, details AS report_details, d.dr_id, d.dr_name
            FROM consultation c
            INNER JOIN doctor d ON c.dr_id = d.dr_id
            WHERE c.pet_id = $pet_id

            UNION ALL

            SELECT 'Hostel' AS report_type, end_date AS report_date, details AS report_details, d.dr_id, d.dr_name
            FROM hostel h
            INNER JOIN doctor d ON h.dr_id = d.dr_id
            WHERE h.pet_id = $pet_id

            ORDER BY report_date DESC
        ";

        $result = mysqli_query($conn, $sql);

        $conn->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet reports</title>
    <link rel="stylesheet" href="../afterLoginDoctor_style/doctor_view_report.css">
</head>
<body>
    
    <div class="container">
        <h2>Pet Reports</h2><br>
        
        <!-- Search Form -->
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <label for="pet_id">Enter Pet ID:</label>
            <input type="text" id="pet_id" name="pet_id" required>
            <button type="submit" name="search">Search</button>
        </form>
    
    <?php
        if (isset($result) && mysqli_num_rows($result) > 0) {
            echo "<h3>Reports for Pet ID: $pet_id</h3>";
            echo "<table>
                    <tr>
                        <th>Report Type</th>
                        <th>Report Date</th>
                        <th>Doctor ID</th>
                        <th>Doctor Name</th>
                        <th>Report Details</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['report_type']}</td>
                        <td>{$row['report_date']}</td>
                        <td>{$row['dr_id']}</td>
                        <td>{$row['dr_name']}</td>
                        <td>{$row['report_details']}</td>
                    </tr>";
            }
            echo "</table>";
        } else if (isset($pet_id)) {
            echo "<p>No reports found for Pet ID: $pet_id</p>";
        }
    ?>
    </div>

</body>
</html>

<!-- footer -->
<?php include_once "../footer.php" ?>