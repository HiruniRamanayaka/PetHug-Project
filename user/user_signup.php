<?php

    include_once "../connection.php";

    $error_message = "";
    $success_message = "";

    if(isset($_POST['signup'])){

        $firstname = $_POST['user_first_name'];
        $lastname = $_POST['user_last_name'];
        $phone = $_POST['user_phone'];
        $address = $_POST['user_address'];
        $email = $_POST['user_email'];
        $password = $_POST['user_password'];
        $confirmpassword = $_POST['confirmpassword'];

    //Validation 
    if (empty($firstname) || empty($lastname) || empty($phone) || empty($address) || empty($email) || empty($password) || empty($confirmpassword)) {
        $error_message = "All fields are required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error_message = "Phone number must be 10 digits.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($password !== $confirmpassword) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if email already exists
        $email_check = "SELECT * FROM user WHERE user_email = '$email'";
        $result = mysqli_query($conn, $email_check);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Email already registered.";
        } else { 

            // Prepare the SQL statement
            $sql = "INSERT INTO user (user_first_name, user_last_name, user_phone, user_address, user_email, user_password) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if(mysqli_stmt_prepare($stmt,$sql)){
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $phone, $address, $email, $hashed_password);

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: user_login.php");
                    exit();
                } else {
                    $error_message = "Error: Could not execute the query.";
                }
            }else{
                $error_message = "Error: " . $stmt->error;
            }
            mysqli_stmt_close($stmt);
        }
    }
}
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup form</title>
    <link rel="stylesheet" href="../afterLoginUser_style/signup.css">
</head>
<body>
        <!-- Error and Success message containers -->
        <div class="error-box" id="error-message"><?php echo $error_message; ?></div>
        <div class="success-box" id="success-message"><?php echo $success_message; ?></div>

        <div class="form">
            <h2>Create your PetHug Account</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <input id="fname" type="text" name="user_first_name" placeholder="First Name"><br><br>
                <input id="lname" type="text" name="user_last_name" placeholder="Last Name"><br><br>
                <input id="pnumber" type="text" name="user_phone" placeholder="Phone Number"><br><br>
                <input id="address" type="text" name="user_address" placeholder="Address"><br><br>
                <input id="email" type="email" name="user_email" placeholder="Email"><br><br>
                <input id="password" type="password" name="user_password" placeholder="Password" maxlength="15"><br><br>
                <input id="confirmpassword" type="password" name="confirmpassword" placeholder="Confirm Password" maxlength="15"><br><br>
                <input id="submit" type="submit" name="signup" value="Sign up">
            </form>
        </div>
    
        <script>
        // Display messages if they exist
        const errorMessage = "<?php echo addslashes($error_message); ?>";
        const successMessage = "<?php echo addslashes($success_message); ?>";

        if (errorMessage) {
            const errorBox = document.getElementById('error-message');
            errorBox.style.display = 'block';
            errorBox.innerText = errorMessage;
        }

        if (successMessage) {
            const successBox = document.getElementById('success-message');
            successBox.style.display = 'block';
            successBox.innerText = successMessage;
        }
    </script>

</body>
</html>