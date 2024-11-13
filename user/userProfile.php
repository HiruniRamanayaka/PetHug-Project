<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: userLogin.php");
    exit();
}

require '../connection.php'; // Include the database connection file
include_once "header_user.php";

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$query = "SELECT * FROM user WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission to update user profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update the user details in the database
    $updateQuery = "UPDATE user SET user_first_name = ?, user_email = ?, user_phone = ?, user_address = ? WHERE user_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssii", $name, $email, $phone, $address, $user_id);

    if ($updateStmt->execute()) {
        $success_message = "Profile updated successfully!";
        // Refresh user details after updating
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    } else {
        $error_message = "Error updating profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7ff;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
    <script>
        function validateForm() {
            var name = document.forms["profileForm"]["name"].value;
            var email = document.forms["profileForm"]["email"].value;
            var phone = document.forms["profileForm"]["phone"].value;
            var address = document.forms["profileForm"]["address"].value;

            if (name == "" || email == "" || phone == "" || address == "") {
                alert("Please fill out all fields.");
                return false;
            }
            // Email format validation
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
            // Phone format validation (optional)
            var phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(phone)) {
                alert("Please enter a valid phone number (10 digits).");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<div class="container">
    <h2>User Profile</h2>

    <?php if (isset($success_message)) { echo "<div class='success'>$success_message</div>"; } ?>
    <?php if (isset($error_message)) { echo "<div class='error'>$error_message</div>"; } ?>

    <form name="profileForm" method="POST" onsubmit="return validateForm()">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['user_first_name']); ?>" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>
        </div>
        <div>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['user_phone']); ?>" required>
        </div>
        <div>
            <label for="address">Address:</label>
            <textarea name="address" rows="4" required><?php echo htmlspecialchars($user['user_address']); ?></textarea>
        </div>
        <div>
            <button type="submit">Update Profile</button>
        </div>
    </form>
</div>

</body>
</html>
<?php $conn->close(); ?>