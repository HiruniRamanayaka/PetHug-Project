<?php
include_once "../connection.php";


// Handling form submission
$registrationMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['dr_name'];
    $phone = $_POST['dr_phone'];
    $license = $_POST['license'];
    $specialization = $_POST['specialization'];
    $email = $_POST['dr_email'];
    $password = password_hash($_POST['dr_password'], PASSWORD_BCRYPT); // Hash the password

    // Check if email already exists
    $checkEmail = "SELECT * FROM doctor WHERE dr_email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Email already exists
        $registrationMessage = "This email is already registered. Please use a different email.";
    } else {

      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Insert data into the database
        $sql = "INSERT INTO doctor (dr_name, dr_phone, license_number, specialization, dr_email, doctor_image, dr_password) 
                VALUES ('$name', '$phone', '$license', '$specialization', '$email', '$target_file', '$password')";

        if ($conn->query($sql) === TRUE) {
            $registrationMessage = "Doctor registered successfully!";
            header("Location: ../index.php");
        } else {
            $registrationMessage = "Error: " . $sql . "<br>" . $conn->error;
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
                <li><a id="login-btn" href="doctorLogin.php">Log In</a></li>
                
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
    <title>Doctor Registration</title>
    <link rel="stylesheet" href="../css/register.css">
    <script src="doctorRegister.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Register as a Doctor</h2>
        <?php if (!empty($registrationMessage)): ?>
            <p class="<?php echo ($registrationMessage == 'Doctor registered successfully!') ? 'success' : 'error'; ?>">
                <?php echo $registrationMessage; ?>
            </p>
        <?php endif; ?>
        <form action="doctor_signup.php" method="POST" id="registerForm">
            <label for="dr_name">Name:</label>
            <input type="text" id="dr_name" name="dr_name" required>

            <label for="dr_phone">Phone Number:</label>
            <input type="text" id="dr_phone" name="dr_phone" maxlength="10" required>

            <label for="license">Doctor License:</label>
            <input type="text" id="license" name="license" required>

            <label for="specialization">Specialization:</label>
            <input type="text" id="specialization" name="specialization" required>

            <label for="dr_email">Email:</label>
            <input type="email" id="dr_email" name="dr_email" required>

            <label for="dr_password">Password:</label>
            <input type="password" id="dr_password" name="dr_password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" required>

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