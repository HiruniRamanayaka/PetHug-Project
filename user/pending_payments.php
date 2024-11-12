<?php
session_start();
include_once "../connection.php"; 

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch pending bills for the user
$sql = "SELECT bill_id, amount, date, method, status FROM bill WHERE user_id = $user_id AND status = 'Pending'";
$result = mysqli_query($conn, $sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Payments</title>
    <link rel="stylesheet" href="../afterLoginUser_style/pending_payments.css">
</head>
<body>
    <!--header-->
    <?php include_once "header_user.php"?>
    <div class="pending_payment">
        <h1>Pending Payment Details</h1>

        <table>
            <tr>
                <th>Bill ID</th>
                <th>Amount (Rs.)</th>
                <th>Date</th>
                <th>Payment Method</th>
                <th>Status</th>
            </tr>

            <?php
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                        <td>" . htmlspecialchars($row['bill_id']) . "</td>
                        <td>" . htmlspecialchars($row['amount']) . "</td>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                        <td>" . htmlspecialchars($row['method']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                    </tr>";
                }
            }else{
                echo "<p class='no-data'>No pending payments found for your account.</p>";
            }
            ?>
        </table>
    </div>

    <!--footer-->
    <?php include_once "footer_user.php"?>
</body>
</html>
