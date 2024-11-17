<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

require '../connection.php';
include_once 'header_admin.php';

// Fetch hospital details
$query = "SELECT * FROM hospital WHERE hospital_id = 1";
$result = $conn->query($query);
$hospital = $result->fetch_assoc();

// Handle form submission for updating charges
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hospital_charge = $_POST['hospital_fee'];
    //$hospital_charge = $_POST['hospital_charge'];
    //$hostel_charge_per_day = $_POST['hostel_charge_per_day'];
    //$service_charge = $_POST['service_charge'];

    /*$updateQuery = "UPDATE hospital_details 
                    SET hospital_charge = ?, hostel_charge_per_day = ?, service_charge = ? 
                    WHERE id = 1";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ddd", $hospital_charge, $hostel_charge_per_day, $service_charge);*/

    $updateQuery = "UPDATE hospital 
                    SET hospital_fee = ?
                    WHERE hospital_id = 1";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("d", $hospital_charge);
    $stmt->execute();
    //header("Location: admin_hospital_details.php");
    header("Location: hospital_info.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Hospital Details</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5faff; color: #333; }
        .container { max-width: 600px; margin: 50px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { color: #1e90ff; }
        label { display: block; margin-top: 15px; color: #555; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; margin-top: 8px; border-radius: 5px; border: 1px solid #ddd; }
        .btn { display: block; width: 100%; padding: 10px; margin-top: 20px; background-color: #1e90ff; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background-color: #1c86ee; }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Hospital Charges</h2>
    
    <!--<form method="POST" action="admin_hospital_details.php">-->
    <form method="POST" action="hospital_info.php">
        <label>Hospital Name:</label>
        <input type="text" value="<?= $hospital['hospital_name'] ?>" disabled>
        
        <label>Address:</label>
        <input type="text" value="<?= $hospital['address'] ?>" disabled>
        
        <label>Phone Number:</label>
        <input type="text" value="<?= $hospital['phone_number'] ?>" disabled>

        <label>Hospital Charge (Rs.):</label>
        <input type="number" name="hospital_fee" step="0.01" value="<?= $hospital['hospital_fee'] ?>" required>

        <!--
        <label>Hospital Charge (Rs.):</label>
        <input type="number" name="hospital_charge" step="0.01" value="<?= $hospital['hospital_charge'] ?>" required>
        
        <label>Hostel Charge per Day (Rs):</label>
        <input type="number" name="hostel_charge_per_day" step="0.01" value="<?//= $hospital['hostel_charge_per_day'] ?>" required>

        <label>Service Charge (Rs.):</label>
        <input type="number" name="service_charge" step="0.01" value="<?//= $hospital['service_charge'] ?>" required>-->

        
        <button type="submit" class="btn">Update Charges</button>
    </form>
</div>

</body>
</html>

<?php
include_once 'footer_admin.php';
?>
