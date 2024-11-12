<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include_once 'header_admin.php';
require '../connection.php';

// Function to get the count of entries based on a time period
function getCount($conn, $table, $column, $startDate, $endDate) {
    $query = "SELECT COUNT(*) AS count FROM $table WHERE $column BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Function to get earnings for each doctor
function getDoctorEarnings($conn) {
    $query = "SELECT doctor.dr_id, doctor.dr_name, SUM(appointment.amount) AS earning 
              FROM appointment
              JOIN doctor ON appointment.doctor_id = doctor.dr_id
              GROUP BY doctor.dr_id";
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Set date ranges for daily, monthly, yearly
$today = date("Y-m-d");
$firstDayOfMonth = date("Y-m-01");
$firstDayOfYear = date("Y-01-01");

// Get counts for each section
$reportData = [
    'daily' => [
        'user' => getCount($conn, 'user', 'created_at', $today, $today),
        'pet' => getCount($conn, 'pet', 'created_at', $today, $today),
        'doctor' => getCount($conn, 'doctor', 'created_at', $today, $today),
        'appointment' => getCount($conn, 'appointment', 'created_at', $today, $today),
        'hostel' => getCount($conn, 'hostel', 'created_at', $today, $today),
        'earning' => getDoctorEarnings($conn),
    ],
    'monthly' => [
        'user' => getCount($conn, 'user', 'created_at', $firstDayOfMonth, $today),
        'pet' => getCount($conn, 'pet', 'created_at', $firstDayOfMonth, $today),
        'doctor' => getCount($conn, 'doctor', 'created_at', $firstDayOfMonth, $today),
        'appointment' => getCount($conn, 'appointment', 'created_at', $firstDayOfMonth, $today),
        'hostel' => getCount($conn, 'hostel', 'created_at', $firstDayOfMonth, $today),
        'earning' => getDoctorEarnings($conn),
    ],
    'yearly' => [
        'user' => getCount($conn, 'user', 'created_at', $firstDayOfYear, $today),
        'pet' => getCount($conn, 'pet', 'created_at', $firstDayOfYear, $today),
        'doctor' => getCount($conn, 'doctor', 'created_at', $firstDayOfYear, $today),
        'appointment' => getCount($conn, 'appointment', 'created_at', $firstDayOfYear, $today),
        'hostel' => getCount($conn, 'hostel', 'created_at', $firstDayOfYear, $today),
        'earning' => getDoctorEarnings($conn),
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Report - PetHug Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f7f9fc; margin: 0; padding: 0; }
        .container { width: 80%; margin: auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #333; }
        .report-section { margin: 20px 0; }
        .report-section h3 { color: #007bff; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #007bff; color: #fff; }
        .earnings-table { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Report - PetHug</h2>
    
    <!-- Daily Report -->
    <div class="report-section">
        <h3>Daily Report</h3>
        <table>
            <tr><th>Users Added</th><td><?= $reportData['daily']['user'] ?></td></tr>
            <tr><th>Pets Added</th><td><?= $reportData['daily']['pet'] ?></td></tr>
            <tr><th>Doctors Added</th><td><?= $reportData['daily']['doctor'] ?></td></tr>
            <tr><th>Appointments Made</th><td><?= $reportData['daily']['appointment'] ?></td></tr>
            <tr><th>Hostels Booked</th><td><?= $reportData['daily']['hostel'] ?></td></tr>
        </table>
    </div>

    <!-- Monthly Report -->
    <div class="report-section">
        <h3>Monthly Report</h3>
        <table>
            <tr><th>Users Added</th><td><?= $reportData['monthly']['user'] ?></td></tr>
            <tr><th>Pets Added</th><td><?= $reportData['monthly']['pet'] ?></td></tr>
            <tr><th>Doctors Added</th><td><?= $reportData['monthly']['doctor'] ?></td></tr>
            <tr><th>Appointments Made</th><td><?= $reportData['monthly']['appointment'] ?></td></tr>
            <tr><th>Hostels Booked</th><td><?= $reportData['monthly']['hostel'] ?></td></tr>
        </table>
    </div>

    <!-- Yearly Report -->
    <div class="report-section">
        <h3>Yearly Report</h3>
        <table>
            <tr><th>Users Added</th><td><?= $reportData['yearly']['user'] ?></td></tr>
            <tr><th>Pets Added</th><td><?= $reportData['yearly']['pet'] ?></td></tr>
            <tr><th>Doctors Added</th><td><?= $reportData['yearly']['doctor'] ?></td></tr>
            <tr><th>Appointments Made</th><td><?= $reportData['yearly']['appointment'] ?></td></tr>
            <tr><th>Hostels Booked</th><td><?= $reportData['yearly']['hostel'] ?></td></tr>
        </table>
    </div>

    <!-- Doctor Earnings -->
    <div class="report-section earnings-table">
        <h3>Doctor Earnings</h3>
        <table>
            <thead>
                <tr><th>Doctor ID</th><th>Doctor Name</th><th>Earnings</th></tr>
            </thead>
            <tbody>
            <?php foreach ($reportData['yearly']['earning'] as $earn): ?>
                <tr>
                    <td><?= $earn['dr_id'] ?></td>
                    <td><?= htmlspecialchars($earn['dr_name']) ?></td>
                    <td>$<?= number_format($earn['earning'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

<!--footerr-->
<?php include_once 'footer_admin.php';?>
