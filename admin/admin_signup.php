<?php
// Database connection
include_once "../connection.php";



// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminName = $_POST['admin_name'];
    $email = $_POST['admin_email'];
    $address = $_POST['admin_address'];
    $phone = $_POST['admin_phone'];
    $password = password_hash($_POST['admin_password'], PASSWORD_BCRYPT); // Hash the password

    // Check if email already exists
    $checkEmail = "SELECT * FROM admin WHERE admin_email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('This email is already registered. Please use a different email.');</script>";
    } else {

      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Proceed with registration
        $sql = "INSERT INTO admin (admin_name, admin_email, admin_image, admin_password, admin_phone, admin_address) 
                VALUES ('$adminName', '$email', '$target_file', '$password', '$phone', '$address')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New admin registered successfully');</script>";
            header("Location: ../index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
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
        *{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;
}

body{
  font-family: 'Arial', sans-serif;
  color: #333;
}

header{
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #bcd2fd;
  padding: 5px 5% 5px 0;
}

#logo{
  display: flex;
  justify-content: left;
  width: 300px;
  height: 100px;
}

#logo img{
  width: 100%;
  height: auto;
  object-fit: contain;
  transform: scale(1.8); /* Scale the logo up (adjust scale value as needed) */
  transform-origin: center; /* Adjust the origin point of the scaling */
}

.nav-links{
  list-style-type: none;
  display: flex;
  align-items: center;
  gap: 30px;
}

.nav-links a{
  text-decoration: none;
  color:#333;
  font-weight: 500;
}

#login-btn{
  padding: 10px 20px;
  border: 2px solid #2b55eb;
  border-radius: 20px;
  
}

#signup-btn{
  background-color: #2b55eb;
  color: white;
  padding: 10px 20px;
  border-radius: 20px;
  text-decoration: none;
}

.nav-links a:hover{
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
            <img src="../images/PetHugLogo.png">
        </div>
        <nav class="nav-bar">
            <ul class="nav-links">
                <li><a href="../index.php" class="<?php if ($current_page == 'index.php'){echo 'active';} ?>">Home</a></li>
                <li><a href="../about.php" class="<?php if($current_page == 'about.php'){echo 'active';} ?>">About Us</a></li>
                <li><a href="../services.php" class="<?php if($current_page == 'services.php'){echo 'active';} ?>">Services</a></li>
                <li><a href="../contact.php" class="<?php if($current_page == 'contact.php'){echo 'active';} ?>">Contact</a></li>
                <li><a id="login-btn" href="adminLogin.php">Log In</a></li>
                
            </ul>
        </nav>
    </header>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../css/register.css" type="text/css">
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('registerForm').addEventListener('submit', function(event) {
                const password = document.getElementById('admin_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;

                if (password !== confirmPassword) {
                    alert("Passwords do not match!");
                    event.preventDefault();
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Admin Registration</h2>
        <form action="admin_signup.php" method="POST" id="registerForm">
            <label for="admin_name">Admin Name:</label>
            <input type="text" id="admin_name" name="admin_name" required>

            <label for="admin_email">Email:</label>
            <input type="email" id="admin_email" name="admin_email" required>

            <label for="admin_phone">Phone Number:</label>
            <input type="text" id="admin_phone" name="admin_phone" maxlength="10" pattern="[0-9]{10}" required>

            <label for="admin_address">Address:</label>
            <input type="text" id="admin_address" name="admin_address" required>

            <label for="admin_password">Password:</label>
            <input type="password" id="admin_password" name="admin_password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*">


            <div class="button-group">
                <button type="submit" class="btn">Register</button>
                <button type="reset" class="btn reset">Reset</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
include_once "../footer.php";
?>