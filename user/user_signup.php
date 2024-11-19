<?php
require_once "../connection.php";

$error_message = "";

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Check if email already exists
    $checkEmail = "SELECT * FROM user WHERE user_email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Email already exists
        $error_message = "This email is already registered. Please use a different email.";
    } else {
        // Proceed with registration if email is not found
        // Image upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
       

        // Insert data into the database
        $sql = "INSERT INTO user (user_first_name, user_last_name, user_email, user_image, user_address, user_phone, user_password) 
                VALUES ('$firstName', '$lastName', '$email', '$target_file', '$address', '$phone', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: userLogin.php");
            exit();
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
  <title>Signup Page</title>
  <link rel="stylesheet" href="../afterLoginUser_style/signup.css">
</head>
<body>
  <?php 
  if (!empty($error_message)) {
      echo "<div class='error_message'>" . $error_message . "</div>";
  }
  ?>
  <div class="container">
    <!-- Left Section -->
    <div class="left-section">
        <h1>Welcome to PetHug</h1>
        <p>Your partner in pet care and wellness.</p>
        <img src="../images/images.png" alt="Pets Illustration" class="left-image">
    </div>

    <!-- Right Section -->
    <div class="right-section">
      <h2> Create your PetHug Account </h2>
      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
          <label for="first_name">First Name:</label>
          <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
        </div>

        <div class="form-group">
          <label for="last_name">Last Name:</label>
          <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" id="address" name="address" placeholder="Enter your address" required>
        </div>

        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="form-group">
          <label for="confirm_password">Confirm Password</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter your confirm password" required>
        </div>

        <div class="form-group">
          <label for="image">Upload Image:</label>
          <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div class="form-actions">
          <div>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
          </div>
          <a href="#" class="forgot-password">Forgot Password?</a>
        </div>

        <div class="button-container">
          <button type="submit" class="btn-signin">Sign In</button>
          <button type="reset" class="btn reset">Reset</button>
        </div>
      </form>
      <p class="signup-link">Have an account? <a href="userLogin.php">Log In</a></p>
    </div>
  </div>
</body>
</html>
