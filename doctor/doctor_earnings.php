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
    $email = $_SESSION['dr_email'];

    $current_date = date('Y-m-d'); //2023-10-22
    //$current_date = date('2023-10-20');

    // Today's earnings from appointments
    $query = "
    SELECT SUM(d.dr_fee) AS appointment_earnings
    FROM appointment a
    JOIN doctor d ON a.doctor_id = d.dr_id
    WHERE a.doctor_id = $doctor_id AND a.status = 'Completed' AND DATE(appointment_time) = '$current_date'
    ";
    $result = mysqli_query($conn, $query);
    if ($result && $row = mysqli_fetch_assoc($result)) {
    if ($row['appointment_earnings'] !== null) {
        $appointmentEarnings = $row['appointment_earnings'];
        
    } else {
        $appointmentEarnings = 0;
    }
    } else {
    $appointmentEarnings = 0;
    }

    // Today's earnings from consultations
    $query = "
    SELECT SUM(d.dr_fee) AS consultation_earnings
    FROM consultation c
    JOIN doctor d ON c.dr_id = d.dr_id
    WHERE c.dr_id = $doctor_id AND c.status = 'Completed' AND DATE(consultation_time) = '$current_date'
    ";
    $result = mysqli_query($conn, $query);
    if ($result && $row = mysqli_fetch_assoc($result)) {
    if ($row['consultation_earnings'] !== null) {
        $consultationEarnings = $row['consultation_earnings'];
    } else {
        $consultationEarnings = 0;
    }
    } else {
    $consultationEarnings = 0;
    }

    // Today's earnings from hostel supervision
    $query = "
    SELECT SUM(dr_supervision_fee) AS hostel_earnings
    FROM hostel
    WHERE dr_id = $doctor_id AND status = 'Completed' AND '$current_date' BETWEEN start_date AND end_date
    ";
    $result = mysqli_query($conn, $query);
    if ($result && $row = mysqli_fetch_assoc($result)) {
    if ($row['hostel_earnings'] !== null) {
        $hostelEarnings = $row['hostel_earnings'];
    } else {
        $hostelEarnings = 0;
    }
    } else {
    $hostelEarnings = 0;
    }

    // Total earnings for today
    $totalEarnings = $appointmentEarnings + $consultationEarnings + $hostelEarnings;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Daily Earnings</title>
    <link rel="stylesheet" href="../afterLoginDoctor_style/doctor_earnings.css">
</head>
<body>

    <div class="container_earnings">
    <h1>Earnings for :  <?= $current_date ?></h1>
        <div class="earnings-info">
        <?php
            echo "<p>Today's earnings from appointments = <span>Rs. " . number_format($appointmentEarnings, 2) . "</span></p>";
            echo "<p>Today's earnings from consultations = <span>Rs. " . number_format($consultationEarnings, 2) . "</span></p>";
            echo "<p>Today's earnings from hostel supervision =  <span>Rs. " . number_format($hostelEarnings, 2) . "</span></p>";
            echo "<p class='total-earnings'>Total earnings for today = <span>Rs. " . number_format($totalEarnings, 2) . "</span></p>";
        ?>
        </div>
    </div>


</body>
</html>

<!-- footer -->
<?php include_once "footer_dr.php"?>

<?php $conn->close(); ?>