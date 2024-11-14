<?php
session_start();

// Include your database connection file
require '../connection.php'; // Ensure this connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query to fetch doctor data (fetching hashed password)
    $query = "SELECT dr_id, dr_password FROM doctor WHERE dr_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();

    if ($doctor && password_verify($password, $doctor['dr_password'])) {
        // Login successful
        $_SESSION['dr_id'] = $doctor['dr_id']; // Store doctor ID in session
        header("Location: doctor_home.php");
        exit();
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }
}
$conn->close();
?>

<?php
// Get the current page's file name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #bcd2fd;
            padding: 5px 5% 5px 0;
        }

        #logo {
            display: flex;
            justify-content: left;
            width: 300px;
            height: 100px;
        }

        #logo img {
            width: 100%;
            height: auto;
            object-fit: contain;
            transform: scale(1.8); /* Scale the logo up (adjust scale value as needed) */
            transform-origin: center; /* Adjust the origin point of the scaling */
        }

        .nav-links {
            list-style-type: none;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        #signup-btn {
            background-color: #2b55eb;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
        }

        .nav-links a:hover {
            color: #2b55eb;
        }

        .nav-links a.active {
            color: #2b55eb !important; /* Color for the active page */
            font-weight: bold; 
        }
    </style>
</head>
<body>
    
    <!--header section-->
    <header class="header">
        <div id="logo">
            <img src="../images/PetHugLogo.png" alt="PetHug Logo">
        </div>
        <nav class="nav-bar">
            <ul class="nav-links">
                <li><a href="../index.php" class="<?php if ($current_page == 'index.php'){echo 'active';} ?>">Home</a></li>
                <li><a href="../about.php" class="<?php if($current_page == 'about.php'){echo 'active';} ?>">About Us</a></li>
                <li><a href="../services.php" class="<?php if($current_page == 'services.php'){echo 'active';} ?>">Services</a></li>
                <li><a href="../contact.php" class="<?php if($current_page == 'contact.php'){echo 'active';} ?>">Contact</a></li>
                <li><a id="signup-btn" href="doctor_signup.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor Login</title>
        <link rel="stylesheet" href="../css/Login.css" type="text/css">
        
        <script>
            function validateForm() {
                var email = document.getElementById("email").value;
                var password = document.getElementById("password").value;
                var emailErrorMessage = document.getElementById("email-error-message");
                var passwordErrorMessage = document.getElementById("password-error-message");

                // Clear previous error messages
                emailErrorMessage.innerText = "";
                passwordErrorMessage.innerText = "";

                // Email validation
                if (email == "") {
                    emailErrorMessage.innerText = "Please enter your email.";
                    return false;
                }
                if (!validateEmail(email)) {
                    emailErrorMessage.innerText = "Please enter a valid email address.";
                    return false;
                }

                // Password validation
                if (password == "") {
                    passwordErrorMessage.innerText = "Please enter your password.";
                    return false;
                }

                return true; // All validations passed
            }

            function validateEmail(email) {
                var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        </script>
    </head>
    <body>

    <div class="container">
        <h2>Doctor Login</h2>
        <?php if (isset($error_message)) { echo "<div class='error'>$error_message</div>"; } ?>
        <form name="loginForm" method="POST" onsubmit="return validateForm()">
            <div>
                <div id="email-error-message" class="error"></div> <!-- Email error message -->
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
            </div>
            <div>
                <div id="password-error-message" class="error"></div> <!-- Password error message -->
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <div class="button-group">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
    </div>

    </body>
    </html>

<?php
include_once "../footer.php";
?>