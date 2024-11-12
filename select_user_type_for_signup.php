<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = $_POST['user_type'];

    switch ($user_type) {
        case 'user':
            header("Location: user/user_signup.php");
            exit();
        case 'admin':
            header("Location: admin/admin_signup.php");
            exit();
        case 'doctor':
            header("Location: doctor/doctor_signup.php");
            exit();
        default:
            echo "Invalid user type selected.";
            exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup Selection</title>
    <link rel="stylesheet" href="../beforeLogin_style/userTypes.css">
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <p>Please select your user type:</p>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="user-type">
                <input type="radio" id="user" name="user_type" value="user" required>
                <label for="user">User</label>
            </div>
            <div class="user-type">
                <input type="radio" id="admin" name="user_type" value="admin" required>
                <label for="admin">Admin</label>
            </div>
            <div class="user-type">
                <input type="radio" id="doctor" name="user_type" value="doctor" required>
                <label for="doctor">Doctor</label>
            </div>
            <button type="submit">Continue</button>
        </form>
    </div>
</body>
</html>
