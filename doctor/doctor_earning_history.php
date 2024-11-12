<?php
session_start();
include_once "../connection.php";
//header
include_once "header_dr.php";

if (!isset($_SESSION['dr_id']) || !isset($_SESSION['dr_email'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctor_id = $_SESSION['dr_id'];

// Number of days to show earnings
$daysToShow = 7;

// Fetch earnings data for each day within the specified period
$earningsData = [];
for ($i = 0; $i < $daysToShow; $i++) {
    $date = date('Y-m-d', strtotime("-$i days"));

    // Appointments earnings
    $appointmentEarnings = 0;
    $query = "
        SELECT SUM(d.dr_fee) AS appointment_earnings
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.dr_id
        WHERE a.doctor_id = $doctor_id AND a.status = 'Accepted' AND DATE(appointment_time) = '$date'
    ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $appointmentEarnings = $row['appointment_earnings'] ?? 0;
    }

    // Consultations earnings
    $consultationEarnings = 0;
    $query = "
        SELECT SUM(d.dr_fee) AS consultation_earnings
        FROM consultation c
        JOIN doctor d ON c.dr_id = d.dr_id
        WHERE c.dr_id = $doctor_id AND c.status = 'Accepted' AND DATE(consultation_time) = '$date'
    ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $consultationEarnings = $row['consultation_earnings'] ?? 0;
    }

    // Hostel supervision earnings
    $hostelEarnings = 0;
    $query = "
        SELECT SUM(dr_supervision_fee) AS hostel_earnings
        FROM hostel
        WHERE dr_id = $doctor_id AND status = 'Accepted' AND '$date' BETWEEN start_date AND end_date
    ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $hostelEarnings = $row['hostel_earnings'] ?? 0;
    }

    // Total earnings for the day
    $totalEarnings = $appointmentEarnings + $consultationEarnings + $hostelEarnings;

    // Store earnings data for this date
    $earningsData[] = [
        'date' => $date,
        'appointmentEarnings' => $appointmentEarnings,
        'consultationEarnings' => $consultationEarnings,
        'hostelEarnings' => $hostelEarnings,
        'totalEarnings' => $totalEarnings,
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Earnings History</title>
    <link rel="stylesheet" href="../afterLoginDoctor_style/doctor_earning_history.css">
</head>
<body>

    <div class="container_earnings">
        <h1>Earnings History (Last <?= $daysToShow ?> Days)</h1>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Appointment Earnings (Rs.)</th>
                    <th>Consultation Earnings (Rs.)</th>
                    <th>Hostel Earnings (Rs.)</th>
                    <th>Total Earnings (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($earningsData as $data): ?>
                    <tr>
                        <td><?= $data['date'] ?></td>
                        <td><?= number_format($data['appointmentEarnings'], 2) ?></td>
                        <td><?= number_format($data['consultationEarnings'], 2) ?></td>
                        <td><?= number_format($data['hostelEarnings'], 2) ?></td>
                        <td><strong><?= number_format($data['totalEarnings'], 2) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</body>
</html>

<!-- footer -->
<?php include_once "footer_dr.php"?>

<?php $conn->close(); ?>