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
            <img src="images/PetHugLogo.png">
        </div>
        <nav class="nav-bar">
            <ul class="nav-links">
                <li><a href="index.php" class="<?php if ($current_page == 'index.php'){echo 'active';} ?>">Home</a></li>
                <li><a href="about.php" class="<?php if($current_page == 'about.php'){echo 'active';} ?>">About Us</a></li>
                <li><a href="services.php" class="<?php if($current_page == 'services.php'){echo 'active';} ?>">Services</a></li>
                <li><a href="contact.php" class="<?php if($current_page == 'contact.php'){echo 'active';} ?>">Contact</a></li>
                
                <li><a id="signup-btn" href="signupAs.php">Sign Up</a></li>
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
    <title>Sign Up Selection - PetHug</title>
    <link rel="stylesheet" href="css/signupAs.css" type="text/css">
    
</head>
<body>
    <div class="container">
        <h2>Select Sign in Option</h2>
        <p>Please choose how you want to sign in:</p>
        <div class="button-group">
            <a href="User/userLogin.php"><button class="btn">Log in as User</button></a>
            <a href="Doctor/doctorLogin.php"><button class="btn">Log in as Doctor</button></a>
            <a href="Admin/adminLogin.php"><button class="btn">Log in as Admin</button></a>
        </div>
    </div>
</body>
</html>

<?php
include_once "footer.php";
?>